<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
</body>
</html>
<?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];

    // Display an error message based on the error parameter
    if ($error == 'emptyfields') {
        echo "<p style='color:red;'>Please fill in all fields!</p>";
    } elseif ($error == 'invalidemail') {
        echo "<p style='color:red;'>Invalid email format!</p>";
    } elseif ($error == 'invalidage') {
        echo "<p style='color:red;'>Invalid age value. Age must be greater than zero!</p>";
    } elseif ($error == 'dberror') {
        echo "<p style='color:red;'>A database error occurred. Please try again later.</p>";
    } else {
        echo "<p style='color:red;'>An unknown error occurred.</p>";
    }
}
?>
