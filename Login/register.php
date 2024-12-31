<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="actions/registerLogic.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="age">Age:</label><br>
        <input type="number" id="profile_picture" name="age" required><br><br>

        <!-- <label for="profile_picture">profile:</label><br>
        <input type="file" id="profile_picture" name="profile_picture" required><br><br> -->
        <input type="submit">
        
</body>
</html>