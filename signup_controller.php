<?php
include_once('./functions.php');
require_once('./conn.php');
session_start();


$rawData = file_get_contents("php://input");
$decoded = json_decode($rawData,true);

$user_name = htmlspecialchars($decoded['username']);
$user_email = htmlspecialchars($decoded['email']);
$user_pass = htmlspecialchars($decoded['password']);
$user_pass_encryp_hash = password_hash( htmlspecialchars( $user_pass), PASSWORD_DEFAULT);


if (!checkUserExist($conn, $user_name, $user_email)) {
    insertUserInfo($conn, $user_name, $user_email,$user_pass_encryp_hash);
}


?>
