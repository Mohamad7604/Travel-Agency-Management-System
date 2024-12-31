<?php
session_start();
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]==true){
    header("Location:../index.php");
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
    <form  method="POST" action="actions/loginAction.php">
    <input type="text" name="identifier"  placeholder="username or email">
    <input type="password" name="password" placeholder="password">
    <input type="submit">
<?php
        // if(isset($_GET['err'])){
        //     // fi hal ena kaza error 
        //     // if($_GET["err"]==1){

        //     // }
        //     echo"<p>wrong password</p>";
        //     // $_SESSION["WRONGLOGIN]="";
        // }
?>
    </form>
</body>
</html>