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
  <title>Restaurant Table Booking System | All Bookings</title>

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- AdminLTE -->
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
            <h1>All Bookings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">All Bookings</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">All Booking Details</h3>
              </div>
              <div class="card-body">
                <table id="allBookingsTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Booking ID</th>
                      <th>Customer Name</th>
                      <th>Table Number</th>
                      <th>Booking Date</th>
                      <th>Booking Time</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $stmt = $con->prepare("
                        SELECT b.id, b.bookingId, c.name, t.tableNumber, b.bookingDate, b.bookingTime, b.boookingStatus 
                        FROM tblbookings b
                        JOIN tblcustomers c ON c.id = b.customerId
                        JOIN tblrestables t ON t.id = b.tableId
                        ORDER BY b.bookingDate DESC
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $cnt = 1;

                    while ($row = $result->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo $cnt++; ?></td>
                        <td><?php echo htmlspecialchars($row['bookingId']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['tableNumber']); ?></td>
                        <td><?php echo date("d-m-Y", strtotime($row['bookingDate'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($row['bookingTime'])); ?></td>
                        <td>
                          <?php 
                            if ($row['boookingStatus'] == 'Accepted') {
                              echo '<span class="badge badge-success">Accepted</span>';
                            } elseif ($row['boookingStatus'] == 'Rejected') {
                              echo '<span class="badge badge-danger">Rejected</span>';
                            } else {
                              echo '<span class="badge badge-warning">Pending</span>';
                            }
                          ?>
                        </td>
                      </tr>
                    <?php } 
                    $stmt->close();
                    ?>
                  </tbody>
                </table>
              </div>
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
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

<!-- Initialize DataTable -->
<script>
  $(document).ready(function () {
    $("#allBookingsTable").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#allBookingsTable_wrapper .col-md-6:eq(0)');
  });
</script>

</body>
</html>
