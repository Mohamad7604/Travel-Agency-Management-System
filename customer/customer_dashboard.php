<?php
    // Start session and check if customer is logged in
    session_start();
    
    include("../common/db.php");  // Include database connection

    // Check if the user is logged in as a customer
    if (!isset($_SESSION['customer_id'])) {
        header("Location: ../index.php");
        exit;
    }

    // Get customer information from session
    $customer_id = $_SESSION['customer_id'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="assets/style2.css">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f8f8f8;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        button, .button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover, .button:hover {
            background-color: #218838;
        }

        /* Styling for "Book Now" links */
        .book-now {
            color: white;
            background-color: #007bff;
            padding: 10px 15px;
            text-align: center;
            border-radius: 5px;
        }

        .book-now:hover {
            background-color: #0056b3;
        }

        /* Styling for the Dashboard layout */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            padding: 15px;
            color: white;
        }

        .navbar a {
            color: white;
            font-weight: bold;
            margin-right: 15px;
        }

        .logout {
            background-color: #dc3545;
            padding: 10px 15px;
            border-radius: 5px;
            color: white;
            text-align: center;
        }

        .logout:hover {
            background-color: #c82333;
        }

        /* Hidden Booking History initially */
        #booking-history {
            display: none; /* Initially hidden */
        }

        /* Button to toggle the booking history */
        .toggle-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .toggle-button:hover {
            background-color: #0056b3;
        }

        /* Chatbot CSS */
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            display: none; /* Initially hidden */
        }

        .chat-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        .chat-body {
            padding: 10px;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #chat-log {
            overflow-y: auto;
            flex-grow: 1;
        }

        #question-list {
            list-style-type: none;
            padding: 0;
        }

        #question-list li {
            background-color: #f1f1f1;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            cursor: pointer;
        }

        #question-list li:hover {
            background-color: #ddd;
        }

        .chatbot-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* Back to Top Button */
        #backToTopBtn {
            display: none; /* Hidden by default */
            position: fixed; /* Fixed/sticky position */
            bottom: 50px;
            right: 40px;
            z-index: 99; /* Make sure it does not overlap */
            border: none; /* Remove borders */
            outline: none; /* Remove outline */
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            cursor: pointer; /* Add a mouse pointer on hover */
            padding: 15px; /* Some padding */
            border-radius: 20px; /* Rounded corners */
            font-size: 18px; /* Increase font size */
        }

        #backToTopBtn:hover {
            background-color: #555; /* Darker background on hover */
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h2>Welcome, <?php echo $first_name . " " . $last_name; ?>!</h2>
            <a class="logout" href="../logout.php">Logout</a>
        </div>

        <!-- Section for Browsing Vacations -->
        <h3>Browse Vacations</h3>
        <table>
            <tr>
                <th>Destination</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
            <?php
                // Fetch available vacations
                $vacations_query = "SELECT * FROM vacations";
                $vacations_result = mysqli_query($conn, $vacations_query);
                while ($vacation = mysqli_fetch_assoc($vacations_result)) {
                    echo "<tr>
                            <td>{$vacation['destination']}</td>
                            <td>{$vacation['start_date']}</td>
                            <td>{$vacation['end_date']}</td>
                            <td><a class='book-now' href='book_vacation.php?vacation_id={$vacation['vacation_id']}'>Book Now</a></td>
                          </tr>";
                }
            ?>
        </table>

        <!-- Section for Booking Flights -->
        <h3>Book From The Available Flights ✈️</h3>
        <table>
            <tr>
                <th>Flight Number</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Seats Available</th>
            </tr>
            <?php
                // Fetch available flights
                $flights_query = "SELECT * FROM flights WHERE seats_available > 0";
                $flights_result = mysqli_query($conn, $flights_query);
                while ($flight = mysqli_fetch_assoc($flights_result)) {
                    echo "<tr>
                            <td>{$flight['flight_number']}</td>
                            <td>{$flight['origin']}</td>
                            <td>{$flight['destination']}</td>
                            <td>{$flight['departure_time']}</td>
                            <td>{$flight['arrival_time']}</td>
                            <td>{$flight['seats_available']}</td>
                          </tr>";
                }
            ?>
        </table>

        <!-- Toggle Button for Booking History -->
        <button class="toggle-button" onclick="toggleBookingHistory()">Show Booking History</button>

        <!-- Section for Viewing Booking History, hidden initially -->
        <div id="booking-history">
            <h3>Your Booking History</h3>
            <table>
                <tr>
                    <th>Booking ID</th>
                    <th>Flight Route (From - To)</th>
                    <th>Flight Number</th>
                    <th>Seat Number</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                </tr>
                <?php
