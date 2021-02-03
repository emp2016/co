<?php
	/*modificare date personal*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		$numePersonalModifica=$okNumePersonalModifica='';
		$numePersonalModificaEroare='';
		require'functii.php';
		require'constante.php';
		cap();
		meniu();
		$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
		if(isset($_GET['npm'])){//revenim dupa modificare
			$numePersonalModifica = $_GET['npm'];
			$okNumePersonalModifica = 1;
		}
		if(isset($_POST['numePersonalModifica'])){
			if(empty($_POST['numePersonalModifica'])){
				$numePersonalModificaEroare = 'Obligatoriu';
			}
			else{
				$numePersonalModifica = $_POST['numePersonalModifica'];
				$okNumePersonalModifica = 1;
			}
		}
		echo'<div class="col-9 col-s-12">';
			echo'<h3>Modificare date personal:</h3>';
			echo'<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="POST">';
echo'Nume:&nbsp;&nbsp;<input type="text" name="numePersonalModifica" value="'.$numePersonalModifica.'" placeholder="Introduceti un nume" onchange="this.form.submit()" autofocus><span class="eroare">*'.$numePersonalModificaEroare.'</span><br /><br />';
			echo'</form>';
			//echo $numePersonalModifica.'****'.$okNumePersonalModifica.'<br />';
			if($okNumePersonalModifica == 1){
				$sir = ["%".ucfirst($numePersonalModifica)."%"];
				$sql1="SELECT * FROM personal_modificat WHERE nume like ? AND stare=1  GROUP BY nume ASC ";
				$stmt1 = $con->prepare($sql1);
				$stmt1->execute($sir);		
				while($row1=$stmt1->fetch()){
echo'<a href="modifica-date-personal.php?nume='.$row1['nume'].'">'.$row1['nume'].'</a><br /><br />';
				}
/*
				echo'<form action="modifica-date-personal.php" method="POST">';
					//echo'<input type="hidden" name="nume4" value="'.$numePersonalModifica.'">';
					echo'<input type="text" name="nume4" value="'.$numePersonalModifica.'">';
					echo'Instanta:&nbsp;&nbsp;';
					echo'<select name="instanta1">';//afisam instantele
						echo'<option value="'.$row1['instanta'].'" selected>'.$row1['instanta'].'</option>';
						$sir2=['instanta2'=>$row1['instanta']];
						$sql2 = "SELECT instanta FROM instante WHERE instanta <> :instanta2 AND stare=1";
						$stmt2 = $con->prepare($sql2);
						$stmt2->execute($sir2);
						while($row2=$stmt2->fetch()){
							echo'<option value="'.$row2['instanta'].'">'.$row2['instanta'].'</option>';
						}
					echo'</select><br /><br />';
					echo'Functia:&nbsp;&nbsp;<input type="text" name="functia" value="'.$row1['functia'].'">';
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
				*/
			}
		echo'</div>';//end div class col-9 col-s-12
		jos();
	}
	else{
   		header("Location: logare.php");
   }
?>
