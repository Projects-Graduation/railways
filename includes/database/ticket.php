<?php
function ticket($data, $extra = [])
{
    if (array_key_exists('level_train_id', $data)) {
        $_level = trainLevel($data['level_train_id']);
        // dd($_level);
        $data['level'] = $_level;
        $data['level_name'] = $_level['level_name'];
        // foreach ($_level as $key => $value) {
        //     $data['level_' . $key] = $value;
        // }
    }
    
    if (array_key_exists('status', $data)){
        $statuses = [1 => 'في الإنتظار', 2 => 'مؤجلة', 3 => 'ملغية', 4 => 'منتهية'];
        $data['status_text'] = $statuses[$data['status']];
    }else{
        $data['status_text'] = 'غير معروفة';
    }

    
    if (array_key_exists('passenger_id', $data)) {
        $_passenger = getPassenger($data['passenger_id']);
        foreach ($_passenger as $key => $value) {
            $data['passenger_' . $key] = $value;
        }
    }
    
    if (array_key_exists('travel', $extra) && array_key_exists('travel_id', $data)) {
        $_travel = getTravel($data['travel_id']);
        foreach ($_travel as $key => $value) {
            $data['travel_' . $key] = $value;
        }
        $data['travel_link'] = "<a href='travel.php?travel_id=" . $data['travel_id'] . "' class='link'>رحلة " . $data['travel_id'] . "</a>";
    }
    
    if (array_key_exists('train', $extra) && array_key_exists('train_id', $data)) {
        $_train = getTrain($data['train_id']);
        foreach ($_train as $key => $value) {
            $data['train_' . $key] = $value;
        }
        $data['train_link'] = "<a href='train.php?train_id=" . $data['train_id'] . "' class='link'>قطار " . $data['train_name'] . "</a>";
    }
    
    if (array_key_exists('road', $extra) && array_key_exists('train_id', $data)) {
        $_train = getTrain($data['train_id']);
        $_road = getRoad($_train['road_id']);
        if (array_key_exists('road_id', $_train)) {
            foreach ($_road as $key => $value) {
                $data['road_' . $key] = $value;
            }
            $data['road_link'] = "<a href='road.php?road_id=" . $data['road_id'] . "' class='link'>طريقة " . $data['road_name'] . "</a>";
        }
    }
    
    
    return $data;
}
function getTicketStatus($status){
    $statuses = [1 => 'في الإنتظار', 2 => 'مؤجلة', 3 => 'ملغية', 4 => 'منتهية'];
    return $statuses[$status];
}
function addTicket($fields)
{
    return insert('tickets', $fields);
}

function updateTicket($fields, $ticket_id)
{
    return update('tickets', $fields, ['id', $ticket_id]);
}

function getTicket($ticket_id)
{
    return ticket(get('tickets', $ticket_id, 'id'));
}

function alltickets($order = null, $limit = null)
{
    return getAll('tickets', $order, $limit);
}

function ticketBy($fields, $order = null, $limit = null)
{
    return where('tickets', $fields, $operator = "=",  $order, $limit);
}

function deleteTicket($ticket_id)
{
    $old_image = getTicket($ticket_id)['image'];
    $result = delete('tickets', ['id', $ticket_id]);
    if($result){
        $old_image_path = IMAGES_DIR . DS . $old_image;
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }
    }
    
    return $result;
}

function levelTrainTickets($train_id, $level_id = null)
{
    $level_train = null;
    $_tickets = [];
    $tickets = [];
    if (is_null($level_id)) {
        $_tickets = ticketBy(['level_train_id' => $train_id], ['seat', 'ASC']);
    }else{
        $levels_trains = where('level_train', ['train_id' => $train_id, 'level_id' => $level_id], ['created_at', 'DESC'], 1);
        if ($levels_trains) {
            $level_train = $levels_trains[0];
        }

        if ($level_train) {
            $_tickets = ticketBy(['level_train_id' => $level_train['id']], ['seat', 'ASC']);
        }
    }

    foreach ($_tickets as $_ticket) {
        $tickets[] = ticket($_ticket);
    }


    return $tickets;
}