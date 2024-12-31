<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   welcome to this page 
   <?php include "test.php";
        //  require "t.php" ;
   ?>

   <!-- include_once if repeated -->
 

   <?php

if(!isset($_SESSION["loggedIn"])||$_SESSION["loggedIn"]==false){
    echo "<a href='login.php'>login</a>";
    
}
else{
    echo "<a href='actions/logout.php'>logout</a>";
    echo $_SESSION["name"] ;
}


?>
 </body>
</html>