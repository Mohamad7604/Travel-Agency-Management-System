<?php

 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Flight</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h3 {
            text-align: center;
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .book-link {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }

        .book-link:hover {
            background-color: #218838;
        }

        /* Container to center everything */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Style for the back button */
        .back-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .back-button:hover {
            background-color: #c82333;
        }

        /* Center the no flights message */
        .no-flights-message {
            text-align: center;
            font-size: 20px;
            color: #333;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            include("../common/db.php"); // Include database connection

            // Get the selected vacation destination from URL
            $destination = isset($_GET['destination']) ? $_GET['destination'] : '';

            // Fetch available flights based on the selected vacation destination
            $flights_query = "SELECT * FROM flights WHERE destination = '$destination'";
            $flights_result = mysqli_query($conn, $flights_query);

            if (mysqli_num_rows($flights_result) > 0) {
                echo "<h3>Select Flight for Destination: $destination</h3>";
                echo "<table>";
                echo "<tr>
                        <th>Flight Number</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Seats Available</th>
                        <th>Action</th>
                      </tr>";
                while ($flight = mysqli_fetch_assoc($flights_result)) {
                    echo "<tr>
                            <td>{$flight['flight_number']}</td>
                            <td>{$flight['origin']}</td>
                            <td>{$flight['destination']}</td>
                            <td>{$flight['seats_available']}</td>
                            <td><a class='book-link' href='confirm_booking.php?flight_id={$flight['flight_id']}'>Book this flight</a></td>
                          </tr>";
                }
                echo "</table>";
            } else {
                // Display no flights available message centered
                echo "<div class='no-flights-message'>
                        <p>Sorry, no current available flights for this destination. Check soon for upcoming flights!</p>
                      </div>";
            }
        ?>
    </div>

    <!-- Button to go back to book_vacation.php -->
    <a href="book_vacation.php" class="back-button">Back to Vacation Selection</a>
</body>
</html>
