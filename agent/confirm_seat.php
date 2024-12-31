<?php
include("../common/db.php"); // Include the database connection

session_start(); // Start the session to track agent/customer details

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flight_id = $_POST['flight_id'];
    $seat_number = $_POST['seat'];
    $agent_id = $_SESSION['agent_id']; // Assuming the agent is logged in
    $customer_id = $_SESSION['customer_id']; // Assuming the customer is logged in

    // Check if the seat is still available
    $seat_check_query = "SELECT * FROM seats WHERE flight_id = '$flight_id' AND seat_number = '$seat_number' AND is_booked = FALSE";
    $seat_check_result = mysqli_query($conn, $seat_check_query);

    if (mysqli_num_rows($seat_check_result) > 0) {
        // Proceed with booking: mark the seat as booked
        $booking_query = "INSERT INTO bookings (flight_id, seat, agent_id, customer_id) 
                          VALUES ('$flight_id', '$seat_number', '$agent_id', '$customer_id')";
        
        if (mysqli_query($conn, $booking_query)) {
            // Update the seat to mark it as booked
            $update_seat_query = "UPDATE seats SET is_booked = TRUE WHERE flight_id = '$flight_id' AND seat_number = '$seat_number'";
            mysqli_query($conn, $update_seat_query);

            echo "Seat $seat_number successfully booked.";
            echo "<a href='agent_dashboard.php'>Go back to Dashboard</a>";
        } else {
            echo "Error booking seat: " . mysqli_error($conn);
        }
    } else {
        // Seat is already booked
        echo "Sorry, seat $seat_number is already taken for this flight.";
        echo "<a href='select_seat.php?flight_id=$flight_id'>Back to seat selection</a>";
    }
}
?>