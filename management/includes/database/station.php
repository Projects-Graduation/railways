<?php
function station($data)
{
    if (array_key_exists('image', $data)) {
        $data['image_url'] = IMAGES_URL . '/' . $data['image'];
    }
    
    if (array_key_exists('image', $data)) {
        $data['image_path'] = IMAGES_DIR . DS . $data['image'];
    }
    
    $data['city_name'] = getCity($data['city_id'])['name'];
    $data['city_link'] = "<a href='city.php?city_id=" . $data['city_id'] . "' class='link'>" . $data['city_name'] . "</a>";

    return $data;
}

function addStation($fields)
{
    return insert('stations', $fields);
}

function updateStation($fields, $station_id)
{
    return update('stations', $fields, ['id', $station_id]);
}

function getStation($station_id)
{
    return station(get('stations', $station_id, 'id'));
}

function allstations($order = null, $limit = null)
{
    return getAll('stations', $order, $limit);
}

function stationBy($fields, $order = null, $limit = null)
{
    return where('stations', $fields, $operator = "=",  $order, $limit);
}

function deleteStation($station_id)
{
    $old_image = getStation($station_id)['image'];
    $result = delete('stations', ['id', $station_id]);
    if($result){
        $old_image_path = IMAGES_DIR . DS . $old_image;
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }
    }

    return $result;
}