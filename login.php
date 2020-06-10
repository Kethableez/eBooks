<?php
	session_start();
	
	if((!isset($_POST['Login'])) || (!isset($_POST['Password']))){
		header('Location: login-index.php');
		exit();
	}

    require_once "connect.php";

    $conn = @new mysqli($host,  $db_user, $db_pass, $db_name);

    if($conn->connect_errno!=0){
        echo "Error: ".$conn->connect_errno;
    }
	
	else{
		$Login = $_POST['Login'];
		$Haslo = $_POST['Password'];
		
		$sql = "SELECT * FROM users WHERE login = '$Login' AND pass = '$Haslo'";

		if($result = @$conn->query($sql)){
			$nums = $result->num_rows;
			if($nums>0){
				$row = $result->fetch_assoc();			
				$_SESSION['user'] = $row['login'];
				$_SESSION['firstname'] = $row['name'];
				$_SESSION['adm'] = $row['admin'];
				$_SESSION['sub'] = $row['subscription'];
				
				$_SESSION['Logged'] = true;
				
				unset($_SESSION['error']);
				$result->free();
				header('Location: Main_Panel.php');
			}
			else{
				$_SESSION['error'] = '<span style = "color:red"> Nieprawidłowy login lub hasło! </span>';
				header('Location: login-index.php');
			}
		}
		
		$conn->close();
	}
?>