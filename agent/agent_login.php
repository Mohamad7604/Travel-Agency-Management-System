<?php
// Start the session if it's not already started in session.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../common/db.php");  // Include database connection

$error_message = "";  // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email']; // Use 'email' because that's the database field
    $password = $_POST['password'];  // Plain text password from the form

    // Prepare SQL query to fetch agent data by email
    $query = "SELECT * FROM agents WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $agent = mysqli_fetch_assoc($result); // The mysqli_fetch_assoc() function in PHP fetches one row at a time from the result set returned by a query, and it does so in the form of an associative array.
        
        // Direct comparison since the password is not hashed
        if ($password === $agent['password']) {
            // Password is correct, set session variables
            $_SESSION['email'] = $agent['email'];
            $_SESSION['first_name'] = $agent['first_name'];
            $_SESSION['last_name'] = $agent['last_name']; 
            $_SESSION['agent_id'] = $agent['agent_id']; // Assuming you have an agent ID

            echo "Login successful. Redirecting to the agent dashboard...";
            
            // Redirect to the agent dashboard after 2 seconds
            header("Refresh: 2; URL=agent_dashboard.php");
            exit(); // Stop further execution after redirect
        } else {
            // Incorrect password
            $error_message = "Invalid email or password.";
        }
    } else {
        // Email not found
        $error_message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Login</title>
    <link rel="stylesheet" href="/assets/style.css">

    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: url('../images/agentimage.jpg') no-repeat center center fixed; /* Add background image */
            background-size: cover; /* Ensure the background covers the entire page */
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Login container styling */
        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 10px; /* Add some margin from the heading */
        }

        h2 {
            color: #007bff; /* Blue color */
            margin-bottom: 20px; /* Space below the heading */
            font-size: 24px; /* Adjusted font size */
            text-align: center;
        }

        /* Label styling */
        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        /* Input fields styling */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Button styling */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Return button styling */
        .return-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #dc3545;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .return-button:hover {
            background-color: #c82333;
        }

        /* Error message styling */
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>
    <h2>Agent Login</h2>
    
    <div class="login-container">
        <!-- Display error message if any -->
        <?php if (!empty($error_message)) : ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="agent_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Return to home button -->
        <a href="../index.php" class="return-button">Return to Home Page</a>
    </div>
</body>
</html>
