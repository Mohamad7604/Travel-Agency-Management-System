<?php
include("../common/db.php"); // Include database connection

if (isset($_GET['flight_id'])) {
    $flight_id = $_GET['flight_id'];

    // Fetch flight details to display
    $flight_query = "SELECT * FROM flights WHERE flight_id = '$flight_id'";
    $flight_result = mysqli_query($conn, $flight_query);
    $flight = mysqli_fetch_assoc($flight_result);

    // Fetch available and booked seats for the flight
    $seat_query = "SELECT seat_number, seat_type, is_booked FROM seats WHERE flight_id = '$flight_id'";
    $seat_result = mysqli_query($conn, $seat_query);
    $seats = [];
    while ($seat = mysqli_fetch_assoc($seat_result)) {
        $seats[] = $seat;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Seat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../images/flight.webp') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #007bff;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
        }

        .plane {
            display: inline-block;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        .row {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .seat {
            width: 40px;
            height: 40px;
            margin: 5px;
            background-color: #007bff;
            border: 1px solid #333;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            line-height: 40px;
            color: #fff;
            font-weight: bold;
        }

        .seat.taken {
            background-color: #d9534f;
            cursor: not-allowed;
        }

        .seat:hover:not(.taken) {
            background-color: #0056b3;
        }

        .seat.selected {
            background-color: #28a745;
        }

        #selected-seat {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        button:hover {
            background-color: #218838;
        }

        .back-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
        }

        .back-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h2>Select a Seat for Flight: <?php echo $flight['flight_number']; ?></h2>

    <div class="plane">
        <?php
        $rows = 10; // Number of rows
        $cols = 4; // Seats per row

        $seatIndex = 0;
        for ($i = 1; $i <= $rows; $i++) {
            echo '<div class="row">';
            for ($j = 0; $j < $cols; $j++) {
                if (isset($seats[$seatIndex])) {
                    $seat = $seats[$seatIndex];
                    $class = $seat['is_booked'] ? 'seat taken' : 'seat';
                    echo "<div class='" . $class . "' data-seat='{$seat['seat_number']}'>{$seat['seat_number']}</div>";
                    $seatIndex++;
                }
            }
            echo '</div>';
        }
        ?>
    </div>

    <form id="seat-form" action="confirm_seat.php" method="POST">
        <input type="hidden" name="flight_id" value="<?php echo $flight_id; ?>">
        <input type="hidden" id="selected-seat-input" name="seat" value="">
        <button type="submit" disabled id="confirm-button">Confirm Seat</button>
    </form>

    <a href="book_flight.php" class="back-button">Back to Flight Selection</a>

    <script>
        const seats = document.querySelectorAll('.seat:not(.taken)');
        const seatInput = document.getElementById('selected-seat-input');
        const confirmButton = document.getElementById('confirm-button');

        seats.forEach(seat => {
            seat.addEventListener('click', () => {
                // Deselect all seats
                seats.forEach(s => s.classList.remove('selected'));

                // Select the clicked seat
                seat.classList.add('selected');

                // Update hidden input value
                seatInput.value = seat.getAttribute('data-seat');

                // Enable the confirm button
                confirmButton.disabled = false;
            });
        });
    </script>
</body>
</html>
