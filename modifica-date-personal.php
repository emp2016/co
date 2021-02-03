<?php
	/*actiunea din pagina modifica-personal.php*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		require'functii.php';
		require'constante.php';
		cap();
		meniu();
		$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
		@$numePersonalModifica=testCamp($_GET['nume']);
		//afisam datele pentru persoana aleasa
		$sir = ['numePersonalModifica'=>$numePersonalModifica];
		$sql = "SELECT * FROM personal_modificat WHERE nume=:numePersonalModifica AND stare=1";
		$stmt = $con->prepare($sql);
		$stmt->execute($sir);
		$row = $stmt -> fetch();		
		echo'<div class="col-9 col-s-12">';
			echo'<h3>Modificare date personal:</h3>';
			echo'<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="POST">';
				echo'<input type="hidden" name="numeInitial" value="'.$numePersonalModifica.'">';
				echo'Nume:&nbsp;&nbsp;<input type="text" name="numePersonal" value="'.$numePersonalModifica.'"><br /><br />';
				echo'Instanta:&nbsp;&nbsp;';
					echo'<select name="instanta">';//afisam instantele
						echo'<option value="'.$row['instanta'].'" selected>'.$row['instanta'].'</option>';
						$sir1=['instanta1'=>$row['instanta']];
						$sql1 = "SELECT instanta FROM instante WHERE instanta <> :instanta1 AND stare=1";
						$stmt1 = $con->prepare($sql1);
						$stmt1->execute($sir1);
						while($row1=$stmt1->fetch()){
							echo'<option value="'.$row1['instanta'].'">'.$row1['instanta'].'</option>';
						}
					echo'</select><br /><br />';
				echo'Functia:&nbsp;&nbsp;<input type="text" name="functia" value="'.$row['functia'].'">';
					echo'<br /><br />';
					//afisam anii si numarul de zile cuvenite
					$anulPrecedent = date("Y")-1;
					$sql3="SELECT anul, acordate FROM personal_modificat WHERE nume=:nume3 AND anul=:anulPrecedent AND stare=1";
					$sir3=['nume3'=>$numePersonalModifica,'anulPrecedent'=>$anulPrecedent];
					$stmt3=$con->prepare($sql3);
					$stmt3->execute($sir3);
					$row3=$stmt3->fetch();
					$anulCurent = date("Y");
					$sql4="SELECT anul, acordate FROM personal_modificat WHERE nume=:nume3 AND anul=:anulCurent AND stare=1";
					$sir4=['nume3'=>$numePersonalModifica,'anulCurent'=>$anulCurent];
					$stmt4=$con->prepare($sql4);
					$stmt4->execute($sir4);
					$row4=$stmt4->fetch();
					$anulUrmator = date("Y")+1;
					$sql5="SELECT anul, acordate FROM personal_modificat WHERE nume=:nume3 AND anul=:anulUrmator AND stare=1";
					$sir5=['nume3'=>$numePersonalModifica,'anulUrmator'=>$anulUrmator];
					$stmt5=$con->prepare($sql5);
					$stmt5->execute($sir5);
					$row5=$stmt5->fetch();
					echo'<table>';
					echo'<tr><td>Anul</td><td>Zile cuvenite</td></tr>';
					echo'<tr>';
						echo'<td><input type="text" name="anPrecedent" value="'.$row3['anul'].'" readonly></td>';
						echo'<td><input type="number" min="0" max="35" name="zilePrecedent" value="'.$row3['acordate'].'"></td>';
					echo'</tr>';
					echo'<tr>';
						echo'<td><input type="text" name="anCurent" value="'.$row4['anul'].'" readonly></td>';
						echo'<td><input type="number" min="0" max="35" name="zileCurent" value="'.$row4['acordate'].'"></td>';
						echo'</tr>';
						echo'<tr>';
						echo'<td><input type="text" name="anUrmator" value="'.$row5['anul'].'" readonly></td>';
						echo'<td><input type="number" min="0" max="35" name="zileUrmator" value="'.$row5['acordate'].'"></td>';
						echo'</tr>';
					echo'</table><br /><br />';
?>
					<input type="submit" name="modifica" value="Modifica" onClick="javascript:return confirm('Modificati datele in baza de date?');">&nbsp;&nbsp;
								&nbsp;&nbsp;<input type="submit" name="sterge" value="Sterge" onClick="javascript:return confirm('Stergeti datele in baza de date?');">
<?php
			echo'</form>';
		echo'</div>';
		if(isset($_POST['modifica'])){//modificam date personal
			$numeInitial = $_POST['numeInitial'];
			$nume=$_POST['numePersonal'];
			$instanta=$_POST['instanta'];
			$functia=$_POST['functia'];
			$anPrecedent=$_POST['anPrecedent'];
			$anCurent=$_POST['anCurent'];
			$anUrmator=$_POST['anUrmator'];
			$zilePrecedent=$_POST['zilePrecedent'];
			$zileCurent=$_POST['zileCurent'];			
			$zileUrmator=$_POST['zileUrmator'];
			echo $numeInitial.'*'.$nume.'*'.$instanta.'*'.$functia.'*'.$anPrecedent.'*'.$anCurent.'*'.$zilePrecedent.'*'.$zileCurent;
			//facem modificarile
			$sirPrecedent=['instanta'=>$instanta,'functia'=>$functia,'zilePrecedent'=>$zilePrecedent, 'anPrecedent'=>$anPrecedent, 'numeInitial'=>$numeInitial];
			$sqlPrecedent="UPDATE personal_modificat SET instanta=:instanta,functia=:functia,  acordate=:zilePrecedent WHERE anul=:anPrecedent AND nume=:numeInitial";
			$stmtPrecedent=$con->prepare($sqlPrecedent);
			$stmtPrecedent->execute($sirPrecedent);
			$sirCurent=['instanta'=>$instanta,'functia'=>$functia,'zileCurent'=>$zileCurent, 'anCurent'=>$anCurent, 'numeInitial'=>$numeInitial];
			$sqlCurent="UPDATE personal_modificat SET instanta=:instanta,functia=:functia,  acordate=:zileCurent WHERE anul=:anCurent AND nume=:numeInitial";
			$stmtCurent=$con->prepare($sqlCurent);
			$stmtCurent->execute($sirCurent);
			$sirUrmator=['instanta'=>$instanta,'functia'=>$functia,'zileUrmator'=>$zileUrmator, 'anUrmator'=>$anUrmator, 'numeInitial'=>$numeInitial];
			$sqlUrmator="UPDATE personal_modificat SET instanta=:instanta,functia=:functia,  acordate=:zileUrmator WHERE anul=:anUrmator AND nume=:numeInitial";
			$stmtUrmator=$con->prepare($sqlUrmator);
			$stmtUrmator->execute($sirUrmator);
			//modificam numele in tabelul personal_modificat
			$sirNumeModificat = ['numeModificat'=>$nume,'numeInitial'=>$numeInitial];
			$sqlNumeModificat = "UPDATE personal_modificat SET nume=:numeModificat WHERE nume=:numeInitial";
			$stmtNumeModificat = $con->prepare($sqlNumeModificat);
			$stmtNumeModificat->execute($sirNumeModificat);
			//in cazul modificarii numelui,modificam si in tabelul concediu numele
			$sirConcediu=['numeConcediu'=>$nume,'numeInitial'=>$numeInitial];
			$sqlConcediu="UPDATE concediu SET nume=:numeConcediu WHERE nume=:numeInitial";
			$stmtConcediu=$con->prepare($sqlConcediu);
			$stmtConcediu->execute($sirConcediu);
			//echo $stmtConcediu->rowCount();
			header("Location: modifica-personal.php?npm=$nume");//npm=numePersonalModifica
		}
		if(isset($_POST['sterge'])){
			$nume=$_POST['numeInitial'];
			$sirSterge=['numeSterge'=>$nume];
			$sqlSterge="UPDATE personal_modificat SET stare=0 WHERE nume=:numeSterge";
			$stmtSterge=$con->prepare($sqlSterge);
			$stmtSterge->execute($sirSterge);
			header("Location: modifica-personal.php");
		}
		jos();
	}
	else{
   		header("Location: logare.php");
   }
	
?>
