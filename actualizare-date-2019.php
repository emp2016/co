<?php
	/*actualizare date anul 2019*/
	require'constante.php';
	$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
	$con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$ramase=$numePersonal=$acordate=$numarZile='';
	if(isset($_POST['ok'])){
		$numePersonal=$_POST['numePersonal'];
		$ramase=$_POST['ramase'];
		$sir=['nume'=>$numePersonal];
		$sql="SELECT acordate FROM personal WHERE nume=:nume";
		$stmtSql=$con->prepare($sql);
		$stmtSql->execute($sir);
		while($rez=$stmtSql->fetch()){
			$acordate=$rez['acordate'];
			$numarZile=$acordate-$ramase;
		}
		$sir1=['numePersonal'=>$numePersonal,'numarZile'=>$numarZile];
		//$insert="INSERT INTO concediu(id,nume,dataInceput,dataSfarsit,an,numarZile,observatii,stare) VALUES ('',:numePersonal,'','','2019',:numarZile,'','1')";
		$sql1="INSERT INTO concediu (nume,dataInceput,dataSfarsit,an,numarZile,observatii,stare) VALUES (:numePersonal,'2018-01-01','2018-01-01','2018',:numarZile,'Actualizare-date-2018','1')";
		$stmt1=$con->prepare($sql1);
		$stmt1->execute($sir1);
	}
	echo'<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="POST">';
		echo'<select name="numePersonal">';
			//populam lista cu numele personalului
			$query="SELECT * FROM personal  WHERE stare=1 ORDER BY nume ASC";
			$stmt=$con->prepare($query);
			$stmt->execute();
			echo'<option value="Alegeti o persoana">...</option>';
			while($row=$stmt->fetch()){
				echo'<option value="'.$row['nume'].'"';
					if(isset($numePersonal)&&($numePersonal==$row['nume'])){
						echo'selected';
					}
				echo'>';
				echo $row['nume'];
				echo'</option>';
			}
		echo'</select><br /><br />';
		echo'Ramase:<input type="text" name="ramase" value="'.$ramase.'"><br /><br />';
		echo'<input type="submit" name="ok" value="OK">';
	echo'</form>';
	
	echo $numePersonal.'<br />Acordate:'.$acordate.'<br />Ramase:'.$ramase.'<br />Efectuate:'.$numarZile;
	
?>
