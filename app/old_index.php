<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <a href="index.php">Home</a>
            <a href="myphotos.php">My Pictures</a>
            <a href="upload.php">Upload Picture</a>
            <a href="account.php">Account</a>
            <a href="logout.php">Logout</a>
        </nav>
    </body>
</html>