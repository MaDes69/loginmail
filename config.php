<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');  
define('DB_USERNAME', 'root');  //mariond
define('DB_PASSWORD', '0000');  //tH2uwo5xwh3Dnw==
define('DB_NAME', 'loginmail');  //changer nom du répertoire 'login' mariond_loginmail

 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

