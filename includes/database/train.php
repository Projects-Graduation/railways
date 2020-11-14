<?php
function train($data, $with_levels = false)
{
    if (array_key_exists('image', $data)) {
        $data['image_url'] = IMAGES_URL . '/' . $data['image'];
    }
    if (array_key_exists('image', $data)) {
        $data['image_path'] = IMAGES_DIR . DS . $data['image'];
    }
    
    if ($with_levels) {
        $data['levels'] = trainLevels($data['id']);
    }
    
    return $data;
}

function addTrain($fields)
{
    return insert('trains', $fields);
}

function updateTrain($fields, $id)
{
    return update('trains', $fields, ['id', $id]);
}

function getTrain($id)
{
    return train(get('trains', $id, 'id'));
}

function allTrains($order = null, $limit = null)
{
    return getAll('trains', $order, $limit);
}

function trainBy($fields, $order = null, $limit = null)
{
    return where('trains', $fields, $operator = "=",  $order, $limit);
}

function deleteTrain($id)
{
    $train = getTrain($id);
    if (array_key_exists('image_path', $train)) {
        if (file_exists($train['image_path'])) {
            unlink($train['image_path']);
        }
    }
    removeTrainLevels($id);
    return delete('trains', ['id', $id]);
}

function trainLevel($data, $level_id = null)
{
    if (gettype($data) == 'array' && is_null($level_id)) {
        $level = getLevel($data['level_id']);
        foreach (array_keys($level) as $key) {
            if (is_string($key)) {
                $data['level_' . $key] = $level[$key];
            }
        }
        return $data;
    }
    elseif (gettype($data) !== 'array' && is_null($level_id)) {
        $level_train = get('level_train', $data);
        if (is_array($level_train)) {
            return trainLevel($level_train);
        }
    }
    elseif (gettype($data) !== 'array' && !is_null($level_id)) {
        $level_trains = where('level_train', ['level_id' => $level_id, 'train_id' => $data]);
        $level_train = $level_trains ? $level_trains[0] : false;
        if (is_array($level_train)) {
            return trainLevel($level_train);
        }
    }
    
}

function addTrainLevels($train_id, $levels)
{
    if (gettype($levels) == 'array') {
        if (array_key_exists('level_id', $levels)) {
            $data = $levels;
            if (!array_key_exists('train_id', $data)) {
                $data['train_id'] = $train_id;
            }
            insert('level_train', $data);
        }else{
            foreach ($levels as $level) {
                $data = $level;
                if (!array_key_exists('train_id', $data)) {
                    $data['train_id'] = $train_id;
                }
                insert('level_train', $data);
            }
        }
    }else{
        $data = $levels;
        if (!array_key_exists('train_id', $data)) {
            $data['train_id'] = $train_id;
        }
        insert('level_train', $data);
    }
}

function removeTrainLevels($train_id, $levels = null)
{
    if (is_null($levels)) {
        deleteBy('level_train', ['train_id' => $train_id]);
    }
    else if (gettype($levels) == 'array') {
        foreach ($levels as $level) {
            deleteBy('level_train', ['level_id' => $level, 'train_id' => $train_id]);
        }
    }else{
        deleteBy('level_train', ['level_id' => $levels, 'train_id' => $train_id]);
    }
}

function trainLevels($train_id, $order = null, $limit = null)
{
    $_levels = manyToMany(['table' => 'levels', 'pk' => 'id', 'fk' => 'level_id'], ['trains', 'id', 'train_id'], 'level_train', ['train_id', $train_id], $order, $limit);
    $levels = [];
    foreach ($_levels as $_level) {
        $levels[] = trainLevel($_level);
    }
    
    return $levels;
}