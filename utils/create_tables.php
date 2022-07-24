<?php
    // YOUR DB CREDENTIALS
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // connect to MySQL server
    try {
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        echo "Connected to MySQL server \n";
        $conn->set_charset("utf8mb4");
    } catch(Exception $e) {
        error_log($e->getMessage());
        exit('Error connecting to database'); 
    }

    // execute queries
    $CREATE_DB = "CREATE DATABASE cp476project;";
    $USE_DB = "USE cp476project;";
    $CREATE_USERS_TABLE = "CREATE TABLE users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        displayname VARCHAR(100) NOT NULL
        );";

    $CREATE_PHOTOS_TABLE = "CREATE TABLE photos (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        userid INT NOT NULL,
        description VARCHAR(255)
        );";


        
    $db_operations = array($CREATE_DB, $USE_DB, $CREATE_USERS_TABLE);
    $is_error = FALSE;
    foreach($db_operations as $operation) {
        if($conn->query($operation) != TRUE) {
            $is_error = TRUE;
        }
    }
    if ($is_error === FALSE) {
          echo "Database created successfully";
    } else {
          echo "Error creating database: " . $conn->error;
    }
    $conn->close();
    

?>