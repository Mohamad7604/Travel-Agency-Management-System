<?php
  require "connection";
  $identifier=htmlspecialchars($_POST["identifier"]);
  $password=htmlspecialchars($_POST["password"]);

  $sql="SELECT * FROM users WHERE b=name=? OR email=? ";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("ss",$identifier,$password);//bind to send data 
  $stmt->execute();

  $result=$stmt->get_result();// get complete rows from database hold all rows of data here it is array
  if($result->num_rows==1){//numrow is a function and it gives me nb of rows inside results 
   $user->$result->fetch_asset();// associative array holding  id name password 
    
  }
