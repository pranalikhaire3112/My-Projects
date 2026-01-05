<?php 
session_start();
include('includes/config.php'); // Database Connection

// Validating Session
if (!isset($_SESSION['aid']) || strlen($_SESSION['aid']) == 0) { 
    header('location:index.php');
    exit();
}

// Change Password Logic
if (isset($_POST['change'])) {
    $admid = $_SESSION['aid'];
    $currentPassword = $_POST['currentpassword'];
    $newPassword = $_POST['newpassword'];
    $confirmPassword = $_POST['confirmpassword'];

    // Validate Input
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo '<script>alert("All fields are required!");</script>';
    } elseif ($newPassword !== $confirmPassword) {
        echo '<script>alert("New password and Confirm password do not match!");</script>';
    } else {
        // Fetch hashed password from DB
        $stmt = $con->prepare("SELECT Password FROM tbladmin WHERE ID=?");
        $stmt->bind_param("i", $admid);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            // Verify current password
            if (password_verify($currentPassword, $hashedPassword)) {
                // Hash new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Update password in DB
                $updateStmt = $con->prepare("UPDATE tbladmin SET Password=? WHERE ID=?");
                $updateStmt->bind_param("si", $newHashedPassword, $admid);
                
                if ($updateStmt->execute()) {
                    echo '<script>alert("Your password has been successfully changed.");</script>';
                } else {
                    echo '<script>alert("Something went wrong. Please try again.");</script>';
                }
            } else {
                echo '<script>alert("Your current password is incorrect.");</script>';
            }
        } else {
            echo '<script>alert("Admin account not found.");</script>';
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
  <title>Restaurant Table Booking System | Change Password</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
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
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Update Your Password</h3>
              </div>

              <!-- Form Start -->
              <form method="post" onsubmit="return validateForm();">
                <div class="card-body">
                  <div class="form-group">
                    <label for="currentpassword">Current Password</label>
                    <input type="password" name="currentpassword" id="currentpassword" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="newpassword">New Password</label>
                    <input type="password" name="newpassword" id="newpassword" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="confirmpassword">Confirm New Password</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" required>
                  </div>
                </div>

                <!-- Submit Button -->
                <div class="card-footer">
                  <button type="submit" name="change" class="btn btn-primary">Change Password</button>
                </div>
              </form>
              <!-- Form End -->

            </div>
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

<!-- Password Validation -->
<script>
function validateForm() {
    var newpassword = document.getElementById("newpassword").value;
    var confirmpassword = document.getElementById("confirmpassword").value;

    if (newpassword.length < 6) {
        alert("New password must be at least 6 characters long.");
        return false;
    }

    if (newpassword !== confirmpassword) {
        alert("New password and Confirm password do not match.");
        return false;
    }
    
    return true;
}
</script>

</body>
</html>
