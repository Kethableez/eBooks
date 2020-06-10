<?php
	session_start();
	
	if (!isset($_SESSION['reg_pas'])){
		header('Location: index.html');
		exit();
	}
	
	else{
		unset($_SESSION['reg_pas']);
	}
?>

<!DOCTYPE HTML>
<html land = "pl">
    <head>
        <meta charset="utf-8"/>
        <title>Logowanie do systemu</title>
    </head>
    
    <body>
		Dziekujemy za rejestrację. Możesz już się zalogować!
		<br/>
        <a href = "login-index.php"> Zaloguj się!</a>
    </body> 
</html>