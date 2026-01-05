<?php 
session_start();
error_reporting(0);
include('includes/config.php'); // Database Connection

// Validating Session
if (!isset($_SESSION['aid']) || strlen($_SESSION['aid']) == 0) { 
    header('location:index.php');
    exit();
}

// CSRF Protection: Generate a token for delete action
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Code For Deleting Sub Admin
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['said'])) {
    $subadminid = intval($_GET['said']);

    // Verify CSRF token
    if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
        echo "<script>alert('Invalid CSRF token. Action denied.');</script>";
    } else {
        $query = mysqli_query($con, "DELETE FROM tbladmin WHERE ID='$subadminid'");

        if ($query) {
            echo "<script>alert('Sub admin record deleted successfully.');</script>";
            echo "<script>document.location = 'manage-subadmins.php';</script>";
            exit();
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
  <title>Restaurant Table Booking System | Manage Sub Admins</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include_once('includes/navbar.php'); ?>

  <!-- Sidebar -->
  <?php include_once('includes/sidebar.php'); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Manage Sub Admins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Manage Sub Admins</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">List of Sub Admins</h3>
          </div>
          <div class="card-body">
            <table id="subAdminTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Mobile Number</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($con, "SELECT * FROM tbladmin WHERE UserType='subadmin'");
                $cnt = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo htmlspecialchars($row['AdminuserName']); ?></td>
                    <td><?php echo htmlspecialchars($row['EmailId']); ?></td>
                    <td><?php echo htmlspecialchars($row['MobileNumber']); ?></td>
                    <td>
                      <a href="manage-subadmins.php?action=delete&said=<?php echo $row['ID']; ?>&token=<?php echo $_SESSION['token']; ?>" 
                         onclick="return confirm('Are you sure you want to delete this sub-admin?');" 
                         class="btn btn-danger btn-sm">Delete</a>
                    </td>
                  </tr>
                <?php
                  $cnt++;
                } ?>
              </tbody>
            </table>
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
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script>
  $(function () {
    $("#subAdminTable").DataTable();
  });
</script>

</body>
</html>
