<?php
	session_start();
	
	if(!isset($_SESSION['Logged'])){
		header('Location: login-index.php');
		exit();
	}
	
		
	require_once "connect.php";

    $conn = @new mysqli($host,  $db_user, $db_pass, $db_name);

    if($conn->connect_errno!=0){
        echo "Error: ".$conn->connect_errno;
    }

	else{
		$Login = $_SESSION['user'];
		$sql = "SELECT * FROM users WHERE login = '$Login'";


		if($result = @$conn->query($sql)){
			$nums = $result->num_rows;
			if($nums>0){
				$row = $result->fetch_assoc();	
				$subs = $row['subscription'];
				$adm = $row['admin'];
				$result->free();
			}
			else{
				$_SESSION['error'] = '<span style = "color:red"> Nieprawidłowy login lub hasło! </span>';
			}
		}
		
		$conn->close();
	}
?>

<!DOCTYPE HTML>
<html land = "pl">
    <head>
        <meta charset="utf-8"/>
        <title>Logowanie do systemu</title>
    </head>
    
    <body>
		<?php
			echo "<p>Witaj ".$_SESSION['firstname']."!</p>";
			echo '[<a href = "logout.php">Wyloguj się</a>]';
			echo "</br>";
			echo "</br>";
			
			if($subs){
				echo"<p> Masz ważną subskrypcję!";
				echo "<br/>";
				echo'<a href = "books.php">Katalog e-booków</a>';
				echo "<br/>";
				echo'<a href = "transaction.php">Lista transakcji</a>';
				echo "<br/>";
			}
			else{
				echo "<p> Nie masz ważnej subskrypcji!";
				echo "<br/>";
				echo'<a href = "premium.php">Wykup subskrypcję!</a>';
				echo "<br/>";
			}
			
			if($adm){
				echo "<br/>";
				echo "Panel administratora:";
				echo "<br/>";
				echo'<a href = "admin.php">Dodaj nowego eBooka</a>';
			}
		?>
    </body> 
</html>