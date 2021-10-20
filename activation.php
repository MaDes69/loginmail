<?php
	require_once("config.php");
	 if(isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['verification']) && !empty($_GET['verification'])){
      $email   = $_GET['email']; // Récupération des variables de l'url(get) nécessaires à l'activation
       $verif = $_GET['verification']; 
       //Récupération de la clé correspondant au $email dans la base de données
    $sql = "SELECT activation, verification FROM users WHERE email = '$email'";
    $req = mysqli_query($link, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error());
    $row = mysqli_fetch_assoc($req);
    $activbd = $row ['activation'];// $activation contiendra alors 0 ou 1
    $verifbd = $row ['verification'];// Récupération de la clé

     if ($activbd == 1){ //Si le compte est déjà actif on prévient 
         echo ' votre compte est déjà activé.';
     }
     else{ // Si ce n'est pas le cas on passe aux comparaisons
        if ($verif == $verifbd){ // On compare nos deux clés
         $sql="UPDATE users set activation = 1 WHERE email = '$email'";  //La requête qui va passer notre champ isactif de 0 à 1
         mysqli_query($link, $sql);
         echo 'Votre compte a bien été activé.';
     }
     else{
         echo 'Erreur, votre compte ne peut-être activé.'; // Si les deux clés sont différentes on provoque une erreur...
     }

     }
     }
	
?>