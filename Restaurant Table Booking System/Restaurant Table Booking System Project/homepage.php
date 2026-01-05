<?php 
include_once('admin/includes/config.php');

if(isset($_POST['submit'])) {
    $fname = mysqli_real_escape_string($con, htmlspecialchars($_POST['name']));
    $emailid = mysqli_real_escape_string($con, htmlspecialchars($_POST['email']));
    $phonenumber = mysqli_real_escape_string($con, htmlspecialchars($_POST['phonenumber']));
    $bookingdate = mysqli_real_escape_string($con, htmlspecialchars($_POST['bookingdate']));
    $bookingtime = mysqli_real_escape_string($con, htmlspecialchars($_POST['bookingtime']));
    $noadults = intval($_POST['noadults']);
    $nochildrens = intval($_POST['nochildrens']);
    $bno = mt_rand(100000000, 9999999999);

    // Validate Email
    if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.');</script>";
    } else {
        // Insert Booking Details
        $query = mysqli_query($con, "INSERT INTO tblbookings (bookingNo, fullName, emailId, phoneNumber, bookingDate, bookingTime, noAdults, noChildrens) 
                                      VALUES ('$bno', '$fname', '$emailid', '$phonenumber', '$bookingdate', '$bookingtime', '$noadults', '$nochildrens')");
        if($query) {
            echo "<script>alert('Your booking was successful! Your booking number is $bno');</script>";
            echo "<script>window.location.href='index.php';</script>";
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
    <title>Restaurant Table Booking System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link href="css/wickedpicker.css" rel="stylesheet" type="text/css">
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    
    <script>
        function validateForm() {
            var phone = document.getElementById("phonenumber").value;
            var adults = document.getElementById("noadults").value;

            if (phone.length !== 10 || isNaN(phone)) {
                alert("Please enter a valid 10-digit phone number.");
                return false;
            }
            if (adults < 1) {
                alert("At least one adult must be present.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

    <form method="post" onsubmit="return validateForm();">
        <label for="name">Full Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="phonenumber">Phone Number:</label>
        <input type="text" name="phonenumber" id="phonenumber" required>

        <label for="bookingdate">Booking Date:</label>
        <input type="date" name="bookingdate" id="bookingdate" required>

        <label for="bookingtime">Booking Time:</label>
        <input type="time" name="bookingtime" id="bookingtime" required>

        <label for="noadults">Number of Adults:</label>
        <input type="number" name="noadults" id="noadults" min="1" required>

        <label for="nochildrens">Number of Children:</label>
        <input type="number" name="nochildrens" id="nochildrens" min="0" required>

        <button type="submit" name="submit">Book Table</button>
    </form>

</body>
</html>
