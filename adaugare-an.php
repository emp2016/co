<?php
    //ATENTIE:Se va executa O SINGURA DATA

    require'functii.php';
    require 'constante.php';
	$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);

	$query = "SELECT DISTINCT(nume),functia, instanta FROM personal_modificat WHERE stare=1 ORDER BY functia ASC";
	$stmtPersonal = $con->prepare($query);
	$stmtPersonal->execute();
	$i = 1;
	echo 'Adaugam an nou in tabelul personal_modificat.';
	while($row=$stmtPersonal->fetch()){
		//echo $i++.'. '.$row['nume'].'---'.$row['functia'];
		switch($row['functia']){
			case "Judecator":
				$acordate =35;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Judecator", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Asistent Judiciar":
				$acordate =35;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Asistent Judiciar", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Grefier":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir = ['functia'=>"Grefier", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt = $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Grefier statistician":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Grefier statistician", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Grefier-arhivar":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Grefier-arhivar", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Specialist IT":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Specialist IT", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Agent procedural":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Agent procedural", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Aprod":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Aprod", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Sofer":
				$acordate =30;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Sofer", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Manager economic":
				$acordate =25;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Manager economic", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Consilier superior":
				$acordate =25;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Consilier superior", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Expert superior":
				$acordate =25;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Expert superior", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Muncitor calificat":
				$acordate =25;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Muncitor calificat", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Muncitor necalificat":
				$acordate =25;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Muncitor necalificat", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
			case "Muncitor":
				$acordate =25;
				$anul =2023;
				$stare =1;
				$sir= ['functia'=>"Muncitor", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
				$sql = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
				$stmt= $con->prepare($sql);
				$stmt->execute($sir);
			break;
		}
	}
/*				
		if ($row['functia'] == 'Judecator'){
			$acordate =35;
			$anul =2023;
			$stare =1;
			$sir_judecator = ['functia'=>"Judecator", 'nume'=>$row['nume'], 'acordate'=> $acordate, 'anul'=>$anul, 'instanta'=> $row['instanta'], 'stare'=>$stare];
			$sql_judecator = "INSERT INTO personal_modificat (id, functia, nume, acordate, anul, instanta, stare) VALUES (NULL, :functia, :nume, :acordate, :anul, :instanta, :stare)";
			$stmt_judecator = $con->prepare($sql_judecator);
			$stmt_judecator->execute($sir_judecator);
		}
	}
*/
/*
	$sql = "INSERT INTO concediu(nume, dataInceput, dataSfarsit,an, numarZile, observatii, stare) VALUES (:nume,:dataInceput, :dataSfarsit,:an, :numarZile, :observatii, :stare)";
					$stmt = $con->prepare($sql);
					$stmt->execute($data);

	$nume=$_POST['numeInitial'];
			$sirSterge=['numeSterge'=>$nume];
			$sqlSterge="UPDATE personal_modificat SET stare=0 WHERE nume=:numeSterge";
			$stmtSterge=$con->prepare($sqlSterge);
			$stmtSterge->execute($sirSterge);
			header("Location: modifica-personal.php");
*/

 ?>
