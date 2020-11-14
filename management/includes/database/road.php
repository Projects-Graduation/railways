<?php
function road($data, $with_stations = false)
{
    return $data;
}

function addRoad($fields)
{
    return insert('roads', $fields);
}

function updateRoad($fields, $id)
{
    return update('roads', $fields, ['id', $id]);
}

function getRoad($id)
{
    return road(get('roads', $id, 'id'));
}

function allRoads($order = null, $limit = null)
{
    return getAll('roads', $order, $limit);
}

function roadBy($fields, $order = null, $limit = null)
{
    return where('roads', $fields, $operator = "=",  $order, $limit);
}

function deleteRoad($id)
{
    $road = getRoad($id);
    if (array_key_exists('image_path', $road)) {
        if (file_exists($road['image_path'])) {
            unlink($road['image_path']);
        }
    }
    removeRoadStations($id);
    $result = delete('roads', ['id', $id]);
    return $result;
}

function roadStations($id, $order = null, $limit = null)
{
    return stationBy(['road_id' => $id], $order, $limit);
}

function addRoadStations($road_id, $items)
{
    if (gettype($items) == 'array') {
        foreach ($items as $item) {
            $data = $item;
            if (!array_key_exists('road_id', $data)) {
                $data['road_id'] = $road_id;
            }
            insert('stations', $data);
        }
    }else{
        $data = $items;
        if (!array_key_exists('road_id', $data)) {
            $data['road_id'] = $road_id;
        }
        insert('stations', $data);
    }
}

function removeRoadStations($road_id)
{
    return deleteBy('stations', ['road_id' => $road_id]);
}

function roadCities($road_id)
{
    $roadStations = roadStations($road_id);
    $cities = [];
    foreach ($roadStations as $station) {
        $city_id = $station['city_id'];
        $in_array = array_filter($cities, function($value, $key) use($city_id){
            return $value['id'] == $city_id;
        }, ARRAY_FILTER_USE_BOTH);
        if (empty($in_array)) {
            $cities[] = getCity($city_id);
        }
    }
    return $cities;
    // return manyToMany(['table' => 'cities', 'pk' => 'id', 'fk' => 'city_id'], ['orders', 'id', 'order_id'], 'stations', ['road_id', $road_id], $order, $limit);
}