<?php
    
    require'functii.php';
    require 'constante.php';
	$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);

	$query = "SELECT DISTINCT(nume),functia FROM personal_modificat WHERE stare=1 ORDER BY functia ASC";
	$stmtPersonal = $con->prepare($query);
	$stmtPersonal->execute();
	$i = 1;
	while($row=$stmtPersonal->fetch()){
		echo $i++.'. '.$row['nume'].'---'.$row['functia'].'<br />';	
	}
/*
	$sql = "INSERT INTO concediu(nume, dataInceput, dataSfarsit,an, numarZile, observatii, stare) VALUES (:nume,:dataInceput, :dataSfarsit,:an, :numarZile, :observatii, :stare)";
					$stmt = $con->prepare($sql);
					$stmt->execute($data);
*/

 ?>
