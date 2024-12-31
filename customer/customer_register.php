<?php
    include("../common/db.php");  // Include database connection

    $error_message = "";  // Variable to store error messages
    $success_message = "";  // Variable to store success messages

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the password

        // Check if the email already exists in the database
        $email_check_query = "SELECT * FROM customers WHERE email = '$email'";
        $result = mysqli_query($conn, $email_check_query);

        if (mysqli_num_rows($result) > 0) {
            // Email already exists
            $error_message = "This email address is already registered. Please use a different email.";
        } else {
            // Insert new customer into the customers table
            $query = "INSERT INTO customers (first_name, last_name, email, phone, password) 
                      VALUES ('$first_name', '$last_name', '$email', '$phone', '$password')";

            if (mysqli_query($conn, $query)) {
                $success_message = "Customer registered successfully.";
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: url('../images/customerregister.webp') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .registration-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            position: relative;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

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

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Success and Error message styling */
        .success-message, .error-message {
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .success-message {
            background-color: #28a745;
            color: white;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
        }

        /* Password Strength Indicator */
        #password-strength {
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }

        .weak {
            color: red;
        }

        .medium {
            color: orange;
        }

        .strong {
            color: green;
        }

    </style>
</head>
<body>
    <div class="registration-container">
        <h2>Customer Registration</h2>

        <!-- Display success or error message -->
        <?php if (!empty($success_message)) : ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php elseif (!empty($error_message)) : ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="customer_register.php" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>
            
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="phone">Phone:</label>
            <input type="text" name="phone" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <div id="password-strength"></div> <!-- Password strength indicator -->
            
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="customer_login.php">Login</a>
        </div>
    </div>

    <!-- Password strength checker script -->
    <script>
        const passwordInput = document.getElementById('password');
        const strengthDisplay = document.getElementById('password-strength');

        passwordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            let strength = '';
            let strengthClass = '';

            // Regular expressions for password criteria
            const hasUpperCase = /[A-Z]/.test(password); 
            const hasLowerCase = /[a-z]/.test(password); 
            const hasNumber = /\d/.test(password); 
            const hasSpecialChar = /[\W_]/.test(password);  
            const isLongEnough = password.length >= 8;

            // Evaluate password strength
            if (!isLongEnough) {
                strength = 'Weak';
                strengthClass = 'weak';
            } else if (isLongEnough && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar) {
                strength = 'Strong';
                strengthClass = 'strong';
            } else if (isLongEnough && (hasUpperCase || hasLowerCase) && (hasNumber || hasSpecialChar)) {
                strength = 'Medium';
                strengthClass = 'medium';
            } else {
                strength = 'Weak';
                strengthClass = 'weak';
            }

            // Display password strength
            strengthDisplay.textContent = `Password Strength: ${strength}`;
            strengthDisplay.className = strengthClass;  // Assign class for color styling
        });
    </script>
</body>
</html>
