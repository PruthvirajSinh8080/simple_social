<?php
include_once('./functions.php');
require_once('./conn.php');
session_start();

$postData = file_get_contents('php://input');
$data = json_decode($postData, true);
$post_id = $data['postId'];
$u_id = $_SESSION['u_id'];
// echo $post_id . "   " . $u_id;




$query = "SELECT * FROM likes WHERE post_id = $post_id AND u_id = $u_id";

$result = mysqli_query($conn, $query);
if (!$result) {  
    echo "Error: ". mysqli_error($conn);  
    exit;  
} 
// checks if the user have already liked the post or not
if (mysqli_num_rows($result) > 0) {
    // if yes than unlike the post 
    $query = "DELETE FROM likes WHERE post_id = $post_id AND u_id = $u_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $error = array("type" => "error", "errorId" => "post_unliked", "errorMsg" => "post unliked", "redirect" => "");
        echo json_encode($error);
    }
} else {
    //if no then like the post
    $query = "INSERT INTO likes (post_id, u_id) VALUES ($post_id, $u_id)";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $success = array("type" => "success", "successId" => "post_liked", "successMsg" => "post liked", "redirect" => "");
        echo json_encode($success);
    }
}
