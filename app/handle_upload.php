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
<?php // Script 11.4 - upload_file.php
/* This script displays and handles an HTML form. This script takes a file upload and stores it on the server. */
    $imageId = bin2hex(random_bytes(16)) . "." . pathinfo($_FILES['the_file']['name'], PATHINFO_EXTENSION);
    $userId = $_SESSION['id'];
    $description = $_POST["description"];

	// Try to move the uploaded file:
	if (move_uploaded_file ($_FILES['the_file']['tmp_name'], "./uploads/$imageId")) {
	
		print '<p>Your file has been uploaded.</p>';
        print ($_SESSION['id']);
        print($imageId);
	
	} else { // Problem!

		print '<p style="color: red;">Your file could not be uploaded because: ';
		
		// Print a message based upon the error:
		switch ($_FILES['the_file']['error']) {
			case 1:
				print 'The file exceeds the upload_max_filesize setting in php.ini';
				break;
			case 2:
				print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form';
				break;
			case 3:
				print 'The file was only partially uploaded';
				break;
			case 4:
				print 'No file was uploaded';
				break;
			case 6:
				print 'The temporary folder does not exist.';
				break;
			default:
				print 'Something unforeseen happened.';
				break;
		}
		
		print '.</p>'; // Complete the paragraph.

	} // End of move_uploaded_file() IF.
	
// Leave PHP and display the form:
?>