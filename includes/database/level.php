<?php
function level($data)
{
    return $data;
}

function addLevel($fields)
{
    return insert('levels', $fields);
}

function updateLevel($fields, $id)
{
    return update('levels', $fields, ['id', $id]);
}

function getLevel($id)
{
    return level(get('levels', $id, 'id'));
}

function allLevels($order = null, $limit = null)
{
    return getAll('levels', $order, $limit);
}

function levelBy($fields, $order = null, $limit = null)
{
    return where('levels', $fields, $operator = "=",  $order, $limit);
}

function deleteLevel($id)
{
    $level = getLevel($id);
    if (array_key_exists('image_path', $level)) {
        if (file_exists($level['image_path'])) {
            unlink($level['image_path']);
        }
    }
    return delete('levels', ['id', $id]);
}