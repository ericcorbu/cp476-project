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
	<meta charset="utf-8">
	<title>Upload a Photo</title>
</head>
<body>
        <nav>
            <a href="index.php">Home</a> |
            <a href="/css/">My Pictures</a> |
            <a href="upload.php">Upload Picture</a> |
            <a href="account.php">Account</a>
        </nav>
<form action="handle_upload.php" enctype="multipart/form-data" method="post" id="uploadform">
	<h3>Select a photo from your device:</h3>
	
	<p><input type="file" name="the_file"></p>
    
        <label>Description</label>
        <br/>
        <textarea form="uploadform" name="description"></textarea>
    
    </p>
	<p><input type="submit" name="submit" value="Upload Photo"></p>
</form>

</body>
</html> 