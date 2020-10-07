<?php
	/*actiunea din pagina modifica-personal.php*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		require'functii.php';
		require'constante.php';
		$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
		if(isset($_POST['modifica'])){//modificam date personal
			$nume=$_POST['nume4'];
			$instanta=$_POST['instanta1'];
			$functia=$_POST['functia'];
			$anPrecedent=$_POST['anPrecedent'];
			$anCurent=$_POST['anCurent'];
			$anUrmator=$_POST['anUrmator'];
			$zilePrecedent=$_POST['zilePrecedent'];
			$zileCurent=$_POST['zileCurent'];			
			$zileUrmator=$_POST['zileUrmator'];
			//facem modificarile
			$sirPrecedent=['instanta'=>$instanta,'functia'=>$functia,'zilePrecedent'=>$zilePrecedent, 'anPrecedent'=>$anPrecedent, 'nume'=>$nume];
			$sqlPrecedent="UPDATE personal_modificat SET instanta=:instanta,functia=:functia,  acordate=:zilePrecedent WHERE anul=:anPrecedent AND nume=:nume";
			$stmtPrecedent=$con->prepare($sqlPrecedent);
			$stmtPrecedent->execute($sirPrecedent);
			$sirCurent=['instanta'=>$instanta,'functia'=>$functia,'zileCurent'=>$zileCurent, 'anCurent'=>$anCurent, 'nume'=>$nume];
			$sqlCurent="UPDATE personal_modificat SET instanta=:instanta,functia=:functia,  acordate=:zileCurent WHERE anul=:anCurent AND nume=:nume";
			$stmtCurent=$con->prepare($sqlCurent);
			$stmtCurent->execute($sirCurent);
			$sirUrmator=['instanta'=>$instanta,'functia'=>$functia,'zileUrmator'=>$zileUrmator, 'anUrmator'=>$anUrmator, 'nume'=>$nume];
			$sqlUrmator="UPDATE personal_modificat SET instanta=:instanta,functia=:functia,  acordate=:zileUrmator WHERE anul=:anUrmator AND nume=:nume";
			$stmtUrmator=$con->prepare($sqlUrmator);
			$stmtUrmator->execute($sirUrmator);
			header("Location: modifica-personal.php?npm=$nume");//npm=numePersonalModifica
		}
		if(isset($_POST['sterge'])){
			$nume=$_POST['nume4'];
			$sirSterge=['numeSterge'=>$nume];
			$sqlSterge="UPDATE personal_modificat SET stare=0 WHERE nume=:numeSterge";
			$stmtSterge=$con->prepare($sqlSterge);
			$stmtSterge->execute($sirSterge);
			header("Location: modifica-personal.php");
		}
	}
	else{
   		header("Location: logare.php");
   }
	
?>
