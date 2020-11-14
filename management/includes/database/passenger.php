<?php
function passenger($data)
{
    return $data;
}

function addPassenger($fields)
{
    return insert('passengers', $fields);
}

function updatePassenger($fields, $id)
{
    return update('passengers', $fields, ['id', $id]);
}

function getPassenger($id)
{
    return passenger(get('passengers', $id, 'id'));
}

function allPassengers($order = null, $limit = null)
{
    return getAll('passengers', $order, $limit);
}

function passengerBy($fields, $order = null, $limit = null)
{
    return where('passengers', $fields, $operator = "=",  $order, $limit);
}

function deletePassenger($id)
{
    return delete('passengers', ['id', $id]);
}