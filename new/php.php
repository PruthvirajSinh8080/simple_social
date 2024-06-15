<?php
// Get the raw POST data
$data = file_get_contents('php://input');

// Decode the JSON data
$decodedData = json_decode($data, true);
$name = $decodedData['uName'];
$email = $decodedData['email'];
$pass = $decodedData['pass'];

if($name == "suryraj" && $email !== ""  && $pass !== ""){
    $success = array("data"=>"user can login.", "status"=> "101");
    $successJSON = json_encode($success);
    echo $successJSON;
}else {
    $failed = array("data"=>"user can  not login.", "status"=> "404");
    $failedJSON = json_encode($failed);
    echo $failedJSON;
}

?>
