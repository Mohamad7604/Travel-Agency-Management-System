<?php
// Start the session
session_start();

include("../common/db.php");  // Include database connection

$error_message = ""; // Variable to store error messages
$show_forgot_password = false; // Flag to show "Forgot Password" link

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];  // Plain text password from the form

    // Prepare SQL query using prepared statements
    $query = "SELECT * FROM customers WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);  // Prepare the SQL statement
    mysqli_stmt_bind_param($stmt, "s", $email);  // Bind the email parameter (string)
    mysqli_stmt_execute($stmt);  // Execute the query
    $result = mysqli_stmt_get_result($stmt);  // Get the result

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Use password_verify to check plain text password against the hashed password in the database
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['customer_id'] = $user['customer_id']; // Assuming you have a customer ID

            echo "Login successful. Redirecting to the dashboard...";
            
            // Redirect to the customer dashboard after 2 seconds
            header("Refresh: 2; URL=customer_dashboard.php");
            exit(); // Stop further execution after redirect
        } else {
            // Incorrect password
            $error_message = "Invalid email or password.";
            $show_forgot_password = true; // Show the "Forgot Password" link
        }
    } else {
        // Email not found
        $error_message = "Invalid email or password.";
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('../images/logincustomer.webp') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 380px; /* Adjusted for better fit */
            width: 100%;
            padding: 40px; /* Extra padding to make it more spacious */
            position: relative;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .login-container p {
            text-align: center;
            margin-top: 15px;
        }

        .login-container p a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        /* Error message styling */
        .error-message {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Red return button */
        .return-button {
            display: inline-block;
            width: 100%;
            padding: 12px;
            background-color: #dc3545; /* Red background */
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }

        .return-button:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        /* Responsive design adjustments */
        @media (max-width: 768px) {
            .login-container {
                max-width: 90%; /* Make the container fit the screen on smaller devices */
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Customer Login</h2>
        
        <!-- Display error message if any -->
        <?php if (!empty($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <form action="customer_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>

        <!-- Show "Forgot Password" link only if password is incorrect -->
        <?php if ($show_forgot_password) : ?>
            <p><a href="forgot_password.php">Forgot Password?</a></p>
        <?php endif; ?>

        <p>Don't have an account? <a href="customer_register.php">Register here</a></p>

        <!-- Red return button -->
        <a href="../index.php" class="return-button">Return to Home Page</a>
    </div>
</body>
</html>
