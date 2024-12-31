<?php
include("../common/db.php");  // Include database connection

$message = "";
$token = $_GET['token'] ?? '';  // Get token from the URL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $token = $_POST['token'];

    // Find user with matching token
    $query = "SELECT * FROM customers WHERE reset_token='$token'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Update user's password and remove the reset token
        $update_query = "UPDATE customers SET password='$new_password', reset_token=NULL WHERE reset_token='$token'";
        mysqli_query($conn, $update_query);
        $message = "Your password has been reset successfully!";
    } else {
        $message = "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        }
        .message {
            background-color: #e7f3fe;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #b3d8ff;
            border-radius: 5px;
        }
        input[type="password"], button {
            width: 100%;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <p>Enter your new password below.</p>

        <?php if (!empty($message)) : ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="reset_password.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $token; ?>" required>
            <input type="password" name="password" placeholder="Enter your new password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
