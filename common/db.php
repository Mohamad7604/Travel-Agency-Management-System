<?php
  $server="localhost";
  $username="root";
   $password="";
   $db = "travel_booking";
   //PDO BEST WAY TO CONTACT DATABASE 
   try {
    $pdo = new PDO("mysql:host=$server;dbname=$db", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully to the database using PDO";
} catch (PDOException $e) {
    echo "Connection to database failed: " . $e->getMessage();
    die();
}
  $sql= "SELECT * FROM customers";
  $stmt=$pdo->query($sql);//  pdo  jas method called query it tells it to excite code now i want to return info 
   $users = $stmt ->fetchALL(PDO::FETCH_ASSOC);// FETCH INFORM OF ASSOCIATIVE ARRAY
    //print_r($users); to check if connection is correct
     $conn = mysqli_connect("localhost", "root", "", "travel_booking");

    // // Check connection
    // if (!$conn) {
    //     die("Connection failed: " . mysqli_connect_error());
    // }
?>
