<?php
//Partie du code à mettre au début de chaque page que l'on veut protéger (partie php)
// Initialize the session
session_start();

 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

 
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<?php

    include('config.php');

        $username = $_SESSION["username"]; 

       
        $req = "SELECT img FROM users where username = '$username'";
        $result = mysqli_query($link, $req);
        $row = mysqli_fetch_assoc($result);
      
        echo "<img src='./uploads/".$row['img']."' width='400px' ><br>";
        
?>
    <h1 class="my-5">Boujour, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reinitialisez votre mot de passe.</a>
        <a href="logout.php" class="btn btn-danger ml-3">Deconnexion.</a>
    </p>
</body>
</html>