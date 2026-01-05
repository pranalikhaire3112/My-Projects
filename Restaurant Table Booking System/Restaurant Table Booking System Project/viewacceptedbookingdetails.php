<?php session_start();
//error_reporting(0);
// Database Connection
include('includes/config.php');
//Validating Session
if(strlen($_SESSION['aid'])==0)
  { 
header('location:index.php');
}
else
//Code For Updation the Enrollment
if(isset($_POST['submit'])){
$bid=intval($_GET['bid']);
$estatus=$_POST['status'];
$oremark=$_POST['officialremak'];
$tbaleid=$_POST['table'];
$bdate=$_POST['bdate'];
 $btime=strtotime($_POST['btime']);
$endTime = date("H:i:s", strtotime('+30 minutes', $btime));

$ret=mysqli_query($con,"SELECT * FROM tblbookings where ('$btime' BETWEEN time(bookingTime) and '$endTime' || '$endTime' BETWEEN time(bookingTime) and '$endTime' || bookingTime BETWEEN '$btime' and '$endTime') and tableId='$tbaleid' and bookingDate='$bdate' and boookingStatus='Accepted'");
 $count=mysqli_num_rows($ret);
if($count>0){
echo "<script>alert('Table already booked for given Date and Time. please choose another table');</script>";
} else{
$query=mysqli_query($con,"update tblbookings set adminremark='$oremark',boookingStatus='$estatus',tableId='$tbaleid' where id='$bid'");

if($query){
echo "<script>alert('Booking Details Updated   successfully.');</script>";
//echo "<script type='text/javascript'> document.location = 'manage-classes.php'; </script>";
} else {
echo "<script>alert('Something went wrong. Please try again.');</script>";
}

}
}

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restaurent Table Booking System  | Booking Details</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https:/
