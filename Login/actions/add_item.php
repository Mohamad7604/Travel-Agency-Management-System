<?php
   
require "../connection.php";

if($_SERVER['REQUEST_METHOD']=="POST"){/// ENSURE TO DONT TAKE THEM IF THEY ARE NOT POST REQUEST 
    $name=$_POST["name"];
    $des=$_POST["description"];
    $image=$_FILES["image"]; // IMAGE NOT ONLY ITS NAME 

}
if(empty($des) && empty($name)){// THIS ENSURES THAT NOTHING MUST BE EMPTY BEC IF EMPTY I RETURN DESCRIPTUON IS EMPTY 
    echo"description is empty"; // HACKER WILL BE PREVENTED BY DOING THIS 
    exit();
}
$target_dir="uploads/";
if(!file_exists($target_dir)){
    mkdir($target_dir,0777,true);// if it is not present create the file called folder

}//tmp name is the name bdoon soace 
$target_file=$target_dir.basename($image['name']);
if(move_uploaded_file($image["tmp_name"],$target_file)){
  $sql="INSERT INTO items (name,description,image) values('$name','$des','$target_file')";
  if($conn->query($sql)===TRUE){
    echo"item added sucessfully";
  }else{

  }

}