<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";
if($_SERVER["REQUEST_METHOD"] == "GET"){
echo ' 
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script> 
    </head>
    <body>
        <nav class="navbar">
            <a href="index.php"><strong>Home</strong></a>
            <a href="myphotos.php">My Photos</a>
            <a href="upload.php">Upload Photo</a>
            <a href="account.php">Account</a>
            <a href="logout.php">Logout</a>
        </nav>
        <div class="content"></div>
    </body>
</html>';
}
else if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if the user is logged in, if not then redirect him to login page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            $userId = $_SESSION["id"];
            $sql = "SELECT photos.imageId, photos.description, photos.is_private, users.displayname FROM photos
                    INNER JOIN users ON photos.userId=users.id
                    WHERE is_private = ?;";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $onlyPublic = 0;

                $stmt->bind_param("i",$onlyPublic);
                $rows = array();
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    // Store result
                    $result = $stmt->get_result();
                    
                    // Check if username exists, if yes then verify password
                    while($row = $result->fetch_assoc()) {
                        $rows[] = $row;

                    }
                    echo json_encode($rows); 
            }
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
        }
    
    // Validate credentials
    
    
    // Close connection
    $mysqli->close();
}
?>