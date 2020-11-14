<?php
function travel($data, $with_details = false)
{
    
    if (array_key_exists('road_id', $data)){
        $road = getRoad($data['road_id']);
        $data['road'] = $road;
        $data['road_name'] = $road['name'];
        $data['road_link'] = "<a href='road.php?road_id=" . $data['road_id'] . "' class='link'>" . $data['road_name'] . "</a>";
    }else{
        $data['road_name'] = 'لا يوجد';
        $data['road_link'] = '';
    }
    
    if (array_key_exists('status', $data)){
        $statuses = [1 => 'في الإنتظار', 2 => 'مؤجلة', 3 => 'ملغية', 4 => 'منتهية'];
        $data['status_text'] = $statuses[$data['status']];
    }else{
        $data['status_text'] = 'غير معروفة';
    }
    
    
    
    if (array_key_exists('train_id', $data)){
        $train = getTrain($data['train_id']);
        $data['train'] = $train;
        $data['train_name'] = $train['name'];
        $data['train_link'] = "<a href='train.php?train_id=" . $data['train_id'] . "' class='link'>" . $data['train_name'] . "</a>";
    }else{
        $data['train_name'] = 'لا يوجد';
        $data['train_link'] = '';
    }
    
    if (array_key_exists('departure_mode', $data)){
        $modes = [
        'am' => 'صباح',
        'pm' => 'مساء',
        ];
        $data['departure_mode_text'] = $modes[$data['departure_mode']];
    }else{
        $data['departure_mode_text'] = '';
    }
    
    if (array_key_exists('arrival_mode', $data)){
        $modes = [
        'am' => 'صباح',
        'pm' => 'مساء',
        ];
        $data['arrival_mode_text'] = $modes[$data['arrival_mode']];
    }else{
        $data['arrival_mode_text'] = '';
    }
    
    if (array_key_exists('departure_time', $data)){
        $data['departure_full_time'] = $data['departure_time'] . ' ' . $data['departure_mode_text'];
    }else{
        $data['departure_full_time'] = '';
    }
    
    if (array_key_exists('arrival_time', $data)){
        $data['arrival_full_time'] = $data['arrival_time'] . ' ' . $data['arrival_mode_text'];
    }else{
        $data['arrival_full_time'] = '';
    }
    
    
    return $data;
}

function addTravel($fields)
{
    return insert('travels', $fields);
}

function updateTravel($fields, $id)
{
    return update('travels', $fields, ['id', $id]);
}

function getTravel($id)
{
    return travel(get('travels', $id, 'id'));
}

function allTravels($travel = null, $limit = null)
{
    return getAll('travels', $travel, $limit);
}

function travelBy($fields, $travel = null, $limit = null)
{
    return where('travels', $fields, $operator = "=",  $travel, $limit);
}

function deleteTravel($id)
{
    $travel = getTravel($id);
    removeTravelTickets($id);
    $result = delete('travels', ['id', $id]);
    return $result;
}

function addTravelTickets($travel_id, $items)
{
    if (gettype($items) == 'array') {
        foreach ($items as $item) {
            $data = $item;
            if (!array_key_exists('travel_id', $data)) {
                $data['travel_id'] = $travel_id;
            }
            insert('tickets', $data);
        }
    }else{
        $data = $items;
        if (!array_key_exists('travel_id', $data)) {
            $data['travel_id'] = $travel_id;
        }
        insert('tickets', $data);
    }
}

function removeTravelTickets($travel_id)
{
    return deleteBy('tickets', ['travel_id' => $travel_id]);
}

function unSeenTravels($travel = null, $limit = null)
{
    return travelBy(['seen' => 0], $travel, $limit);
}

function availableTravels($date = null, $time = null, $mode = null)
{
    $departure_date = is_null($date) ? date('Y-m-d') : $date;
    // $departure_time = is_null($time) ? date('h:i') : $time;
    // $departure_mode = is_null($mode) ? date('a') : $mode;

    $_travels = travelBy(['departure_date' => $departure_date]);
    // $_travels = travelBy(['departure_date' => $departure_date, 'departure_time' => $departure_time, 'departure_mode' => $departure_mode]);
    $travels = [];

    foreach ($_travels as $_travel) {
        $travels[] = travel($_travel);
    }
    

    return $travels;
}


function travelTickets($travel_id, $level_id = null, $order = ['seat', 'ASC'], $limit = null)
{
    $level_train = null;
    $_tickets = [];
    $tickets = [];
    $fields = ['travel_id' => $travel_id];
    if(!is_null($level_id)) $fields['level_train_id'] = $level_id;
    
    $_tickets = ticketBy($fields, $order, $limit);
    
    foreach ($_tickets as $_ticket) {
        $tickets[] = ticket($_ticket);
    }


    return $tickets;
}