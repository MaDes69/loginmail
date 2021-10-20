
<?php
// formulaire de création de compte //

// Include config file
require "config.php";
 
// Define variables and initialize with empty values
$username  = $password = $confirm_password = $email = $upload = "";
$username_err =  $password_err = $confirm_password_err = $email_err = $upload_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){   //trim enleve les espaces dans une chaîne de caractère
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){   // preg match represente les conditions de caractère
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // lie less variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    


    //Validation email 

    //  if (empty($_POST["email"])) {
    //     $email_err = "Email is required";
    //    } else {
    //      $email = trim($_POST["email"]);

    //      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //        $email_err = "Invalid email format";
    //      }
    //   }

    if(empty(trim($_POST["email"]))){
        $email_err = "please enter a email adress.";
        }
        elseif (!preg_match(
        "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,10})$/i",
        trim($_POST["email"])))
        
        {
        $email_err= "\n Error: Invalid email address";
        }
        
        else{
        // $email = trim($_POST['email']);
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        
        // Set parameters
        $param_email = trim($_POST["email"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
        /* store result */
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){
        $email_err = "This email is already taken.";
        } else{
        $email = trim($_POST["email"]);
        }
        } else{
        echo "Oops! Something went wrong. Please try again later.";
        }
        
        
        // Close statement
        mysqli_stmt_close($stmt);
        }
        }
    // if (empty($_POST["email"])) {
    //         $email_err = "Email is required";

            
    //         } else {
    //             $sql = "SELECT id FROM users WHERE email = ?";
        
    //             if($stmt = mysqli_prepare($link, $sql)){
    //                 // lie less variables to the prepared statement as parameters
    //                 mysqli_stmt_bind_param($stmt, "s", $param_email);
                    
    //                 // Set parameters
    //                 $param_email = trim($_POST["email"]);
                    
    //                 // Attempt to execute the prepared statement
    //                 if(mysqli_stmt_execute($stmt)){
    //                     /* store result */
    //                     mysqli_stmt_store_result($stmt);
                        
    //                     if(mysqli_stmt_num_rows($stmt) == 1){
    //                         $email_err = "This email is already taken.";
    //                     } else{
    //                         $email = trim($_POST["email"]);
    //                     }
    //                 } else{
    //                     echo "Oops! Something went wrong. Please try again later.";
    //                 }

    //                     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //                      $email_err = "Invalid email format";
    //                      }
    //                 // Close statement
    //                 mysqli_stmt_close($stmt);
    //             }
    //         }
    
            // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //   $email_err = "Invalid email format";
            //  }
           


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_img =  basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    $upload_err = "File is not an image.";
    $uploadOk = 0;
  }


// Check if file already exists
if (file_exists($target_file)) {
    $upload_err = "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $upload_err = "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $upload_err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $upload_err =  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  
//  $sql = "INSERT INTO files (nom_img) values('$target_img')";
//  mysqli_query($link, $sql);

} 
  
  
  else {
    $upload_err =  "Sorry, there was an error uploading your file.";
  }
}
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) &&empty($password_err) && empty($confirm_password_err) && empty($upload_err)){

        $verification = substr(md5(mt_rand()), 0, 15);


        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email, role, activation, verification, img) VALUES (?, ?, ?, 'guest', 0, '$verification', '$target_img')"; // ? valeur dynamique qui correspond a $param_username et $param_password
         
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
          
            
            // Préparation du mail contenant le lien d'activation
            $destinataire = $email;
            $sujet = "Activer votre compte" ;
            $entete = "From: inscription@projet-gironde.com" ;
            
            // Le lien d'activation est composé du username d'email et de la clé(verification)
            $message = 'Bienvenue sur Notre site web,
            Pour activer votre compte, veuillez cliquer sur le lien ci-dessous ou copier/coller dans votre navigateur Internet.
            
            https://mariond.promo-90.codeur.online/loginmail/activation.php?username='.urlencode($username). '&email='.urlencode($email). '&verification='.urlencode($verification).'
            
            
            ---------------
            Ceci est un mail automatique, Merci de ne pas y répondre.';
            
            
            mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail



            // var_dump($stmt);
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            //var_dump($stmt);

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
    <!-- <link rel="stylesheet" href="registre.css" -->
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
           

            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group">
            
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload" class="form-control <?php echo (!empty($upload_err)) ? 'is-invalid' : ''; ?>">
          <span class="invalid-feedback"><?php echo $upload_err; ?></span>
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>

            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
        
    
    </div>     
</body>
</html>
<!-- https://www.w3schools.com/php/php_file_upload.asp -->
