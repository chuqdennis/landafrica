<?php
        include_once ("session.php");
        include_once ("admin.php");
        
        $site = new admin;
        $email = htmlentities(trim($_POST["email"]));
        $password = htmlentities(trim($_POST["password"]));
        $password = sha1($password);
        $query = "SELECT * FROM site_settings WHERE email='$email' AND password='$password' ";
        $login = $site->adminLogin($query);
        if ($login == 'false') {
        	echo 'Sorry, email or password incorrect';
        }else{
        	$_SESSION['myAdmin'] = $login['myAdmin'];
			$_SESSION['adminEmail'] = $login['email'];
			echo('done');
        }
?>