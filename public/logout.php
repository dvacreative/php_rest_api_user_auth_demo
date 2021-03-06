<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require "../config/db_inc.php";
require './account_class.php';

session_start();

$account = new Account();

// try login with session cookie
try
{
	$login = $account->sessionLogin();
}
catch (Exception $e)
{
	echo $e->getMessage();
	die();
}

$account->logout();

// get rid of the cookie
if (isset($_COOKIE['PHPSESSID'])) {
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', '', [
		'expires' => time() - 3600, 
		'path' => '/',
		'secure' => true,
		'samesite' => 'None'
	]);
}

session_destroy();