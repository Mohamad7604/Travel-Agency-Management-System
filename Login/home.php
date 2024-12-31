<?php
session_start();
if(!isset($_SESSION["loggedIn"])||$_SESSION["loggedIn"]==false){
    die("cant acccess this page");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    you can access <?php echo $_SESSION["name"];  ?>
</body>
</html>