// Fetch confirmed bookings for the logged-in customer with flight origin, destination, and payment status
$bookings_query = "
    SELECT b.booking_id, f.flight_number, f.origin, f.destination, b.seat, b.booking_date, b.status, b.payment_status
    FROM bookings b
    LEFT JOIN flights f ON b.flight_id = f.flight_id
    WHERE b.customer_id = '$customer_id'
";
$bookings_result = mysqli_query($conn, $bookings_query);

while ($booking = mysqli_fetch_assoc($bookings_result)) {
    $route = $booking['origin'] . " - " . $booking['destination'];  // Combine origin and destination
    echo "<tr>
            <td>{$booking['booking_id']}</td>
            <td>{$route}</td>
            <td>{$booking['flight_number']}</td>
            <td>{$booking['seat']}</td>
            <td>{$booking['booking_date']}</td>
            <td>{$booking['status']}</td>
            <td>{$booking['payment_status']}</td>";

    // Add "Pay Now" button for confirmed bookings with pending payment
    if ($booking['status'] === 'Confirmed' && $booking['payment_status'] === 'Pending') {
        echo "<td><a class='pay-now' href='process_payment.php?booking_id={$booking['booking_id']}'>Pay Now</a></td>";
    } else {
        echo "<td>-</td>"; // No action for Paid or Failed statuses
    }

    echo "</tr>";
}
?>

            </table>
        </div>

        <!-- Chatbot Trigger Button -->
        <button class="chatbot-toggle" onclick="toggleChat()">Chat with us!</button>

        <!-- Chatbot Structure -->
        <div class="chatbot-container" id="chatbot">
            <div class="chat-header">
                <h4>Chatbot</h4>
                <button class="close-btn" onclick="toggleChat()">X</button>
            </div>
            <div class="chat-body">
                <div id="chat-log"></div>
                <ul id="question-list">
                    <li onclick="askQuestion(0)">What vacations do you offer?</li>
                    <li onclick="askQuestion(1)">How can I book a flight?</li>
                    <li onclick="askQuestion(2)">What services does the agency provide?</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button onclick="topFunction()" id="backToTopBtn" title="Go to top">⬆️</button>

    <!-- JavaScript to toggle the booking history and chatbot -->
    <script>
        function toggleBookingHistory() {
            var bookingHistory = document.getElementById("booking-history");
            if (bookingHistory.style.display === "none" || bookingHistory.style.display === "") {
                bookingHistory.style.display = "block";
                document.querySelector(".toggle-button").textContent = "Hide Booking History";
            } else {
                bookingHistory.style.display = "none";
                document.querySelector(".toggle-button").textContent = "Show Booking History";
            }
        }

        <!-- JavaScript for Chatbot -->
     
        const predefinedQuestions = [
            "What vacations do you offer?",
            "How can I book a flight?",
            "What services does the agency provide?"
        ];

        function toggleChat() {
            const chatbot = document.getElementById("chatbot");
            chatbot.style.display = chatbot.style.display === "none" || chatbot.style.display === "" ? "block" : "none";
        }

        function askQuestion(index) {
            const chatLog = document.getElementById("chat-log");

            if (index < 0 || index >= predefinedQuestions.length) {
                chatLog.innerHTML += `<p><strong>Phoenicia Bot:</strong> Invalid question selected.</p>`;
                return;
            }

            const question = predefinedQuestions[index];
            chatLog.innerHTML += `<p><strong>You:</strong> ${question}</p>`;

            fetch('../common/chatgpt_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `question=${encodeURIComponent(question)}`,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.response) {
                        chatLog.innerHTML += `<p><strong>Phoenicia Bot:</strong> ${data.response}</p>`;
                    } else if (data.error) {
                        chatLog.innerHTML += `<p><strong>Phoenicia Bot:</strong> ${data.error}</p>`;
                    }
                    chatLog.scrollTop = chatLog.scrollHeight;
                })
                .catch(error => {
                    chatLog.innerHTML += `<p><strong>Phoenicia Bot:</strong> Sorry, something went wrong. Please try again later.</p>`;
                });
        }

        document.addEventListener("DOMContentLoaded", () => {
            const chatLog = document.getElementById("chat-log");
            chatLog.innerHTML = `<p><strong>Phoenicia Bot:</strong> Hi! How can I assist you today?</p>`;
        });
 
    </script>
</body>
</html>
