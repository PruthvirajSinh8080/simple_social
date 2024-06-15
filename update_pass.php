<?php
include_once("./functions.php");
require_once('./conn.php');
session_start();


$rawData =  file_get_contents("php://input", true);
$decoded = json_decode($rawData, true);
$newPass = $decoded['newPass'];
$user_pass_encryp_hash = password_hash(htmlspecialchars($newPass), PASSWORD_DEFAULT);
$email =  $_SESSION['email'];
// $conn = connectDatabase("localhost", "root", "", "user_signup_info");
$sql = "UPDATE `signup_info` SET `user_pass` = '$user_pass_encryp_hash' WHERE `user_email` = '$email';";

//user nu email serch ma lavu ane aagli proccees karvi
$fireQuery = mysqli_query($conn, $sql);

if (!$fireQuery) {
    $error = array("type" => "error", "errId" => "password_not_updated", "errMsg" => "Password Update Failed. Try Again.", "redirect" => "");
    echo json_encode($error);
    //close connection
    require_once('./close_conn.php');
    exit();
} else {
    $success = array("type" => "success", "successId" => "password_updated", "successMsg" => "Password Is Updated Successfully.", "redirect" => "sign_in",);
    //close connection
    require_once('./close_conn.php');
    echo json_encode($success);
    exit();
}


?>