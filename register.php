<?php
	session_start();
	
	if(isset($_POST['email'])){
		$ok = true;
		$nick = $_POST['nick'];
		
		if((strlen($nick) < 3) || (strlen($nick) > 20)){
			$ok = false;
			$_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";
		}
		
		if(ctype_alnum($nick)==false){
			$ok = false;
			$_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr!";
		}
		
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)){
			$ok = false;
			$_SESSION['e_email'] = "Podaj poprawny adres e-mail!";
		}
		
		//hasla
		
		$haslo1 = $_POST['pass1'];
		$haslo2 = $_POST['pass2'];
		
		if((strlen($haslo1) < 5) || (strlen($haslo1) > 20)){
			$ok = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if($haslo1 != $haslo2){
			$ok = false;
			$_SESSION['e_haslo'] = "Hasła nie są takie same!";			
		}
		
		if(!isset($_POST['regulamin'])){
			$ok = false;
			$_SESSION['e-regul'] = "Potwierdź akceptację regulaminu!";
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else{
				//Czy email istnieje
				$res = $conn->query("SELECT id FROM users WHERE email ='$email'");
				if(!$res) throw new Exception($conn->error);
				
				$nums = $res->num_rows;
				if($nums>0){
					$ok = false;
					$_SESSION['e_email'] = "Taki e-mail jest już w systemie!";
				}
				
				//Czy nick istnieje
				$res = $conn->query("SELECT id FROM users WHERE login ='$nick'");
				if(!$res) throw new Exception($conn->error);
				
				$n__ = $res->num_rows;
				if($n__>0){
					$ok = false;
					$_SESSION['e_nick'] = "Taki login jest już w systemie!";
				}
				
				if($ok == true){
					$f_name = $_POST['f_name'];
					$l_name = $_POST['l_name'];
					$bdate = $_POST['bdate'];
					
					if($conn->query("INSERT INTO users VALUE(NULL, '$nick', '$haslo1', 0, 0, '$f_name', '$l_name', '$bdate', 0, '$email')")){
						$_SESSION['reg_pas'] = true;
						header('Location: welcome.php');
					}
					else throw new Exception($conn->error);
				}
				
				$conn->close();
			}
		}
		
		catch(Exception $e){
			echo '<span style = "color:red;">Błąd serwera.</span>';
			echo '<br/>Informacja developerska: '.$e;
		}
		
	}
?>

<!DOCTYPE HTML>
<html land = "pl">
    <head>
        <meta charset="utf-8"/>
        <title>Rejestracja</title>
		
		<style>
			.error{
				color: red;
				margin-top: 10px;
				margin-bottom: 10px;
			}
		</style>
    </head>
    
    <body>
		<form method = "post">
			
			Nickname: <br/> <input type="text" name = "nick"/><br/>
			<?php
				if(isset($_SESSION['e_nick'])){
					echo '<div class = "error">'.$_SESSION['e_nick'].'</div>';
					unset($_SESSION['e_nick']);
				}
			?>
			
			Imię: <br/> <input type="text" name = "f_name"/><br/>
			
			Nazwisko: <br/> <input type="text" name = "l_name"/><br/>
			
			Data urodzenia: <br/> <input type="date" name = "bdate"/><br/>
			
			E-mail: <br/> <input type="text" name = "email"/><br/>
			
			<?php
				if(isset($_SESSION['e_email'])){
					echo '<div class = "error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			?>
			Twoje hasło: <br/> <input type="password" name = "pass1"/><br/>
			
			<?php
				if(isset($_SESSION['e_haslo'])){
					echo '<div class = "error">'.$_SESSION['e_haslo'].'</div>';
					unset($_SESSION['e_haslo']);
				}
			?>
			
			Powtórz hasło: <br/> <input type="password" name = "pass2"/><br/>
			<label>
			<input type="checkbox" name = "regulamin"/> Akceptuję regulamin
			</label>
			<?php
				if(isset($_SESSION['e-regul'])){
					echo '<div class = "error">'.$_SESSION['e-regul'].'</div>';
					unset($_SESSION['e_regul']);
				}
			?>
			<br/>
			<input type = "submit" value = "Zarejestruj się"/>

		</form>
    </body> 
</html>