<?php 
session_start();
include('includes/config.php'); // Database Connection

// Validate Session
if (!isset($_SESSION['aid'])) { 
    header('location:index.php');
    exit();
}

// Code for Adding a New Table
if (isset($_POST['submit'])) {
    $tno = trim($_POST['tableno']); // Sanitize input
    $addedby = $_SESSION['aid'];

    // Check if table number already exists
    $stmt = $con->prepare("SELECT tableNumber FROM tblrestables WHERE tableNumber = ?");
    $stmt->bind_param("s", $tno);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Table number already exists. Please use a different one.');</script>";
    } else {
        // Insert new table
        $stmt = $con->prepare("INSERT INTO tblrestables (tableNumber, AddedBy) VALUES (?, ?)");
        $stmt->bind_param("si", $tno, $addedby);

        if ($stmt->execute()) {
            echo "<script>alert('Table added successfully.'); window.location='add-table.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Table Booking System | Add Table</title>

    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">
    <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    
    <?php include_once("includes/navbar.php"); ?>
    <?php include_once("includes/sidebar.php"); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h2>Add New Table</h2>
                <form method="post">
                    <label for="tableno">Table Number:</label>
                    <input type="text" name="tableno" required>
                    <button type="submit" name="submit">Add Table</button>
                </form>
            </div>
        </section>
    </div>
</div>
</body>
</html>
