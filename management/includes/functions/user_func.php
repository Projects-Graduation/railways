<?php 
function userIsAdmin()
{
	return isset($_SESSION['type']) && $_SESSION['type'] === 'admin' ? true : false;
}

function userIsDelivery()
{
	return isset($_SESSION['type']) && $_SESSION['type'] === 'delivery' ? true : false;
}

function userLogedIn()
{
	return isset($_SESSION['username']) && !empty($_SESSION['username']) ? true : false;
}
function user($column = null)
{
	$user = userLogedIn() ? getUser($_SESSION['id']) : false;
	if ($column && $user) {
		return $user[$column];
	}
	return $user;
}

function passwordChanged()
{
	return $_SESSION['defaultPassword'];
}

function isAdmin($type)
{
	return $type == 1 ? true : false;
}

function userInfo($id)
{
	return count(getUser($id)) ? getUser($id) : false;
}

function userImg($img = null)
{
	if (isset($img)) {
		echo '<img src="' . IMG_PATH . 'user' . DS . $img . '" alt="user-img" class="user-img pull-left"  align="middle">';
	}else {
		echo '<img src="' . IMG_PATH . 'user' . DS . user()['img'] . '" alt="user-img" class="user-img pull-left"  align="middle">';
	}
}