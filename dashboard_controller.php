<?php
include_once('./functions.php');
require_once('./conn.php');

session_start();


$rawData = file_get_contents("php://input");
$decoded = json_decode($rawData, true);

$tableName = "posts";
$database = "user_signup_info";

if (!tableExists($conn, $tableName, $database)) {
    $createTableSQL = "CREATE TABLE `$tableName` (
        `post_id` INT(11) NOT NULL AUTO_INCREMENT,
        `u_id` INT(11) NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `post_content` TEXT NOT NULL,
        `media_type` VARCHAR(20) NOT NULL,
        `media` VARCHAR(255) NOT NULL, 
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`post_id`),
        FOREIGN KEY (`u_id`) REFERENCES `signup_info`(`u_id`) ON DELETE CASCADE
    ) ENGINE=InnoDB";

    if (!mysqli_query($conn, $createTableSQL)) {
        return false;
    }
}

$tableName = "likes";

if (!tableExists($conn, $tableName, $database)) {
    $createTableSQL = "CREATE TABLE `$tableName` (
    `like_id` INT(11) NOT NULL AUTO_INCREMENT,
    `post_id` INT(11) NOT NULL,
    `u_id` INT(11) NOT NULL,
    `liked_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`like_id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts`(`post_id`) ON DELETE CASCADE,
    FOREIGN KEY (`u_id`) REFERENCES `signup_info`(`u_id`) ON DELETE CASCADE
) ENGINE=InnoDB";

    if (!mysqli_query($conn, $createTableSQL)) {
        return false;
    }
}

$tableName = "comments";

if (!tableExists($conn, $tableName, $database)) {
    $createTableSQL = "CREATE TABLE `$tableName` (
    `comment_id` INT(11) NOT NULL AUTO_INCREMENT,
    `post_id` INT(11) NOT NULL,
    `u_id` INT(11) NOT NULL,
    `comment_text` TEXT NOT NULL,
    `commented_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`comment_id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts`(`post_id`) ON DELETE CASCADE,
    FOREIGN KEY (`u_id`) REFERENCES `signup_info`(`u_id`) ON DELETE CASCADE
) ENGINE=InnoDB";

    if (!mysqli_query($conn, $createTableSQL)) {
        return false;
    }
}

$tableName = "shares";

if (!tableExists($conn, $tableName, $database)) {

    $createTableSQL = "CREATE TABLE `$tableName` (
    `share_id` INT(11) NOT NULL AUTO_INCREMENT,
    `post_id` INT(11) NOT NULL,
    `u_id` INT(11) NOT NULL,
    `shared_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`share_id`),
    FOREIGN KEY (`post_id`) REFERENCES `posts`(`post_id`) ON DELETE CASCADE,
    FOREIGN KEY (`u_id`) REFERENCES `signup_info`(`u_id`) ON DELETE CASCADE
) ENGINE=InnoDB";

    if (!mysqli_query($conn, $createTableSQL)) {
        return false;
    }
} else {
    $query = "SELECT * FROM posts ;";
    $query_getPost = mysqli_query($conn, $query);
    $row = mysqli_num_rows($query_getPost);
    $result = mysqli_fetch_all($query_getPost);

    if ($row >= 10) {
        $postQuery = "SELECT * FROM posts ORDER BY RAND()LIMIT 10";
        $query_postQuery = mysqli_query($conn, $postQuery);
        $result = mysqli_fetch_all($query_getPost);
        if ($result) {

            //just for clarity
            $db_exist = "The Table Post Exist.";
            echo json_encode($db_exist);


            echo json_encode($result);
        } else {
            $error = array("type" => "error", "errId" => "no_data_found", "errMsg" => "No Data Found");
        }
    } else {
        echo json_encode($result);
    }
}
