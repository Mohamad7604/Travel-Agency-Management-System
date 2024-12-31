<?php
include("../common/session.php"); // Session control script
include("../common/db.php");      // Database connection

// Check if the user is logged in and has 'agent' access
if (!isset($_SESSION['agent_id'])) {
    header("Location: agent_login.php");
    exit;
}

// Fetch agent name from session
$agent_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] . " " . $_SESSION['last_name'] : 'Agent'; 

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update booking status
    if (isset($_POST['action']) && isset($_POST['booking_id'])) {
        $booking_id = $_POST['booking_id'];
        $action = $_POST['action'];
        $status = $action === 'confirm' ? 'Confirmed' : ($action === 'reject' ? 'Rejected' : null);

        if ($status) {
            // Update booking status in database
            $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
            $stmt->bind_param('si', $status, $booking_id);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Booking #$booking_id updated to $status."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update booking."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Invalid action."]);
        }
        exit;
    }
}

// Fetch pending bookings for AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch_bookings'])) {
    $query = "
        SELECT b.booking_id, b.seat, b.booking_date, b.status, f.flight_number, c.first_name, c.last_name 
        FROM bookings b 
        JOIN flights f ON b.flight_id = f.flight_id
        JOIN customers c ON b.customer_id = c.customer_id
        WHERE b.status = 'Pending'
    ";
    $result = mysqli_query($conn, $query);
    $bookings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bookings[] = $row;
    }
    echo json_encode($bookings);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Dashboard</title>
    <style>
        /* Basic reset and styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: white;
            font-size: 24px;
            margin: 0;
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
            cursor: pointer;
        }

        .logout:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
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

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .reject-button {
            background-color: #dc3545;
            margin-left: 10px;
        }

        .reject-button:hover {
            background-color: #c82333;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <h2>Welcome, Agent <?php echo $agent_name; ?>!</h2>
            <a class="logout" href="../logout.php">Logout</a>
        </div>

        <!-- Section for pending bookings -->
        <h3>Pending Bookings</h3>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Flight Number</th>
                    <th>Customer Name</th>
                    <th>Seat Number</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="pending-bookings-table-body">
                <!-- Pending bookings will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            // Function to fetch pending bookings
            function fetchPendingBookings() {
                $.ajax({
                    url: "<?php echo $_SERVER['PHP_SELF']; ?>?fetch_bookings=true", // Fetch bookings
                    type: "GET",
                    success: function (response) {
                        const bookings = JSON.parse(response); // Parse JSON response
                        let rows = "";

                        // Populate table rows with bookings
                        bookings.forEach((booking) => {
                            rows += `
                                <tr>
                                    <td>${booking.booking_id}</td>
                                    <td>${booking.flight_number}</td>
                                    <td>${booking.first_name} ${booking.last_name}</td>
                                    <td>${booking.seat}</td>
                                    <td>${booking.booking_date}</td>
                                    <td>${booking.status}</td>
                                    <td>
                                        <button class="action-button" data-id="${booking.booking_id}" data-action="confirm">Confirm</button>
                                        <button class="action-button reject-button" data-id="${booking.booking_id}" data-action="reject">Reject</button>
                                    </td>
                                </tr>
                            `;
                        });

                        // Update the table body
                        $("#pending-bookings-table-body").html(rows);

                        // Rebind click events for buttons
                        bindActionButtons();
                    },
                    error: function () {
                        alert("Error fetching pending bookings.");
                    },
                });
            }

            // Function to handle Confirm/Reject actions
            function bindActionButtons() {
                $(".action-button").on("click", function () {
                    const bookingId = $(this).data("id");
                    const action = $(this).data("action");

                    // AJAX request to update booking status
                    $.ajax({
                        url: "<?php echo $_SERVER['PHP_SELF']; ?>",
                        type: "POST",
                        data: { booking_id: bookingId, action: action },
                        success: function (response) {
                            const res = JSON.parse(response);
                            alert(res.message);
                            fetchPendingBookings(); // Refresh bookings after an action
                        },
                        error: function () {
                            alert("Error updating booking.");
                        },
                    });
                });
            }

            // Fetch pending bookings every 5 seconds
            setInterval(fetchPendingBookings, 5000);

            // Initial fetch
            fetchPendingBookings();
        });
    </script>
</body>
</html>
