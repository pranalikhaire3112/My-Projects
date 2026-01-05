<?php 
include('includes/config.php');

if(isset($_POST['resetpwd'])) {
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobileno']);
    $newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

    $sql = mysqli_query($con, "SELECT ID FROM tbladmin WHERE AdminuserName='$uname' AND MobileNumber='$mobile'");
    $rowcount = mysqli_num_rows($sql);

    if ($rowcount > 0) {
        $query = mysqli_query($con, "UPDATE tbladmin SET Password='$newpassword' WHERE AdminuserName='$uname' AND MobileNumber='$mobile'");
        if ($query) {
            echo "<script>alert('Your password has been successfully changed.');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Username or Mobile number is incorrect.');</script>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restaurant Table Booking System | Password Recovery</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <script>
    function validateForm() {
        var newPassword = document.getElementById("newpassword").value;
        var confirmPassword = document.getElementById("confirmpassword").value;
        
        if (newPassword !== confirmPassword) {
            alert("Passwords do not match!");
            return false;
        }
        return true;
    }
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Password</b> Recovery</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Reset your password</p>

      <form method="post" onsubmit="return validateForm();">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="text" name="mobileno" class="form-control" placeholder="Mobile Number" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="New Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" id="confirmpassword" class="form-control" placeholder="Confirm Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" name="resetpwd" class="btn btn-primary btn-block">Reset Password</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
