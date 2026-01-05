<?php 
session_start();
include('admin/includes/config.php'); // Database Connection

// Ensure bid is set and sanitized
if (!isset($_GET['bid']) || !is_numeric($_GET['bid'])) {
    die("Invalid booking ID.");
}
$bid = intval($_GET['bid']);
$query = mysqli_query($con, "SELECT * FROM tblbookings WHERE id='$bid'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Restaurant Table Booking System | Booking Details</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Booking Details</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Booking Details</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Booking Date</th>
                      <th>Booking Time</th>
                      <th>No. of Guests</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $cnt = 1;
                    while ($result = mysqli_fetch_array($query)) { ?>
                      <tr>
                        <td><?php echo htmlentities($cnt); ?></td>
                        <td><?php echo htmlentities($result['name']); ?></td>
                        <td><?php echo htmlentities($result['email']); ?></td>
                        <td><?php echo htmlentities($result['phone']); ?></td>
                        <td><?php echo htmlentities($result['booking_date']); ?></td>
                        <td><?php echo htmlentities($result['booking_time']); ?></td>
                        <td><?php echo htmlentities($result['num_guests']); ?></td>
                      </tr>
                    <?php $cnt++; } ?>
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
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script>
</body>
</html>