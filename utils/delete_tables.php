<?php
    // YOUR DB CREDENTIALS
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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

    // Delete database
    $sql = "DROP DATABASE cp476project";
    if ($conn->query($sql) === TRUE) {
          echo "Database deleted successfully";
    } else {
          echo "Error deleting database: " . $conn->error;
    }
    $conn->close();
    

?>