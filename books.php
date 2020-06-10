<!DOCTYPE html>
<html lang=\"pl-PL\">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
    <title>Lista e-booków</title>
</head>
    
<body>
    <a href = "Main_Panel.php">Powrót do panelu głównego</a>
    <table width="1000" align="center" border="1" bordercolor="#d5d5d5"  cellpadding="0" cellspacing="0">
        <tr>
        <?php
            ini_set("display_errors", 0);
            require_once "connect.php";
            $polaczenie = mysqli_connect($host, $db_user, $db_pass);
			mysqli_query($polaczenie, "SET CHARSET utf8");
			mysqli_query($polaczenie, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
            mysqli_select_db($polaczenie, $db_name);
            
            $zapytanietxt = file_get_contents("zapytanie.txt");
            
            $rezultat = mysqli_query($polaczenie, $zapytanietxt);
            $ile = mysqli_num_rows($rezultat);
           
if ($ile>=1) 
{
echo<<<END
<td width="50" align="center" bgcolor="e5e5e5">idksiazki</td>
<td width="100" align="center" bgcolor="e5e5e5">imieautora</td>
<td width="100" align="center" bgcolor="e5e5e5">nazwiskoautora</td>
<td width="100" align="center" bgcolor="e5e5e5">tytul</td>
<td width="100" align="center" bgcolor="e5e5e5">opis</td>
<td width="50" align="center" bgcolor="e5e5e5">rok</td>
</tr><tr>
END;
}

	for ($i = 1; $i <= $ile; $i++) 
	{
		
		$row = mysqli_fetch_assoc($rezultat);
		$a1 = $row['id_book'];
		$a2 = $row['author_fname'];
		$a3 = $row['author_lname'];
		$a4 = $row['title'];
		$a5 = $row['description'];
		$a6 = $row['year'];	
		
echo<<<END
<td width="50" align="center">$a1</td>
<td width="100" align="center">$a2</td>
<td width="100" align="center">$a3</td>
<td width="100" align="center">$a4</td>
<td width="100" align="center">$a5</td>
<td width="100" align="center">$a6</td>
</tr><tr>
END;
			
	}
?>


</tr></table>



</body>
</html>