<?php

session_start();
include('./functions.php');
require_once('./conn.php');


if (!isset($_SESSION["user_name"])) {
    $error_message = "You cannot use our site without proper login.";
    header("Location: ./sign_in.php?error=" . urlencode($error_message));
    exit();
}

if ($_GET['q'] == "getcomments") {
    // extract the info 
    $data = json_decode(file_get_contents("php://input"));
    $post_id = $data;


    try {

        $stmt = $conn->prepare("SELECT u.user_name, u.profile_pic, c.comment_text, c.commented_at
                                        FROM (
                                                SELECT * 
                                                FROM comments 
                                                WHERE post_id = ? 
                                                ORDER BY commented_at DESC 

                                                )c

                                                JOIN signup_info u ON c.u_id = u.u_id;");
        $stmt->bind_param("i", $post_id);
        //retrive comment from databse
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $response = [];
                //after the execution of the query the data is now gets fetchs
                while ($row = $result->fetch_assoc()) {
                    $response[] = [
                        'userName' => $row['user_name'],
                        'user_pic' => $row['profile_pic'],
                        'commentTime' => $row['commented_at'],
                        'comment_content' => $row['comment_text']
                    ];
                }
                $success = array("type" => "success", "successId" => "comment_loaded", "successMsg" => "Comment Has Been Loaded..", "redirect" => "", "comment_data" => $response);
                echo json_encode($success);
            } else {
                $error = array("type" => "error", "errorId" => "comment_not_loaded", "errorMsg" => "Comment Can't Be Loaded..", "redirect" => "");
                echo json_encode($error);
            }

            // on success this respones

        } else {
            errorRedirect("error_fetching_comments");
        }
    } catch (Exception $e) {
        $error = array("type" => "error", "errId" => "comment_not_loaded", "errMsg" => "Sorry Comment is Not loaded, Please Try Again in Some Time.", "redirect" => "");
        echo json_encode($error);
    } finally {
        // Close the statement
        $stmt->close();
    }
}

if ($_GET['q'] == "setcomments") {
    $data = json_decode(file_get_contents("php://input"));
    $post_id = $data->post_id;
    $text = $data->text;
    $u_id = $_SESSION['u_id'];

    try {
        $stmt = $conn->prepare("INSERT INTO `comments` 
        ( `post_id`, `u_id`, `comment_text`) VALUE (?,?,?)");

        $stmt->bind_param("iis", $post_id, $u_id, $text);

        // get newly added comment to show user
        if ($stmt->execute()) {
            $stmt = $conn->prepare("SELECT u.user_name, u.profile_pic, c.comment_text, c.commented_at
                                        FROM (
                                                SELECT * 
                                                FROM comments 
                                                WHERE u_id = ? 
                                                ORDER BY commented_at DESC 
                                                LIMIT 1
                                                )c

                                                JOIN signup_info u ON c.u_id = u.u_id;");
            $stmt->bind_param("i", $u_id);
            //retrive comment from databse
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    //after the execution of the query the data is now gets fetchs
                    $row = $result->fetch_assoc();
                }

                // on success this respones
                $success = array("type" => "success", "successId" => "comment_added", "successMsg" => "", "redirect" => "", "userName" => $row['user_name'], "user_pic" => $row['profile_pic'], "comment_content" => $row['comment_text'], "commentTime" => $row['commented_at']);
                echo json_encode($success);
            }
        } else {

            errorRedirect("no_comment_found");
        }
    } catch (Exception $e) {
        $error = array("type" => "error", "errId" => "comment_not_added", "errMsg" => "Sorry Comment is Not Added, Please Try Again in Some Time.", "redirect" => "");
        echo json_encode($error);
    } finally {
        // Close the statement
        $stmt->close();
    }
    ////////////////////////////////////////////////////////////////////////////////

}
