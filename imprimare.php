<?php
	/*imprimare raport*/
	if(!isset($_SESSION)){
		session_start();
	}
	$numePersonalRapoarte=$stmtPersonal=$ok=$okNumePersonal='';

	if(isset($_SESSION['admin'])){
		require'functii.php';
		require'constante.php';
		$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
		if(isset($_GET['nume'])){
			$numePersonalRapoarte=$_GET['nume'];
			$ok=1;
			$okNumePersonal=1;
		}

		if($okNumePersonal==1){
			$sql = "select * from concediu where nume=:numePersonalRapoarte and stare=1 order by an desc";
			$sir=['numePersonalRapoarte'=>$numePersonalRapoarte];
			$stmtPersonal=$con->prepare($sql);
			$stmtPersonal->execute($sir);
			$ok=1;
		}
?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Aplicatie - management concedii de odihna</title>
				<link rel="stylesheet" type="text/css" href="formatare-raport.css" />
			</head>
			<body>
				<div>
					<p>TRIBUNALUL SALAJ<br>
						<span>
<?php 
						echo'Data raportului: '.date("d-m-Y").'<br />';
						echo'Nume: '.$numePersonalRapoarte;
?>
						</span>
					</p>
				</div><!--sfarsit div cap-->
				<div><!--inceput continut-->
<?php
		
		echo'<div>';
			if(isset($stmtPersonal)&&($stmtPersonal!=='')&&($stmtPersonal->rowCount()>0)){
				echo'<table class="tabel">';
					echo'<tr><th>Concediu aferent anului</th><th>Data inceput</th><th>Data sfarsit</th><th>Numar zile</th></tr>';
					while($linie=$stmtPersonal->fetch()){
						
						echo'<tr>';
							echo'<td>'.$linie['an'].'</td>';
							echo'<td>'.date("d-m-Y", strtotime($linie['dataInceput'])).'</td>';
							echo'<td>'.date("d-m-Y", strtotime($linie['dataSfarsit'])).'</td>';
							echo'<td>'.$linie['numarZile'].'</td>';
						echo'</tr>';
					}
				echo'</table><br /><br />';
			}

			if($ok==1){
/*
				$anul0=date("Y");
				$anul1=$anul0-1;
				$anul2=$anul0+1;

				$anul0=date("Y");
				$anul1=$anul0-1;
				$anul2=$anul0-2;
				$sirAni=[$anul2,$anul1,$anul0];
*/
				//$anul0=date("Y");
				$anul0 = "2023";//introdus anul 2023 PROVIZORIU
				$anul1=$anul0-1;
				$anul2=$anul0-2;

				$sirAni=[$anul2,$anul1,$anul0];

				echo'<table class="tabel">';
					echo'<tr>';
						echo'<th>Concediul aferent anului</th>';
						echo'<th>Numar de zile cuvenite</th>';
						echo'<th>Numar de zile ramase</th>';
						echo'<th>Zile efectuate in '.$sirAni[0].'</th>';
						echo'<th>Zile efectuate in '.$sirAni[1].'</th>';
						echo'<th>Zile efectuate in '.$sirAni[2].'</th>';
					echo'</tr>';
//exceptii////////////////////////////////////////////////////
				
/////////////////////////////////////////////////////////////
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
			}
				echo'</div>';//inchidem div class col-9 col-s-12
			echo'</div>';//sfarsit div linie (continut)
		echo'</body>';
	echo'</html>';
	}
	else{
		header("Location: index.php");
	}
?>
