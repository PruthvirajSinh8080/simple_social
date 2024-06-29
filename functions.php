<?php
function showPage($page, $pageData = "")
{
    include_once("./$page.php");
}



// redirect user with err messages
function errorRedirect($err, $errMsg = "", $header = "")
{
    $_SESSION['err'] = $err;
    $_SESSION['errMsg'] = $errMsg;
    if (isset($_POST['user_name'])) {
        $_SESSION['name'] = $_POST['user_name'];
    }
    if (isset($_POST['user_email'])) {
        $_SESSION['email'] = $_POST['user_email'];
    }
    header("location: ./$header.php?$err");
}



function prevInputValue($id)
{
    if ($id == "name" && isset($_SESSION['name'])) {
        echo 'value ="' . $_SESSION['name'] . '"';
    } else if ($id == "email" && isset($_SESSION['email'])) {
        echo 'value ="' . $_SESSION['email'] . '"';
    } else {
        echo 'value =""';
    }
}

//check table exist or not
function tableExists($conn, $tableName, $database)
{
    //retrive table info from database
    $query = "SELECT TABLE_NAME FROM information_schema.TABLES 
              WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$tableName'";

    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// checks if the user exist or not
function checkUserExist($conn, $user_name, $user_email)
{
    $tableName = "signup_info";
    $database = "user_signup_info";
    if (!tableExists($conn, $tableName, $database)) {
        //db structure to be created if not present using this query
        $createTableSQL = "CREATE TABLE `$tableName` (`u_id` INT(11) NOT NULL AUTO_INCREMENT ,
         `user_name` VARCHAR(255) NOT NULL ,
         `user_email` VARCHAR(255) NOT NULL ,
         `user_pass` VARCHAR(255) NOT NULL ,
         `ac_status` INT(1) NOT NULL DEFAULT '0' ,
         `acc_create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
         `last_online_time` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
         `first_name` VARCHAR(100) NOT NULL,
         `last_name` VARCHAR(100) NOT NULL,
         `date_of_birth` DATE NOT NULL,
         `phone_number` VARCHAR(20) NOT NULL,
         `address` VARCHAR(255) NOT NULL,
         `city` VARCHAR(50) NOT NULL,
         `state` VARCHAR(50) NOT NULL,
         `zip_code` VARCHAR(10) NOT NULL,
         `country` VARCHAR(50) NOT NULL,
         `profile_pic` VARCHAR(255) NOT NULL,
          PRIMARY KEY (`u_id`),
          UNIQUE (`user_name`),
          UNIQUE (`user_email`)) ENGINE = InnoDB;
        ";

        if (!mysqli_query($conn, $createTableSQL)) {
            return false;
        }
    } else {
        $check_username_exist = "SELECT user_name,user_email FROM signup_info WHERE BINARY user_name = '$user_name' OR user_email = '$user_email';";
        $exist_or_not = mysqli_query($conn, $check_username_exist);

        if (mysqli_num_rows($exist_or_not)) {
            $error = array("type" => "error", "errId" => "user_name_exist", "errMsg" => "We Are Sorry. The user Already exists.", "redirect" => "signup");
            $jsonError = json_encode($error);
            echo $jsonError;
            return true;
        }
        return false;
    }
}

//insert the user info to database
function insertUserInfo($conn, $user_name, $user_email, $user_pass_encryp_hash)
{
    $sql = "INSERT INTO signup_info (user_name,user_email,user_pass) VALUES ('$user_name','$user_email','$user_pass_encryp_hash')";

    if (mysqli_query($conn, $sql)) {
        //query inserted succesfully
        mysqli_close($conn);


        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_pass_encryp_hash'] = $user_pass_encryp_hash;

        $success = array("type" => "success", "successId" => "user_registerd", "successMsg" => "User Registration Successfull.", "redirect" => "email_verification");
        $jsonSuccess = json_encode($success);
        echo $jsonSuccess;
        // header("location: ./sign_in.php");

    } else {
        //query didn't get inserted.
        errorRedirect("somthing_went_wrong");
        $error = array("type" => "error", "errId" => "somthing_went_wrong", "errMsg" => "somthing went wrong.", "redirect" => "signup");
        $jsonError = json_encode($error);
        echo $jsonError;
    }
}

// checks the entered info by user is accurate as par database so login user
function verifyUserInfo($conn, $userOrEmail, $user_pass)
{
    //query  to check the inserted user info is accurate or not?
    $query = "SELECT * FROM signup_info WHERE (BINARY user_name = '$userOrEmail' OR BINARY user_email = '$userOrEmail');";
    $query_verifyUserInfo = mysqli_query($conn, $query);
    $row = mysqli_num_rows($query_verifyUserInfo);
    $result = mysqli_fetch_assoc($query_verifyUserInfo);
    //result from database
    if ($row == 1) {
        //if row is euqal to 1 asign this all 
        if ($result) {
            $username = $result['user_name'];
            $email = $result['user_email'];
            $password = $result['user_pass'];
            $ac_status = $result['ac_status'];
            $u_id = $result['u_id'];

            // now check if the enterd info is accurate
            if ($ac_status == -1) {
                $error = array("type" => "error", "errId" => "user_banned", "errMsg" => "Sorry But This User Account Is Banned And Can Not Use Our Site Anymore.", "redirect" => "signup");
                echo json_encode($error);
                exit();
            } else if ($ac_status == 0) {
                $error = array("type" => "error", "errId" => "email_verification_panding", "errMsg" => "Please Verify your Email First.", "redirect" => "email_verification", "userEmail" => "$email", "preFix" => "verify");
                echo json_encode($error);
                exit();
            } else if ($ac_status == 1  && password_verify($user_pass, $password) && ($userOrEmail == $username || $userOrEmail == $email)) {
                $_SESSION['user_name'] = $username;
                $_SESSION['user_email'] = $email;
                $_SESSION['u_id'] =  $u_id;
                $success = array("type" => "success", "successId" => "verified", "successMsg" => "User Verification Successfull.", "redirect" => "registration_success", "u_id" => "$u_id");
                echo json_encode($success);
                exit();
            } else {
                $error = array("type" => "error", "errId" => "verification failed", "errMsg" => "UserInfo Is Not Valid", "redirect" => "");
                echo json_encode($error);
                //if more than 1 or less than 1 row gets in output throw error
                exit();
            }
        } else {
            // Handle the case where $result is null
            $error = array("type" => "error", "errId" => "no_such_user_found", "errMsg" => "No User Found", "redirect" => "");
            echo json_encode($error);
            exit();
        }
    } else {
        $error = array("type" => "error", "errId" => "row !== 1", "errMsg" => "row == 1 else statment", "redirect" => "sign_in");
        echo json_encode($error);
        exit();
    }
}


//------------email verification done----------

function userAccountStatus($userEmail, $conn, $status)
{
    $query = "UPDATE `signup_info` SET `ac_status` = $status WHERE `user_email` = '$userEmail';";

    $query_userAccountStatus = mysqli_query($conn, $query);
    if ($query_userAccountStatus) {
        $success = array("type" => "success", "successId" => "email_verified", "successMsg" => "User Email Verification Successfull.", "redirect" => "sign_in",);
        echo json_encode($success);
        exit();
    }
}

//

function get_upload_progress()
{
    $total_size = $_FILES['postMedia']['size'];
    $upload_size = filesize($_FILES['postMedia']['tmp_name']);
    $percent = round(($upload_size / $total_size) * 100, 2);
    // print_r(['persent' => $percent , 'total_size' => $total_size , 'upload_size' => $upload_size]);
    return $percent;
}
