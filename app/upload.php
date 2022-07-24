<?php
// Start a session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
	<meta charset="utf-8">
	<title>Upload a Photo</title>
</head>
<body>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="myphotos.php">My Pictures</a>
            <a href="upload.php">Upload Picture</a>
            <a href="account.php">Account</a>
            <a href="logout.php">Logout</a>
        </nav>
<div class="content">
    <div class="default-container">
<form action="handle_upload.php" enctype="multipart/form-data" method="post" id="uploadform">
	<h3>Select a photo from your device:</h3>
	
	<p><input type="file" name="the_file" accept="image/*"></p>
    
        <label>Description</label>
        <br/>
        <textarea class="descriptionBox" form="uploadform" name="description" maxlength="280"></textarea>
        <br/>
        <input type="radio" name="visibility" value="public">Public
        <input type="radio" name="visibility" value="private" checked>Private
    
    </p>
	<p><input class="button" type="submit" name="submit" value="Upload Photo"></p>
</form>
</div>
</div>
</body>
</html> 