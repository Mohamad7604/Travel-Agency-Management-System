<?php
session_start();
include("../common/db.php"); // Include database connection
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_id = $_POST['flight_id'];
    $selected_seat = $_POST['seat'];
    
    // Begin transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Check seat availability
        $check_query = "SELECT * FROM bookings WHERE flight_id = '$flight_id' AND seat = '$selected_seat' AND status = 'Confirmed'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Seat is already booked
            mysqli_rollback($conn);
            echo "<div style='text-align: center; font-size: 20px; color: red; margin-top: 20%;'>Sorry, this seat is already booked. 😔</div>";
        } else {
            // Confirm the booking
            $insert_query = "INSERT INTO bookings (flight_id, seat, customer_id, status) VALUES ('$flight_id', '$selected_seat', '{$_SESSION['customer_id']}', 'Pending')";
            mysqli_query($conn, $insert_query);
            mysqli_commit($conn);
            echo "<div style='text-align: center; font-size: 20px; color: green; margin-top: 20%;'>Seat booking confirmed. Waiting for agent approval.😄</div>";
        }
    } catch (Exception $e) {
        // An error occurred
        mysqli_rollback($conn);
        echo "<div style='text-align: center; font-size: 20px; color: red; margin-top: 20%;'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
