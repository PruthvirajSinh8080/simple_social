<?php
include_once('./functions.php');
require_once('./conn.php');
session_start();

if (isset($_GET['verifyed'])) {
    $rawData = file_get_contents("php://input");
    $decoded = json_decode($rawData, true);
    $userEmail = $decoded['userEmail'];
    $status = $decoded['acStatus'];
    userAccountStatus($userEmail, $conn, $status);
    
    //close connection
    require_once('./close_conn.php');
    exit();
} else {
    $rawData = file_get_contents("php://input");
    $decoded = json_decode($rawData, true);
    // get all the information from the user using form.
    $userOrEmail =  htmlspecialchars($decoded['userOrEmail']);
    $user_pass =  htmlspecialchars($decoded['password']);
    verifyUserInfo($conn, $userOrEmail, $user_pass);

    //close connection
    require_once('./close_conn.php');
    exit();
}

require_once('./close_conn.php');
