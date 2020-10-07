<?php
	/*pagina de logout*/
	session_start();
	require 'constante.php';
	$dataIesire=date('Y-m-d H:i:s');
	$utilizator=$_SESSION['admin'];
	$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
	$sql="UPDATE logare SET data_iesire=:dataIesire WHERE utilizator=:utilizator AND id=(SELECT * FROM (SELECT MAX(id) FROM logare) as tabel_temporar) ";
	$sirSql = ['dataIesire'=>$dataIesire,'utilizator'=>$utilizator];
	$stmt=$con->prepare($sql);
	$stmt->execute($sirSql);

	unset($_SESSION['admin']);  
	$con = null;
	$dbh = null;                                                                                                       	
	header("Location: index.php");	
?>
