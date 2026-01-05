<?php session_start();
// Database Connection
include('includes/config.php');
//Validating Session
if(strlen($_SESSION['aid'])==0)
  { 
header('location:index.php');
}
else
// Code for Update  Sub Admin Details
if(isset($_POST['update'])){
$fname=$_POST['fullname'];
$email=$_POST['emailid'];
$mobileno=$_POST['mobilenumber'];
$adminid=intval($_SESSION['aid']);
$query=mysqli_query($con,"update tbladmin set AdminName='$fname',MobileNumber='$mobileno',Email='$email' where  ID='$adminid'");
if($query){
echo "<script>alert('Profile details updated successfully.');</script>";
echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
} else {
echo "<script>alert('Something went wron. Please try again.');</script>";
}
}
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PreSchool Enrollment System  | My Profile</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!--Function Email Availabilty---->
