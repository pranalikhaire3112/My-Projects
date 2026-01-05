<?php 
session_start();
error_reporting(0);
include('includes/config.php'); // Database Connection

// Validating Session
if (!isset($_SESSION['aid']) || strlen($_SESSION['aid']) == 0) { 
    header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restaurant Table Booking System | New Bookings</title>

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
  <?php include_once("includes/navbar.php"); ?>

  <!-- Sidebar -->
  <?php include_once("includes/sidebar.php"); ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>New Bookings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">New Bookings</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">List of New Bookings</h3>
          </div>
          <div class="card-body">
            <table id="bookingList" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Booking No</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Booking Date</th>
                  <th>Time</th>
                  <th>No. of Adults</th>
                  <th>No. of Children</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($con, "SELECT * FROM tblbookings WHERE status = 'pending' ORDER BY bookingDate DESC");
                $cnt = 1;
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <tr>
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo htmlspecialchars($row['bookingNo']); ?></td>
                    <td><?php echo htmlspecialchars($row['fullName']); ?></td>
                    <td><?php echo htmlspecialchars($row['emailId']); ?></td>
                    <td><?php echo htmlspecialchars($row['phoneNumber']); ?></td>
                    <td><?php echo htmlspecialchars($row['bookingDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['bookingTime']); ?></td>
                    <td><?php echo htmlspecialchars($row['noAdults']); ?></td>
                    <td><?php echo htmlspecialchars($row['noChildrens']); ?></td>
                    <td>
                      <?php echo "<span class='badge badge-warning'>Pending</span>"; ?>
                    </td>
                    <td>
                      <a href="view-booking.php?bookingId=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View</a>
                      <a href="approve-booking.php?bookingId=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                      <a href="delete-booking.php?bookingId=<?php echo $row['id']; ?>" 
                         onclick="return confirm('Are you sure you want to delete this booking?');" 
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
    $("#bookingList").DataTable();
  });
</script>

</body>
</html>
