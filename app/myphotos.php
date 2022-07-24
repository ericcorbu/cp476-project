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
    <script src="myphotos.js"></script> 
    </head>
    <body>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="myphotos.php"><strong>My Photos</strong></a>
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
        $decoded = json_decode(file_get_contents('php://input'), true);
        if(!isset($decoded["message"])){
           //echo var_dump($decoded);
            $userId = $_SESSION["id"];
            $sql = "SELECT photos.imageId, photos.description, photos.is_private, users.displayname FROM photos
                    INNER JOIN users ON photos.userId=users.id
                    WHERE userId = ?;";
            
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $userId);
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
                    //echo var_dump($_POST);
            }
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                $stmt->close();
            }
            }
            // if (isset($_POST['message']) && $_POST['message'] == "update")
            else  if (isset($decoded['message']) && $decoded['message'] == "update"){

                $sql = "UPDATE photos SET description = ?, is_private = ? WHERE imageId = ?";
                echo var_dump($decoded);
                if($stmt = $mysqli->prepare($sql)){
                    // Bind variables to the prepared statement as parameters

                    $newDescription = trim($decoded["description"]);
                    $imageId = trim($decoded["id"]);
                    $isPrivate = $decoded["is_private"];


                    $stmt->bind_param("sis", $newDescription, $isPrivate, $imageId);
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        echo json_encode(array("status"=>"success")); 
                }
                    else{
                        echo json_encode(array("status"=> "error")); 
                    }
        
                    // Close statement
                    $stmt->close();
                }
            }
            else  if (isset($decoded['message']) && $decoded['message'] == "delete"){

                $sql = "DELETE FROM photos WHERE imageId = ?";
                
                if($stmt = $mysqli->prepare($sql)){
                    $imageId = trim($decoded["id"]);
                    $stmt->bind_param("s", $imageId);
                    // Attempt to execute the prepared statement
                    if($stmt->execute()){
                        echo json_encode(array("status"=> "success")); 
                }
                    else{
                        echo json_encode(array("status"=> "error")); 
                    }
        
                    // Close statement
                    $stmt->close();
                }
            }
        }
    
    // Validate credentials
    
    
    // Close connection
    $mysqli->close();
}
?>