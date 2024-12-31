<?php
session_start();
require_once '../common/db.php'; // Include database connection

if (!isset($_GET['booking_id'])) {
    echo "<h1>Invalid Request</h1>";
    echo "<p>No booking ID was provided.</p>";
    exit;
}

$booking_id = $_GET['booking_id'];

// Update the booking's payment status in the database
$sql = "UPDATE bookings SET payment_status = 'Paid' WHERE booking_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $booking_id);

if ($stmt->execute()) {
    echo "<div style='text-align: center; margin-top: 50px;'>
            <img src='../images/payment_success.png' alt='Payment Successful' style='width: 300px;'>
            <h1>Payment Successful!</h1>
            <p>Thank you for your payment! Your booking ID is: <strong>$booking_id</strong>.</p>
          </div>";
} else {
    echo "<h1>Error</h1>";
    echo "<p>We encountered an issue while updating your booking. Please contact support with your booking ID: <strong>$booking_id</strong>.</p>";
}
?>
