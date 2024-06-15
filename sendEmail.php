<?php
include_once("./functions.php");
session_start();

if (!isset($_GET['forget']) && !isset($_GET['forgetotp'])) {
    $getPass = file_get_contents("php://input");
    if (!empty($getPass)) {
        // Decode the JSON data
        $decoded = json_decode($getPass, true);
        $ranPass = $decoded['ranPass'];
        $otp = $decoded['OTP'];
        $email = $decoded['Email'];
    }
    //if ranpass is not emapty and otp is = sented then send email to user
    if ($ranPass !== null && $otp !== "sented") {

        // echo "OTP is sented";
        $emailString = '  <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Verify Your Email</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333333;
            }
            p {
                color: #555555;
            }
            .verification-code {
                font-size: 24px;
                font-weight: bold;
                color: #007bff;
            }
            .cta-button {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 20px;
                background-color: #007bff;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Please Verify Your Account</h1>
            <p>Dear [email] ,</p>
            <p>Thank you for choosing our Website! To ensure the security of your account, we have initiated the verification process.</p>
            <p class="verification-code">Your verification OTP is: <strong>[[ranPass]]</strong></p>
            <p>Please enter this OTP on the <a href="">Verification Page</a> to complete the verification process. If you did not request this code or have any concerns, please contact our support team immediately.</p>
            <a href="[Verification Page Link]" class="cta-button">Verify Now</a>
            <p>Thank you for using our Website! We appreciate your trust in us.</p>
            <p>Best regards,<br>Team.</p>
        </div>
    </body>
    </html>
    ';

        $emailString = str_replace('[email]', $email, $emailString);
        $emailString = str_replace('[ranPass]', $ranPass, $emailString);

        $response = array(
            "message" => "OTP is sented",
            "emailString" => $emailString,
            "email" => $email,
            "ranPass" => $ranPass
        );

        // Set the response content type as JSON
        header('Content-Type: application/json');

        // Echo the JSON response

        echo json_encode($response);
        exit();
    }
}
if (isset($_GET['forgetotp'])) {
    $getPass = file_get_contents("php://input");
    if (!empty($getPass)) {
        // Decode the JSON data
        $decoded = json_decode($getPass, true);
        $ranPass = $decoded['ranPass'];
        $otp = $decoded['OTP'];
        $email = $decoded['Email'];
    }
    //if ranpass is not emapty and otp is = sented then send email to user
    if ($ranPass !== null && $otp === "sented") {

        $emailString =  '  <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your OTP For PassWord Reset</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333333;
            }
            p {
                color: #555555;
            }
            .verification-code {
                font-size: 24px;
                font-weight: bold;
                color: #007bff;
            }
            .cta-button {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 20px;
                background-color: #007bff;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Your OTP For PassWord Reset </h1>
            <p>Dear [email],</p>
            <p>Thank you for choosing our Website! To ensure the security of your account, we have initiated the verification process.</p>
            <p class="verification-code">Your Password Reset OTP is: <strong>[[ranPass]]</strong></p>
            <p>Please enter this OTP on the <a href="">Forget Pass Page</a> to complete the verification process. If you did not request this code or have any concerns, please contact our support team immediately.</p>
            <a href="[Verification Page Link]" class="cta-button">Verify Now</a>
            <p>Thank you for using our Website! We appreciate your trust in us.</p>
            <p>Best regards,<br>Team.</p>
        </div>
    </body>
    </html>
    ';
        $emailString = str_replace('[email]', $email, $emailString);
        $emailString = str_replace('[ranPass]', $ranPass, $emailString);
        $response = array(
            "message" => "OTP is sented",
            "emailString" => $emailString,
            "email" => $email,
            "ranPass" => $ranPass,
            "successMsg" => "We Have Sented You A verification OTP On Your Email."
        );

        // Set the response content type as JSON
        header('Content-Type: application/json');

        // Echo the JSON response
        echo json_encode($response);
        exit();
    }
}
if (isset($_GET['forget'])) {
    $getPass = file_get_contents("php://input");
    if (!empty($getPass)) {
        
        // Decode the JSON data
        $decoded = json_decode($getPass, true);
        // $conn = connectDatabase("localhost", "root", "", "user_signup_info");
        $query = "SELECT * FROM `signup_info` WHERE `user_email` = '$decoded';";
        //user nu email serch ma lavu ane aagli proccees karvi
        $fireQuery = mysqli_query($conn, $query);
        $row = mysqli_num_rows($fireQuery);
        $result = mysqli_fetch_assoc($fireQuery);


        if ($row === 1 && $result['user_email'] === $decoded) {
            $_SESSION["email"] = $email = $result['user_email'];
            $success = array("type" => "success", "successId" => "otp_sended", "successMsg" => "We Are Sending You A verification OTP On Your Email.", "redirect" => "  ", "email" => "$email");
            echo json_encode($success);

            //close connection
            require_once('./close_conn.php');

            exit();
        }
        if ($row === 0) {
            $error = array("type" => "error", "errId" => "email_not_registered", "errMsg" => "This Email Is Not Registered", "redirect" => "");
            echo json_encode($error);

            //close connection
            require_once('./close_conn.php');

            exit();
        } else {
            $error = array("type" => "error", "errId" => "invalid_or_something_went_wrong", "errMsg" => "somthing went wrong.", "redirect" => "sign_in.php?sign_in");
            echo json_encode($error);

            //close connection
            require_once('./close_conn.php');

            exit();
        }
    } else {
        $error = array("type" => "error", "errId" => "somthing_went_wrong", "errMsg" => "somthing went wrong.", "redirect" => "sign_in");
        echo json_encode($error);

        //close connection
        require_once('./close_conn.php');

        exit();
    }
}
