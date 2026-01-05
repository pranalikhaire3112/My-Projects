<?php 
session_start();
include('includes/config.php'); // Database Connection

// Validating Session
if (!isset($_SESSION['aid']) || strlen($_SESSION['aid']) == 0) { 
    header('location:index.php');
    exit();
}

// Code for Resetting the Password of a Sub-Admin
if (isset($_POST['reset'])) {
    $subadminid = intval($_GET['said']);
    $new_password = $_POST['inputpwd'];
    $confirm_password = $_POST['confirmpassword'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('New Password and Confirm Password do not match.');</script>";
    } else {
        // Hashing Password (More Secure than md5)
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update Query using Prepared Statement
        $stmt = $con->prepare("UPDATE tbladmin SET Password=? WHERE UserType=0 AND ID=?");
        $stmt->bind_param("si", $hashed_password, $subadminid);
        $query = $stmt->execute();

        if ($query) {
            echo "<script>alert('Sub-Admin password reset successfully.');</script>";
            echo "<script type='text/javascript'> document.location = 'manage-subadmins.php'; </script>";
            exit();
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
  <title>Restaurant Table Booking System | Reset Sub-Admin Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- Password Validation Script -->
  <script type="text/javascript">
    function checkpass() {
        if (document.resetpassword.inputpwd.value !== document.resetpassword.confirmpassword.value) {
            alert('New Password and Confirm Password do not match.');
            document.resetpassword.confirmpassword.focus();
            return false;
        }
        return true;
    }
  </script>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include_once("includes/navbar.php"); ?>

  <!-- Sidebar -->
  <?php include_once("includes/sidebar.php"); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reset Sub-Admin Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Reset Password</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Enter New Password</h3>
          </div>
          <div class="card-body">
            <form method="post" name="resetpassword" onsubmit="return checkpass();">
              <div class="form-group">
                <label for="inputpwd">New Password</label>
                <input type="password" class="form-control" name="inputpwd" id="inputpwd" required>
              </div>
              <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required>
              </div>
              <div class="form-group">
                <button type="submit" name="reset" class="btn btn-primary">Reset Password</button>
              </div>
            </form>
          </div>
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
