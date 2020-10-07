<?php
	/*introducem date personalului*/
	require'constante.php';
	$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
	$sql = "select * from personal";
	$stmt = $con->prepare($sql);
	$stmt->execute();
	while($row = $stmt->fetch()){
		echo $row['nume'].'***'.$row['instanta'].'***'.$row['functie'].'***'.$row['acordate'].'<br />';	
	}
	
	$con = NULL;
?>
