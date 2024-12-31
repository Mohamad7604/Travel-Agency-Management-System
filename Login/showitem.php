<?php
include "connection.php";

$sql="SELECT * from items";
$result=$conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            echo '<p > name is   ' . $row["name"]. '</p>';
            echo '<p> name is   ' . $row["description"]. '</p>';
            echo '   <img src="actions/' .$row['image'].'" alt="item image">' ;
            echo '<p>' . $row["image"]. '</p>';


        }
    }
    $conn->close();
    ?>
</body>
</html>