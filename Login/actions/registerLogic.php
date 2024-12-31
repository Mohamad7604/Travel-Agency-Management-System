 <?php

require "../connection.php";

// Check if form data is set and not empty
if (!isset($_POST["name"]) || empty(trim($_POST["name"])) ||
    !isset($_POST["email"]) || empty(trim($_POST["email"])) ||
    !isset($_POST["password"]) || empty(trim($_POST["password"])) ||
    !isset($_POST["age"]) || empty(trim($_POST["age"]))) {
    // Redirect back to registration page if any field is missing or empty
    header("Location: ../register.php?error=emptyfields");
    exit();
}


$name=htmlspecialchars(trim($_POST["name"])); //<script>alert("hello")<script>
$email=htmlspecialchars($_POST["email"]);
$password=htmlspecialchars($_POST["password"]);
$age=htmlspecialchars($_POST["age"]);


if(!filter_var($email,FILTER_VALIDATE_EMAIL))
{
    header("Location:../register.php");
    exit();
}
if($age<=0){
    header("Location:../register.php");
    exit();
}


// $target_dir="../uploads";

// $target_file=$target_dir.$_FILES["profile_picture"];

// move_uplaoded_file($target_file); //will access later; 


// $stmt=$conn->prepare("INSERT INTO users (name,email,password,age) VALUES (?,?,?,?)");
// $stmt->bind_param("sssi",$name,$email,$hashed_passwrod,$age);

//  if($stmt->execute()){
// echo"success";
//  }
//  else{
//     echo $stmt->error;
//  }
$salt=bin2hex(random_bytes(16));  //123
// echo $salt;
$hashed_passwrod=hash("sha256",$salt.$password);
$stmt= $conn->prepare("INSERT INTO users (name,email,password,age,salt) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssis",$name,$email,$hashed_passwrod,$age,$salt);
$stmt->execute();
header("Location:../index.php");
$stmt->close();

$conn->close();


?>
