<?php
session_start();
include('./functions.php');
require_once('./conn.php');
//check if session is set or not
if (!isset($_SESSION["user_name"])) {
    $error_message = "You cannot use our site without proper login.";
    header("Location: ./sign_in.php?error=" . urlencode($error_message));
    exit();
}




//confirm that the request is for getting data from server not updating it
if ($_GET['q'] == "loadData") {
    $u_id = $_SESSION["u_id"];
    $query = "SELECT * FROM signup_info WHERE u_id = $u_id";
    $result = mysqli_query($conn, $query);
    //removing data that is not needed from result var
    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $respone =
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'dob' => $data['date_of_birth'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'zip_code' => $data['zip_code'],
                'country' => $data['country'],
                'profile_pic' => $data['profile_pic'],
                'about_me' => $data['about_me'],
                'last_online' => $data['last_online_time'],
                'response' => "true"
            ];
        //data is going to user profile
        echo json_encode($respone);
    } else {
        echo "cant get data";
    }
}

if ($_GET['q'] == "updateData") {
    if ($_FILES['profile_pic']['type'] == "image/jpeg" && $_FILES['profile_pic']['size'] <= 10000000) {

        //extracting file extension
        $file_ext = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));

        $upload_dir = "./images/";

        //seting file name
        $filename = uniqid('', true) . '.' . $file_ext;

        $conn->begin_transaction();
        try {
            //using stmt 
            $stmt = $conn->prepare("UPDATE `signup_info` SET 
            `first_name` = ?, 
            `last_name` = ?, 
            `date_of_birth` = ?, 
            `phone_number` = ?, 
            `address` = ?, 
            `city` = ?, 
            `state` = ?, 
            `zip_code` = ?, 
            `country` = ?, 
            `profile_pic` = ?, 
            `about_me` = ? 
          WHERE `u_id` = ?");

            $stmt->bind_param(
                "sssssssssssi",
                $_POST['first'],
                $_POST['last'],
                $_POST['dob'],
                $_POST['phone'],
                $_POST['address'],
                $_POST['city'],
                $_POST['state'],
                $_POST['zip'],
                $_POST['country'],
                $filename,
                $_POST['about_me'],
                $_SESSION['u_id']
            );

            $stmt->execute();

            if(!move_uploaded_file($_FILES['profile_pic']['tmp_name'],$upload_dir . $filename)){
                throw new Exception("Error uploading file to server.");
            }
            // commit the transection
            $conn->commit();
            $success = true;
            $success = array("type" => "success", "successId" => "profile_update_success", "successMsg" => "Your Profile Data Is Now Successfully Updated.", "redirect" => "",);
            $jsonSuccess = json_encode($success);
            echo $jsonSuccess;

        } catch (Exception $e) {
            $conn->rollback();
            //post upload a failed
            $error = array("type" => "error", "errorId" => "profile_update_failed", "errorMsg" => $e->getMessage(), "redirect" => "");
            $jsonError = json_encode($error);
            echo $jsonError;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
            //close connection
            require_once('./close_conn.php');
        }
    }
}
