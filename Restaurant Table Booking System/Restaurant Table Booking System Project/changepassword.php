<?php
session_start();

// Database Connection
include('includes/config.php');

// Validating Session
if (!isset($_SESSION['aid']) || strlen($_SESSION['aid']) == 0) {
    header('location:index.php');
    exit();
}

// Code for Changing Password
if (isset($_POST['change'])) {
    $admid = $_SESSION['aid'];
    $cpassword = $_POST['currentpassword'];
    $newpassword = $_POST['newpassword'];

    // Fetch current password hash from the database
    $stmt = $con->prepare("SELECT Password FROM tbladmin WHERE ID = ?");
    $stmt->bind_param("i", $admid);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Verify current password
        if (password_verify($cpassword, $stored_password)) {
            // Hash new password before updating
            $newpassword_hash = password_hash($newpassword, PASSWORD_DEFAULT);

            $update_stmt = $con->prepare("UPDATE tbladmin SET Password = ? WHERE ID = ?");
            $update_stmt->bind_param("si", $newpassword_hash, $admid);

            if ($update_stmt->execute()) {
                echo '<script>alert("Your password was successfully changed.")</script>';
            } else {
                echo '<script>alert("Something went wrong. Please try again.")</script>';
            }
            $update_stmt->close();
        } else {
            echo '<script>alert("Your current password is incorrect.")</script>';
        }
    } else {
        echo '<script>alert("Admin account not found.")</script>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <form action="" method="POST">
        <label>Current Password:</label>
        <input type="password" name="currentpassword" required>
        
        <label>New Password:</label>
        <input type="password" name="newpassword" required>
        
        <label>Confirm New Password:</label>
        <input type="password" name="confirmpassword" required>
        
        <button type="submit" name="change">Change Password</button>
    </form>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            let newPassword = document.querySelector("input[name='newpassword']").value;
            let confirmPassword = document.querySelector("input[name='confirmpassword']").value;
            
            if (newPassword !== confirmPassword) {
                alert("New Password and Confirm Password do not match!");
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
