<?php
include("../common/db.php");  // Include database connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists in the database
    $query = "SELECT * FROM customers WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $token = bin2hex(random_bytes(50)); // Generate a random reset token
        $reset_link = "http://localhost/travelagency2.6/customer/reset_password.php?token=$token";

        // Save the token in the database
        $update_query = "UPDATE customers SET reset_token='$token' WHERE email=?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("s", $email);
        $update_stmt->execute();

        // Simulate email sending by displaying the reset link (in production, send it via email)
        $message = "A password reset link has been sent to your email. Click the link below to reset your password:<br>";
        $message .= "<a href='$reset_link' style='word-wrap: break-word;'>$reset_link</a>";
    } else {
        $message = "No account found with that email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 50px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .message {
            background-color: #e7f3fe;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #b3d8ff;
            border-radius: 5px;
            word-wrap: break-word;
        }
        input[type="email"], button {
            width: calc(100% - 20px); /* Adjust width to fit properly inside the container */
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .back-button {
            background-color: #dc3545;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: block;
        }
        .back-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Add the image for password reset -->
        <img src="../images/reset_password.webp" alt="Reset Password">

        <h2>Forgot Password</h2>
        <p>Enter your email address to request a password reset.</p>

        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="forgot_password.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>

        <!-- Back to login button -->
        <a href="customer_login.php" class="back-button">Back to Login</a>
    </div>
</body>
</html>
