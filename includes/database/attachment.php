<?php
function attachment($data){
    if ($data['file']) {
        $data['file_url'] = ATTACHMENTS_URL . '/' . $data['file'];
    }
    if (!empty($data['customer_id'])) {
        $customer = getCustomer($data['customer_id']);
        $data['auth_name'] = $customer['name'];
    }
    else if (!empty($data['trainer_id'])) {
        $trainer = getTrainer($data['trainer_id']);
        $data['auth_name'] = $trainer['name'];
    }else{
        $user = getUser($data['user_id']);
        $data['auth_name'] = 'الإدارة';// $user['fullname'];
    }
    // $data['create_date'] = date('Y/m/d h:i a', strtotime($note['created_at']));
    return $data;
}
function addAttachment($fields)
{
    return insert('attachments', $fields);
}

function updateAttachment($fields, $id)
{
    return update('attachments', $fields, ['id', $id]);
}

function getAttachment($id)
{
    return get('attachments', $id, 'id');
}

function allattachments($order = null, $limit = null)
{
    return getAll('attachments', $order, $limit);
}

function attachmentBy($fields, $order = null, $limit = null)
{
    return where('attachments', $fields, $operator = "=",  $order, $limit);
}

function deleteAttachment($id)
{
    return delete('attachments', ['id', $id]);
}

function attachmentCourses($id, $order = null, $limit = null)
{
    return courseBy(['id' => $id], $order, $limit);
}


function attachmentCoursesBy($course_id, $date, $type = 'عامة')
{
    $ts = like('patients_courses', ['created_at' => $date], 'OR', ['created_at', 'DESC']);
    $courses = [];
    foreach ($ts as $t) {
        if (getAttachment(getcourse($t['course_id']))['type'] == $type) {
            $courses[] = $t;
        }
    }
    return $courses;
}