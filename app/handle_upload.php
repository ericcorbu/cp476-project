<?php
// Start a session
session_start();
 
// verify user is logged in or redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
?>
<?php 
    $imageId = bin2hex(random_bytes(16)) . "." . pathinfo($_FILES['the_file']['name'], PATHINFO_EXTENSION);
    $userId = $_SESSION['id'];
    $description = $_POST["description"];
    $visibility = $_POST["visibility"];
    $is_private = FALSE;

    if ($visibility == 'private') {
        $is_private = TRUE;
    }

	// Try to move the uploaded file:
	if (move_uploaded_file ($_FILES['the_file']['tmp_name'], "./uploads/$imageId")) {

        $sql = "INSERT INTO photos (imageId, userId, description, is_private) VALUES (?, ?, ?, ?)";
	
		print '<p>Your file has been uploaded.</p>';
        print ($_SESSION['id']);
        print($imageId);
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sisi", $imageId, $userId, $description, $is_private);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
	
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