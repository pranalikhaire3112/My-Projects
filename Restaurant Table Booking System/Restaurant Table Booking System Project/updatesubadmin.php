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
$subadminid=intval($_GET['said']);
$query=mysqli_query($con,"update tbladmin set AdminName='$fname',MobileNumber='$mobileno',Email='$email' where UserType=0 and ID='$subadminid'");
if($query){
echo "<script>alert('Sub admin details added successfully.');</script>";
echo "<script type='text/javascript'> document.location = 'manage-subadmins.php'; </script>";
} else {
echo "<script>alert('Something went wrong. Please try again.');</script>";
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restaurent Table Booking System | Edit/Update Sub admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!--Function Email Availabilty---->

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
<?php include_once("includes/navbar.php");?>
  <!-- /.navbar -->
     <!-- Main Sidebar Container -->
 <?php include_once("includes/sidebar.php"); ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit/Update Sub Admin</h3>
        </div>
        <!-- Fetching Existing Sub Admin Details -->
        <?php
        $subadminid = intval($_GET['said']);
        $query = mysqli_query($con, "SELECT * FROM tbladmin WHERE UserType=0 AND ID='$subadminid'");
        while ($row = mysqli_fetch_array($query)) {
        ?>
        <!-- Form Start -->
        <form method="post">
          <div class="card-body">
            <div class="form-group">
              <label for="fullname">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlentities($row['AdminName']); ?>" required>
            </div>
            <div class="form-group">
              <label for="emailid">Email</label>
              <input type="email" class="form-control" id="emailid" name="emailid" value="<?php echo htmlentities($row['Email']); ?>" required>
            </div>
            <div class="form-group">
              <label for="mobilenumber">Mobile Number</label>
              <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" value="<?php echo htmlentities($row['MobileNumber']); ?>" required>
            </div>
          </div>
          <!-- Card Footer -->
          <div class="card-footer">
            <button type="submit" name="update" class="btn btn-primary">Update</button>
          </div>
        </form>
        <?php } ?>
      </div>
    </div>
  </section>
</div>
</div>

<!-- Scripts -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>