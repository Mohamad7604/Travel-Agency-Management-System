<?php
    include("../common/session.php");
    include("../common/db.php");
        // Check if the customer is logged in
   
    

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
    <title>Browse Vacations</title>
    <style>
        .vacation-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .vacation-item {
            width: 30%;
            border: 1px solid #ddd;
            margin: 10px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .vacation-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .vacation-details {
            padding: 15px;
            text-align: center;
        }
        .book-now {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            display: block;
            border-radius: 5px;
            text-decoration: none;
        }
        .book-now:hover {
            background-color: #0056b3;
        }
        /* Style for the red back button */
        .back-button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Red button to go back to customer dashboard -->
    <a href="customer_dashboard.php" class="back-button">Back to Dashboard</a>

    <h3>Browse Vacations</h3>
    <div class="vacation-container">
        <?php
            // Fetch available vacations
            $vacations_query = "SELECT * FROM vacations";
            $vacations_result = mysqli_query($conn, $vacations_query);
            while ($vacation = mysqli_fetch_assoc($vacations_result)) {
                // Use the correct path to your images folder and include the image filename from the database
                echo "
                <div class='vacation-item'>
                    <img src='/travelagency2.6/images/{$vacation['image']}' alt='Vacation Image'>
                    <div class='vacation-details'>
                        <h4>{$vacation['destination']}</h4>
                        <p>Start Date: {$vacation['start_date']}</p>
                        <p>End Date: {$vacation['end_date']}</p>
                        <a class='book-now' href='book_flight.php?destination={$vacation['destination']}'>Book Now</a>
                    </div>
                </div>";
            }
        ?>
    </div>
</body>
</html>
