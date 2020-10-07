<?php
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		require 'constante.php';
		require 'functii.php';
		$modificaAn=$modificaInceput=$modificaSfarsit=$modificaNume=$id='';
		$numarZile=$numarZile1='';
		if(isset($_POST['modifica'])){//modificam
			$modificaAn=$_POST['modificaAn'];
			$modificaInceput = new DateTime($_POST['modificaInceput']);
			$modificaInceput1= $modificaInceput->format('Y-m-d');
			$modificaSfarsit = new DateTime($_POST['modificaSfarsit']);
			$modificaSfarsit1= $modificaSfarsit->format('Y-m-d');
			$modificaNume=$_POST['modificaNume'];
			$id=$_POST['id'];
			if($modificaInceput>$modificaSfarsit){
				$modifica=sha1(0);
			}
			else{
				$modifica=sha1(1);
				/*if($modificaInceput1==$modificaSfarsit1){
					$numarZile=aflaZileLucratoare($modificaInceput1,$modificaSfarsit1);
				}
				else{
					$numarZile=aflaZileLucratoare($modificaInceput1,$modificaSfarsit1)+1;
				}*/
				$numarZile=aflaZileLucratoare($modificaInceput1,$modificaSfarsit1);
				$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
				$sql = "UPDATE concediu SET an=:modificaAn,dataInceput=:modificaInceput,dataSfarsit=:modificaSfarsit,numarZile=:numarZile WHERE id=:id";
				$sirSql=['modificaAn'=>$modificaAn, 'modificaInceput'=>$modificaInceput1, 'modificaSfarsit'=>$modificaSfarsit1, 'numarZile'=>$numarZile, 'id'=>$id];
				$stmt=$con->prepare($sql);
				$stmt->execute($sirSql);
			}
		}
		if(isset($_POST['sterge'])){//stergem
			$id=$_POST['id'];	
			$modificaNume=$_POST['modificaNume'];
			$modifica=sha1(1);
			$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
			$sqlSterge="UPDATE concediu SET stare=0 WHERE id=:id";
			$sirSterge = ['id'=>$id];
			$stmtSterge = $con->prepare($sqlSterge);
			$stmtSterge->execute($sirSterge);
		}
		header("Location: rapoarte.php?nms=$modificaNume&modifica=$modifica");
	}
   else{
   	header("Location: logare.php");
   }
 ?>
