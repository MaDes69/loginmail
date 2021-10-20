<?php
if(!isset($message)) {
	require_once("config.php");
	$db_handle = new config();
	$mysql_query = "SELECT * FROM users where email = '" . $_POST["email"] . "'";
	$count = $db_handle->numRows($mysql_query);
	
	if($count==0) 
    {
		$mysql_query("INSERT INTO users (username, password, email,role,activation,verificaction) VALUES(?, ?, ?, 'guest', 0, '$verification')"

		if(!empty($current_id)) {
			$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."activate.php?id=" . $current_id;
			$toEmail = $_POST["email"];
			$subject = "User Registration Activation Email";
			$content = "Click this link to activate your account. 
            http://www.yourwebsite.com/verify.php?email='.$email.'&password='.$password.';"

			$mailHeaders = "From: Admin\r\n";

			if(mail($toEmail, $subject, $content, $mailHeaders)) {
				$message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";	
				$type = "success";
			}
			unset($_POST);
		} else {
			$message = "Problem in registration. Try Again!";	
		}
	} else {
		$message = "User Email is already in use.";	
		$type = "error";
	}
}
?>