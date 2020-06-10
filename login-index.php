<?php
	session_start();
	
	if (isset($_SESSION['Logged']) && ($_SESSION['Logged'] == true)){
		header('Location: Main_Panel.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html land = "pl">
    <head>
        <meta charset="utf-8"/>
        <title>Logowanie do systemu</title>
    </head>
    
    <body>
        <form action="login.php" method="post">
            Login: <br/> <input type="text" name="Login" /> <br/>
            Hasło: <br/> <input type="password" name="Password" /> <br/><br/>
            <input type="submit" value="Zaloguj się"/>
        </form>
        <?php
			if(isset($_SESSION['error'])){
				echo $_SESSION['error'];
			}
		?>
    </body> 
</html>