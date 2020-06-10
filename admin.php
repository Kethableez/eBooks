<?php
	session_start();
	
	if(isset($_POST['a_fname'])){
		$ok = true;
		$a_fname = $_POST['a_fname'];
		
		if((strlen($a_fname) < 3) || (strlen($a_fname) > 20)){
			$ok = false;
			$_SESSION['e_fname'] = "Imię musi posiadać od 3 do 20 znaków!";
		}
		
		$a_lname = $_POST['a_lname'];
		
		if((strlen($a_lname) < 3) || (strlen($a_lname) > 20)){
			$ok = false;
			$_SESSION['e_lname'] = "Nazwisko musi posiadać od 3 do 20 znaków!";
		}
		
		$a_title = $_POST['title'];
		if((strlen($a_title) < 3)){
			$ok = false;
			$_SESSION['e_tile'] = "Tytuł musi posiadać więcej niż 3 znaki!";
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			
			else{
				if($ok == true){
					$date = $_POST['year'];
					$dect = $_POST['desc'];
					if($conn->query("INSERT INTO ebooks VALUE(NULL, '$a_fname', '$a_lname', '$a_title', '$dect', '$date')")){
						$_SESSION['add_pass'] = true;
						//header('Location: welcome.php');
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
        <title>Dodawanie nowej</title>
		
		<style>
			.error{
				color: red;
				margin-top: 10px;
				margin-bottom: 10px;
			}
		</style>
    </head>
    
    <body>
		<a href = "Main_Panel.php">Powrót do panelu głównego</a>
		
		<form method = "post">	
			<?php
				if(isset($_SESSION['add_pass'])){
					if($_SESSION['add_pass']){
						echo "<br/>";
						echo"Dodano pomyślnie nową książkę!";
						echo "<br/>";
						unset($_SESSION['add_pass']);
					}
				}
			?>
			
			
			Wpisz imię autora: <br/> <input type="text" name = "a_fname"/><br/>
			<?php
				if(isset($_SESSION['e_fname'])){
					echo '<div class = "error">'.$_SESSION['e_fname'].'</div>';
					unset($_SESSION['e_fname']);
				}
			?>
			
			Wpisz nazwisko autora: <br/> <input type="text" name = "a_lname"/><br/>
			
			<?php
				if(isset($_SESSION['e_lname'])){
					echo '<div class = "error">'.$_SESSION['e_lname'].'</div>';
					unset($_SESSION['e_lname']);
				}
			?>
			
			Wpisz tytuł ksiązki: <br/> <input type="text" name = "title"/><br/>
			
			<?php
				if(isset($_SESSION['e_title'])){
					echo '<div class = "error">'.$_SESSION['e_title'].'</div>';
					unset($_SESSION['e_title']);
				}
			?>
						
			Dodaj rok wydania: <br/> <input type="date" name = "year"/><br/>
						
			Dodaj opis książki: <br/> <input type="text" name = "desc"/><br/>
			
			<br/>
			<input type = "submit" value = "Dodaj nową książkę"/>
		</form>
    </body> 
</html>