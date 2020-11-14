<?php
function city($data, $with_stations = false)
{
    if (array_key_exists('image', $data)) {
        $data['image_url'] = IMAGES_URL . '/' . $data['image'];
    }
    if (array_key_exists('image', $data)) {
        $data['image_path'] = IMAGES_DIR . DS . $data['image'];
    }
    
    if ($with_stations) {
        $data['stations'] = cityStations($data['id'], ['created_at', 'DESC']);
    }

    return $data;
}

function addCity($fields)
{
    return insert('cities', $fields);
}

function updateCity($fields, $id)
{
    return update('cities', $fields, ['id', $id]);
}

function getCity($id)
{
    return city(get('cities', $id, 'id'));
}

function allCities($order = null, $limit = null)
{
    return getAll('cities', $order, $limit);
}

function cityBy($fields, $order = null, $limit = null)
{
    return where('cities', $fields, $operator = "=",  $order, $limit);
}

function deleteCity($id)
{
    $city = getCity($id);
    if (array_key_exists('image_path', $city)) {
        if (file_exists($city['image_path'])) {
            unlink($city['image_path']);
        }
    }
    return delete('cities', ['id', $id]);
}

function cityStations($id, $order = null, $limit = null)
{
    return stationBy(['city_id' => $id], $order, $limit);
}

function cityMeals($id, $order = null, $limit = null)
{
    return mealBy(['city_id' => $id], $order, $limit);
}