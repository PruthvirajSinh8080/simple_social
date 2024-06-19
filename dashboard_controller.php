<?php
include_once('./functions.php');
require_once('./conn.php');

session_start();


// $rawData = file_get_contents("php://input");
// $decoded = json_decode($rawData, true);

// providing defualt arguments 
$tableName = "posts";
$database = "user_signup_info";


// checks if table posts is present or not
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

// checks if table likes is present or not
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

// checks if table comments is present or not
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

// checks if table likes is present or not
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
    // if all table is present in db than this else condition will run to get post data
    $query = "SELECT 
    p.u_id,
    p.post_id,
    p.title,
    p.post_content,
    p.media_type,
    p.media,
    p.created_at,
    p.updated_at,
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = p.post_id) AS like_count,
    (SELECT COUNT(*) FROM shares WHERE shares.post_id = p.post_id) AS share_count,
    (SELECT user_name FROM signup_info WHERE signup_info.u_id = p.u_id) AS u_name ,
    (SELECT profile_pic FROM signup_info WHERE signup_info.u_id = p.u_id) AS user_profile_pic,
    COUNT(c.comment_id) AS comment_count
FROM posts p
LEFT JOIN comments c ON p.post_id = c.post_id
GROUP BY p.post_id
ORDER BY p.created_at DESC;";

//make connection and run query 
$result = mysqli_query($conn, $query);

// fetch data from server to send to frontend in json formate
if (mysqli_num_rows($result) > 0) {
    $posts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
    echo json_encode($posts); // JSON response
} else {
    echo json_encode([]); //  empty array if no results
}

// Close connection
mysqli_close($conn);

}
?>