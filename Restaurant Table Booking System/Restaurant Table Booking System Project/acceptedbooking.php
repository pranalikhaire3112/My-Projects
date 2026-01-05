<?php 
session_start();
include('includes/config.php'); // Database connection

// Validate session
if (!isset($_SESSION['aid'])) { 
    header('location:index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $bid = intval($_GET['bid']);
    $estatus = $_POST['status'];
    $oremark = $_POST['officialremak'];
    $tbaleid = $_POST['table'];
    $bdate = $_POST['bdate'];
    $btime = strtotime($_POST['btime']); // Convert time input

    // Check if time conversion is successful
    if (!$btime) {
        echo "<script>alert('Invalid time format.');</script>";
        exit();
    }

    $btimeFormatted = date("H:i:s", $btime);
    $endTime = date("H:i:s", strtotime('+30 minutes', $btime));

    // Check if the table is already booked for the given time slot
    $stmt = $con->prepare("SELECT * FROM tblbookings 
        WHERE tableId = ? AND bookingDate = ? AND boookingStatus = 'Accepted' 
        AND (
            (? BETWEEN time(bookingTime) AND ?)
            OR (bookingTime BETWEEN ? AND ?)
        )");
    $stmt->bind_param("isssss", $tbaleid, $bdate, $btimeFormatted, $endTime, $btimeFormatted, $endTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('Table already booked for the given Date and Time. Please choose another table.');</script>";
    } else {
        // Update booking details
        $stmt = $con->prepare("UPDATE tblbookings SET adminremark=?, boookingStatus=?, tableId=? WHERE id=?");
        $stmt->bind_param("ssii", $oremark, $estatus, $tbaleid, $bid);

        if ($stmt->execute()) {
            echo "<script>alert('Booking Details Updated successfully.'); window.location='manage-classes.php';</script>";
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
    <title>Restaurant Table Booking System | Booking Details</title>
    <!-- Add your CSS and JavaScript links here -->
</head>
<body>

    <h2>Update Booking</h2>
    <form method="post">
        <label for="table">Table ID:</label>
        <input type="text" name="table" required>

        <label for="bdate">Booking Date:</label>
        <input type="date" name="bdate" required>

        <label for="btime">Booking Time:</label>
        <input type="time" name="btime" required>

        <label for="status">Booking Status:</label>
        <select name="status" required>
            <option value="Pending">Pending</option>
            <option value="Accepted">Accepted</option>
            <option value="Rejected">Rejected</option>
        </select>

        <label for="officialremak">Admin Remark:</label>
        <textarea name="officialremak"></textarea>

        <button type="submit" name="submit">Update Booking</button>
    </form>

</body>
</html>
