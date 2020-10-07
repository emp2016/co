<?php
	/*introducem date personalului*/
	require'constante.php';
	$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
	$stare =1;
	$file = fopen("personal.csv", "r");
	
	while($data = fgetcsv($file)){
		//echo $data[0]."*".$data[1]."*".$data[3]."*".$stare."<br />\n";
		$sir=['functie'=>$data[0],'nume'=>$data[1],'instanta'=>$data[3],'stare'=>$stare,];
		$sql = "INSERT INTO personal(functie, nume, instanta, stare) VALUES (:functie, :nume, :instanta, :stare)";
		$stmt = $con->prepare($sql);
		$stmt->execute($sir);
	}
	fclose($file);
	$con = NULL;
?>
