<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Include config file
require_once "config.php";
 
$oldpassword_err = "";
$newpassword_err = "";

$userId = $_SESSION["id"];

$get_user_info_query = "SELECT * FROM users WHERE id = ?";
$stmt= $mysqli->prepare($get_user_info_query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if (isset($_POST['displayname'])){
        $sql = "UPDATE users SET displayname = ? WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("ss", $trimmed_displayname,$userId);
            $trimmed_displayname = trim($_POST["displayname"]);
            if ($stmt->execute()) {
                echo "<script>alert('Display name changed successfully!')</script>";
                
            }
            else {
                echo "<script>alert('Display name change Failed!!')</script>";
            }
            $stmt->close();
            $mysqli->close();
        }  
    }
    else if (isset($_POST['oldpassword']) && isset($_POST['newpassword'])){
        $stored_oldpassword = "";
        $old_password = trim($_POST["oldpassword"]);
        $new_password = trim($_POST["newpassword"]);

        if ($old_password != "" && $new_password != "") {
            $sql = "SELECT password FROM users WHERE id = ?";
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i", $userId);
            if($stmt->execute()){
                $stmt->store_result();
                $stmt->bind_result($stored_oldpassword);
                if ($stmt->fetch() && password_verify($old_password, $stored_oldpassword)) {
                    $hashed_newpassword = password_hash($new_password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET password = ? WHERE id = ?";
                    if($stmt = $mysqli->prepare($sql)){
                        $stmt->bind_param("si", $hashed_newpassword,$userId);
                        if ($stmt->execute()) {
                            echo "<script>alert('Password changed successfully!')</script>";
                            
                        }
                        else {
                            echo "<script>alert('Password change Failed!!')</script>";
                        }
                }
                $stmt->close();
                $mysqli->close();
             } else {
                echo $old_password . $stored_oldpassword ."<script>alert('Old password is incorrect!!')</script>";
             }
        }  
    }

        } if ($old_password == "") {
            $oldpassword_err = "Password cannot be empty. Enter old password.";
        } if ($new_password == "") {
            $newpassword_err = "Password cannot be empty. Enter new password.";
        }

        
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" href="style.css">
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
            <div class="account-container">
        <h1>Update Account Info - @<?php echo $userData['username']?></h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Change Display Name</h2>
            <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="displayname" class="form-control" value="<?php echo $userData['displayname']; ?>">
            </div>
            <br/>
            <div class="form-group">
                <input type="submit" class="button" value="Update Display Name">
            </div>
        </form>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <h2>Change Password</h2>
            <div class="form-group">
                <label>Old Password</label>
                <input type="password" name="oldpassword" class="form-control">
                <span class="invalid-feedback"><?php echo $oldpassword_err; ?></span>
            </div>    
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="newpassword" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $newpassword_err; ?></span>
            </div>
            <br />
            <div class="form-group">
                <input type="submit" class="button" value="Update Password">
            </div>
        </form>
</div>
</div>
    </body>
</html>
