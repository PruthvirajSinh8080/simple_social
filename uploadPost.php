<?php
include_once('./functions.php');
require_once('./conn.php');
session_start();


// Allowed file types and directory (adjust as needed)
$allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov');
$upload_dir = 'D:/Programming/xampp/htdocs/practices/images/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    try {


        // Trim post title and content
        $postTitle = trim($_POST['postTitle']);
        $postContent = trim($_POST['postContent']);
        $u_id = trim($_POST['u_id']);

        // Get file information
        $file = $_FILES['postMedia'];
        // print_r($file);
        $fileType = $_FILES['postMedia']['type'];

        // Debugging: Output file information
        // echo "File Information: <br>";
        // var_dump($file);
        // echo "<br>";

        // Validate file type
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            $error = "Invalid file type. Only images and videos are allowed.";
            echo json_encode(array('success' => false, 'error' => $error));
            exit;
        }

        // Validate file size (optional)
        if ($file['size'] > 50000000) { // 50 MB limit
            $error = "File size is too large. Maximum allowed size is 50 MB.";
            echo json_encode(array('success' => false, 'error' => $error));
            exit;
        }

        // Generate a unique filename
        $filename = uniqid('', true) . '.' . $file_ext;

        // Debugging: Output generated filename
        // echo "Generated Filename: $filename <br>";

        $conn->begin_transaction();
        try {
            // Initialize session upload progress
            $_SESSION[$filename] = array('start_time' => microtime(true));

            // Prepare and execute SQL statement
            $sql = "INSERT INTO posts (u_id,title, post_content, media_type, media) VALUES (?,?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $u_id, $postTitle, $postContent, $fileType, $filename);
            $stmt->execute();

            $progress = get_upload_progress($filename);
            // echo $progress;
            //upload file to server
            if (!move_uploaded_file($file['tmp_name'], $upload_dir . $filename)) {
                throw new Exception("Error uploading file to server.");
            }


            //commit transaction
            $conn->commit();
            $success = true;
            $success = array("type" => "success", "successId" => "post_upload_success", "successMsg" => "Your Post Is Uploaded Successfully.", "redirect" => "", 'percent' => $progress);
            $jsonSuccess = json_encode($success);
            echo $jsonSuccess;
        } catch (Exception $e) {
            //post upload a failed
            $error = array("type" => "error", "errorId" => "post_upload_failed", "errorMsg" => $e->getMessage(), "redirect" => "");
            $jsonError = json_encode($error);
            echo $jsonError;
        }
    } catch (Exception $e) {
        $error = "Error inserting post into database: " . $conn->error;

        $error = array("type" => "error", "errorId" => "post_upload_failed", "errorMsg" => "Your Post Is Upload Failed.", "redirect" => "");
        $jsonSuccess = json_encode($success);
        echo $jsonSuccess;
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        //close connection
        require_once('./close_conn.php');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $progress = get_upload_progress($filename);

    $success = array( "percent" => $progress);
    $jsonSuccess = json_encode($success);
    echo $jsonSuccess;
}
