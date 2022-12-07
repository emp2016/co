<?php
	/*rapoarte referitoare la zilele de concediu de odihna*/
	if(!isset($_SESSION)){
		session_start();
	}
	$numePersonalRapoarte=$stmtPersonal=$ok=$okNumePersonal=$modificaMesaj=$modifica='';
	$numePersonalRapoarteEroare='';
	if(isset($_SESSION['admin'])){
		require'functii.php';
		require'constante.php';
		cap();
		meniu();
		$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
		if(isset($_GET['numePersonal'])){
			$numePersonalRapoarte=$_GET['numePersonal'];
			$ok=1;
			$okNumePersonal=1;
		}
		if(isset($_GET['nms'])&&($_GET['modifica']==sha1(1))){//nms=nume modifica sterge
			$numePersonalRapoarte=$_GET['nms'];
			$ok=1;
			$okNumePersonal=1;
		}
		if(isset($_GET['modifica'])&& ($_GET['modifica']==sha1(0))){
			$numePersonalRapoarte=$_GET['nms'];
			$ok=1;
			$okNumePersonal=1;
			$modificaMesaj="Data inceput trebuie sa fie mai mica sau egala cu data sfarsit";
		}
		if(isset($_POST['numePersonalRapoarte'])){
			if($_POST['numePersonalRapoarte']=='...'){
				$numePersonalRapoarteEroare='Obligatoriu';			
			}
			else{
				$numePersonalRapoarte = $_POST['numePersonalRapoarte'];
				$okNumePersonal = 1;
			}
		}
		if($okNumePersonal==1){
			$sql = "select * from concediu where nume=:numePersonalRapoarte and stare=1 order by dataInceput desc";
			$sir=['numePersonalRapoarte'=>$numePersonalRapoarte];
			$stmtPersonal=$con->prepare($sql);
			$stmtPersonal->execute($sir);
			$ok=1;
		}
		echo'<div class="col-9 col-s-12">';
			echo'<a href="rapoarte.php"><h3>Rapoarte:</h3></a>';
			echo'<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="POST">';
				echo'Nume:';
				echo'<select name="numePersonalRapoarte" onchange="this.form.submit()">';
					echo'<option value="...">...</option>';
					$query = "select distinct(nume) from personal_modificat where stare=1 order by nume asc";
					$stmt = $con->prepare($query);
					$stmt->execute();
					while($row=$stmt->fetch()){
						echo'<option value="'.$row['nume'].'"';
						if(isset($numePersonalRapoarte)&&($numePersonalRapoarte==$row['nume'])){
							echo'selected';
						}
						echo'>'.$row['nume'].'</option>';
					}
				echo'</select><span class="eroare">*'.$numePersonalRapoarteEroare.'</span><br /><br />';
			echo'</form>';

			if(isset($stmtPersonal)&&($stmtPersonal!=='')&&($stmtPersonal->rowCount()>0)){
				echo'<table class="tabel">';
					echo'<tr><th>Concediu aferent anului</th><th>Data inceput</th><th>Data sfarsit</th><th>Numar zile</th><th>Operatiuni<br /><span class="eroare">'.$modificaMesaj.'</span></th></tr>';
					while($linie=$stmtPersonal->fetch()){
						echo'<form action="modifica-date.php" method="POST">';
							echo'<tr>';
								echo'<td><input type="text" name="modificaAn" value="'.$linie['an'].'" maxlength="4" size="4"></td>';
								echo'<td><input type="text" name="modificaInceput" value="'.date("d-m-Y", strtotime($linie['dataInceput'])).'" maxlength="10" size="10"></td>';
								echo'<td><input type="text" name="modificaSfarsit" value="'.date("d-m-Y", strtotime($linie['dataSfarsit'])).'" maxlength="10" size="10"></td>';
								echo'<td>'.$linie['numarZile'].'</td>';
?>
								<td><input type="submit" name="modifica" value="Modifica" onClick="javascript:return confirm('Modificati datele in baza de date?');">
								&nbsp;&nbsp;<input type="submit" name="sterge" value="Sterge" onClick="javascript:return confirm('Stergeti datele in baza de date?');"></td>
							</tr>
<?php
							echo'<input type="hidden" name="modificaNume" value="'.$linie['nume'].'">';
							echo'<input type="hidden" name="id" value="'.$linie['id'].'">';
						echo'</form>';
					}
				echo'</table><br /><br />';
			}

			if($ok==1){
/*
				$anul0=date("Y");
				$anul1=$anul0-1;
				$anul2=$anul0+1;
*/
				//$anul0=date("Y");
				$anul0 =2023;//PROVIZORIU PENTRU LUNA DECEMBRIE 2022
				$anul1=$anul0-2;
				$anul2=$anul0-1;
				//$an_provizoriu = '2022';//introdus anul 2022 PROVIZORIU

				$sirAni=[$anul1,$anul2,$anul0];
				echo'<table class="tabel">';
					echo'<tr>';
						echo'<th>Concediul aferent anului</th>';
						echo'<th>Numar de zile cuvenite</th>';
						echo'<th>Numar de zile ramase</th>';
						echo'<th>Zile efectuate in '.$sirAni[0].'</th>';
						echo'<th>Zile efectuate in '.$sirAni[1].'</th>';
						echo'<th>Zile efectuate in '.$sirAni[2].'</th>';
					echo'</tr>';
						foreach($sirAni as $an){
							$rez=afisareDetaliata($an,$numePersonalRapoarte);
							$sql="SELECT t1.an,t1.nume,sum(t1.numarZile) as efectuate ,t2.acordate FROM concediu t1 JOIN personal_modificat t2 ON t1.nume=t2.nume WHERE t1.nume=:numePersonalRapoarte AND t1.stare=1 AND t2.anul=:an AND t1.an=:an";
							$sirSql=['numePersonalRapoarte'=>$numePersonalRapoarte,'an'=>$an];
							$stmt=$con->prepare($sql);
							$stmt->execute($sirSql);
							while($linie=$stmt->fetch()){
								if(is_null($linie['nume'])){
									$sqlNul="select acordate from personal_modificat where nume=:numePersonalRapoarte and anul=:an";
									$sirNul=['numePersonalRapoarte'=>$numePersonalRapoarte,'an'=>$an];
									$stmtNul=$con->prepare($sqlNul);
									$stmtNul->execute($sirNul);
									while($linieNul=$stmtNul->fetch()){
										$linie['acordate']=$linieNul['acordate'];
									}
								}
								echo'<tr><td>'.$an.'</td><td>'.$linie['acordate'].'</td><td>'.($linie['acordate']-$linie['efectuate']).'</td>';
								echo'<td>'.$rez[0].'</td><td>'.$rez[1].'</td><td>'.$rez[2].'</td></tr>';
							}
						}
				echo'</table><br /><br />';
				echo'<a href="imprimare.php?nume='.$numePersonalRapoarte.'" target="_blank"><button>Imprimare</button></a>';
			}
		echo'</div>';//inchidem div class col-9 col-s-12
		jos();
	}
	else{
   		header("Location: logare.php");
   }
?>
