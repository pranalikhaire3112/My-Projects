<?php 
session_start();
include('includes/config.php'); // Database Connection

// Validating Session
if(strlen($_SESSION['aid']) == 0) { 
    header('location:index.php');
    exit();
}

// Code for Adding New Sub-Admin
if(isset($_POST['submit'])) {
    $username = trim($_POST['sadminusername']);
    $fname = trim($_POST['fullname']);
    $email = trim($_POST['emailid']);
    $mobileno = trim($_POST['mobilenumber']);
    $password = trim($_POST['inputpwd']);
    $usertype = '0';

    // Validate Inputs
    if(empty($username) || empty($fname) || empty($email) || empty($mobileno) || empty($password)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobileno)) {
        echo "<script>alert('Invalid mobile number. Must be 10 digits.');</script>";
    } else {
        // Hash Password Securely
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Use Prepared Statements to Prevent SQL Injection
        $stmt = $con->prepare("INSERT INTO tbladmin (AdminuserName, AdminName, MobileNumber, Email, Password, UserType) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $username, $fname, $mobileno, $email, $hashed_password, $usertype);
        
        if($stmt->execute()) {
            echo "<script>alert('Sub admin added successfully.');</script>";
            echo "<script>document.location = 'add-subadmin.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Table Booking System | Add Sub-Admin</title>
    
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme Style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">

    <!-- AJAX for Username Availability -->
    <script>
        function checkAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: { username: $("#sadminusername").val() },
                type: "POST",
                success: function(data) {
                    $("#user-availability-status").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {
                    alert("Error checking availability.");
                    $("#loaderIcon").hide();
                }
            });
        }
    </script>
</head>
<body>
<!-- Your HTML Form Here -->
</body>
</html>
