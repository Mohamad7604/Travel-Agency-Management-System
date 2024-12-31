<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phoenicia Scapes</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <style>
        /* General Body Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: url('images/index.webp') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
        }

        /* Header Styles */
        header {
            text-align: center;
            padding: 50px 20px;
            background-color: rgba(0, 0, 0, 0.6);
        }

        header h1 {
            font-family: 'Cinzel', serif;
            font-size: 3.5em;
            color: #ffcc00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin: 0;
        }

        /* Navigation Bar */
        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            text-align: center;
        }

        nav ul li {
            display: inline-block;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            background-color: rgba(0, 123, 255, 0.9);
            padding: 10px 25px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        /* Section Styles */
        section {
            text-align: center;
            padding: 50px 20px;
        }

        .text-container {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 10px;
            max-width: 800px;
            margin: 0 auto;
        }

        section h2 {
            font-family: 'Cinzel', serif;
            font-size: 2.5em;
            color: #ffcc00;
            margin-bottom: 20px;
        }

        section p {
            font-size: 1.2em;
            line-height: 1.6;
        }

        /* Footer Styles */
        footer {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 1em;
        }

        .social-icons {
            margin: 15px 0;
        }

        .social-icons a {
            color: white;
            text-decoration: none;
            font-size: 1.5em;
            margin: 0 10px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #ffcc00;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2.5em;
            }

            nav ul li {
                display: block;
                margin: 10px 0;
            }

            .text-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Phoenicia Scapes</h1>
    </header>

    <nav>
        <ul>
            <li><a href="customer/customer_login.php">Customer Login</a></li>
            <li><a href="customer/customer_register.php">Customer Register</a></li>
            <li><a href="agent/agent_login.php">Agent Login</a></li>
        </ul>
    </nav>

    <section>
        <div class="text-container">
            <h2>Plan Your Next Vacation</h2>
            <p>Discover exciting vacation packages and book the best flights with ease. Our travel system is designed to make your journey stress-free and unforgettable.</p>
            <p>Whether you're a customer booking your dream vacation or an agent managing bookings, we’ve got you covered.</p>
        </div>
    </section>

    <footer>
        <p>© 2024 Phoenicia Scapes. All rights reserved.</p>
        <div class="social-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
    </footer>
</body>
</html>
