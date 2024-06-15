<?php

//database configuration
$host = "localhost";
$username = "root";
$pass = "";
$database = "user_signup_info";

//connect to mysql first
$conn = mysqli_connect($host, $username, $pass);
if (!$conn) {
    errorRedirect("failed_connection_server");
    return false;
}

//check if the database is created or not?
$db_check_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'";
$db_check_result = mysqli_query($conn, $db_check_query);

// If the database doesn't exist, create it
if (mysqli_num_rows($db_check_result) == 0) {
    $create_db_query = "CREATE DATABASE $database";
    if (!mysqli_query($conn, $create_db_query)) {
        errorRedirect("failed_create_database");
        return false;
    }
}



// Connect to the specified database
$conn = mysqli_connect($host, $username, $pass, $database);
if (!$conn) {
    errorRedirect("failed_connection_database");
    return false;
}

return $conn;
