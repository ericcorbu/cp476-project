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
    </head>
    <body>
        <nav>
            <a href="/html/">Home</a> |
            <a href="/css/">My Pictures</a> |
            <a href="/js/">Upload Picture</a> |
            <a href="account.php">Account</a> |
            <a href="logout.php">Logout</a>
        </nav>
    </body>
</html>