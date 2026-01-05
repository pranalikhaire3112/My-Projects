<?php
include_once('admin/includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve and sanitize input
    $fname = trim($_POST['name']);
    $emailid = trim($_POST['email']);
    $phonenumber = trim($_POST['phonenumber']);
    $bookingdate = trim($_POST['bookingdate']);
    $bookingtime = trim($_POST['bookingtime']);
    $noadults = intval($_POST['noadults']);
    $nochildrens = intval($_POST['nochildrens']);
    $bno = mt_rand(100000000, 9999999999);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO tblbookings (bookingNo, fullName, emailId, phoneNumber, bookingDate, bookingTime, noAdults, noChildrens) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssii", $bno, $fname, $emailid, $phonenumber, $bookingdate, $bookingtime, $noadults, $nochildrens);

    if ($stmt->execute()) {
        echo "<script>alert('Your order was sent successfully. Booking number is $bno');</script>";
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Restaurant Table Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="restaurant, booking, table reservation" />

    <!-- Stylesheets -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <link href="css/wickedpicker.css" rel="stylesheet" type="text/css" media="all" />

    <!-- Fonts -->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
</head>

<body>
    <!-- Booking Form -->
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phonenumber" placeholder="Phone Number" required>
        <input type="date" name="bookingdate" required>
        <input type="time" name="bookingtime" required>
        <input type="number" name="noadults" placeholder="Number of Adults" min="1" required>
        <input type="number" name="nochildrens" placeholder="Number of Children" min="0">
        <button type="submit" name="submit">Book Now</button>
    </form>
</body>

</html>
