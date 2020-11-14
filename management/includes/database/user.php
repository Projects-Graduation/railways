<?php  
function userData($data)
{
	if (array_key_exists('type', $data)){
        $types = ['admin' => 'مدير', 'user' => 'مسخدم', 'delivery' => 'توصيل'];
        $data['type_text'] = $types[$data['type']];
    }
	return $data;
}
function addUser($fields)
{
	return insert('users', $fields);
}

function updateUser($fields, $id)
{
	return update('users', $fields, ['id', $id]);
}

function getUser($id)
{
	return get('users', $id, 'id');
}

function allUsers($order = null, $limit = null)
{
    return getAll('users', $order, $limit);
}

function userBy($fields, $order = null, $limit = null)
{
	return where('users', $fields, $operator = "=",  $order, $limit);
}

function deleteUser($id)
{
	return delete('users', ['id', $id]);
}

function login($username, $password)
{
	// $username = (int) filterInt($username);
	$user = userBy(['username' => $username], null, 1);
	// return var_dump($user);
	if ($user) {
		if($user['password'] === filterPW($password)) {
			$_SESSION['username'] = $user['username'];
			$_SESSION['id'] = $user['id'];
			$_SESSION['group_id'] = $user['group_id'];
			return true;
		}
		
	}

	return false;
}
