<?php
	/*functii pentru aplicatia co*/
	function cap(){
?>
		<!DOCTYPE html>
		<html>
			<head>
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Aplicatie - management concedii de odihna</title>
				<link rel="stylesheet" type="text/css" href="formatare.css" />
			</head>
			<body>
				<div class="cap">
					<a href="index.php"><p>TRIBUNALUL SALAJ<br>
						<span style="color:blue"><?php echo date("d-m-Y");?></span></p>
					</a>
				</div><!--sfarsit div cap-->
				<div class="linie"><!--inceput continut-->
<?php
	}
	function meniu(){
		echo'<div class="col-3 col-s-3 meniu">';
			echo'<ul>';
				echo'<li><a href="./personal-instante.php">Personal instante</a></li>';
				echo'<li><a href="./introducere-date.php">Introducere date</a></li>';
				//echo'<li><a href="./introducere-date-an-precedent.php">Introducere date an precedent</a></li>';
				//echo'<li><a href="./personal.php">Personal</a></li>';
				echo'<li><a href="./rapoarte.php">Rapoarte</a></li>';
				//echo'<li><a href="raport-detaliat.php">Raport detaliat</a></li>';
				echo'<li><a href="logout.php">Iesire</a></li>';
			echo'</ul>';
		echo'</div>';//sfarsit div col-3, col-s-3 si meniu
	}
	function jos(){
				echo'</div>';//sfarsit div linie (continut)
				//echo'<div class="jos">';
					//echo'<p>Tribunalul Salaj<br>'.date('Y').'</p>';
				//echo'</div>';//sfarsit div jos
			echo'</body>';
		echo'</html>';
	}
	function testCamp($camp){
		$camp = trim($camp);
		$camp =stripslashes($camp);
		$camp = htmlspecialchars($camp);
		return $camp;
	}
	function afisareDetaliata($afc,$nume){
/*
		$anul0Functie=date("Y");
		$anul1Functie=$anul0Functie-1;
		$anul2Functie=$anul0Functie+1;
		$sirAniFunctie=[$anul1Functie,$anul0Functie,$anul2Functie];
*/
		$anul0Functie=date("Y");
		$anul1Functie=$anul0Functie-2;
		$anul2Functie=$anul0Functie-1;
		$sirAniFunctie=[$anul1Functie,$anul2Functie,$anul0Functie];
		$con=new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);

		$sqlPrimulAn="select year(dataSfarsit) as anulEfectuarii,sum(numarZile) as efectuate,an from concediu where nume=:nume and stare=1 and an=:afc and YEAR(dataSfarsit)=:primulAn";
		$sirPrimulAn=['nume'=>$nume,'afc'=>$afc,'primulAn'=>$sirAniFunctie[0]];
		$stmtPrimulAn=$con->prepare($sqlPrimulAn);
		$stmtPrimulAn->execute($sirPrimulAn);
		$rowPrimulAn=$stmtPrimulAn->fetch();
		$efectuate1=$rowPrimulAn['efectuate'];
		
		$sqlAlDoileaAn="select year(dataSfarsit) as anulEfectuarii,sum(numarZile)as efectuate,an from concediu where nume=:nume and stare=1 and an=:afc and YEAR(dataSfarsit)=:alDoileaAn";
		$sirAlDoileaAn=['nume'=>$nume,'afc'=>$afc,'alDoileaAn'=>$sirAniFunctie[1]];
		$stmtAlDoileaAn=$con->prepare($sqlAlDoileaAn);
		$stmtAlDoileaAn->execute($sirAlDoileaAn);
		$rowAlDoileaAn=$stmtAlDoileaAn->fetch();
		$efectuate2=$rowAlDoileaAn['efectuate'];

		$sqlAlTreileaAn="select year(dataSfarsit) as anulEfectuarii,sum(numarZile) as efectuate,an from concediu where nume=:nume and stare=1 and an=:afc and YEAR(dataSfarsit)=:alTreileaAn";
		$sirAlTreileaAn=['nume'=>$nume,'afc'=>$afc,'alTreileaAn'=>$sirAniFunctie['2']];
		$stmtAlTreileaAn=$con->prepare($sqlAlTreileaAn);
		$stmtAlTreileaAn->execute($sirAlTreileaAn);
		$rowAlTreileaAn=$stmtAlTreileaAn->fetch();
		$efectuate3=$rowAlTreileaAn['efectuate'];

		return [$efectuate1,$efectuate2,$efectuate3];
	}
	
	function aflaZileLucratoare($startDate, $endDate){
		date_default_timezone_set('UTC');/*setam default time zone la UTC pentru numarul exact de zile, nu am probleme in octombrie cu schimarea orei*/
		$begin=strtotime($startDate);
		$end=strtotime($endDate);
		//excludem zilele de sarbatoare
/*
		//pentru anul 2020
		$ziDeSarbatoare1=strtotime(date('2020-12-25'));//Craciun 2020
		if(($begin<=$ziDeSarbatoare1)&&($ziDeSarbatoare1<=$end)){
			$eliminare2020=1;
		}
		else{
			$eliminare2020=0;
		}
*/

		$ziDeSarbatoareAN=strtotime(date('Y-01-01'));//anul nou(AN)
		if(($begin<=$ziDeSarbatoareAN)&&($ziDeSarbatoareAN<=$end)){
			$eliminareAN=1;
		}
		else{
			$eliminareAN=0;
		}

		$ziDeSarbatoareAN2=strtotime(date('Y-01-02'));//a doua zi de An Nou(AN2)
		if(($begin<=$ziDeSarbatoareAN2)&&($ziDeSarbatoareAN2<=$end)){
			$eliminareAN2=1;
		}
		else{
			$eliminareAN2=0;
		}

		$ziDeSarbatoareZUP=strtotime(date('Y-01-24'));//Ziua Unirii Principatelor(ZUP)
		if(($begin<=$ziDeSarbatoareZUP)&&($ziDeSarbatoareZUP<=$end)){
			$eliminareZUP=1;
		}
		else{
			$eliminareZUP=0;
		}

		$ziDeSarbatoareVM=strtotime(date('Y-04-22'));//Vinerea Mare(VM)
		if(($begin<=$ziDeSarbatoareVM)&&($ziDeSarbatoareVM<=$end)){
			$eliminareVM=1;
		}
		else{
			$eliminareVM=0;
		}
		$ziDeSarbatoareA2P=strtotime(date('Y-04-25'));//A doua zi de Paste(A2P)
		if(($begin<=$ziDeSarbatoareA2P)&&($ziDeSarbatoareA2P<=$end)){
			$eliminareA2P=1;
		}
		else{
			$eliminareA2P=0;
		}
/*
		$ziDeSarbatoare6=strtotime(date('Y-05-01'));//1 Mai
		if(($begin<=$ziDeSarbatoare6)&&($ziDeSarbatoare6<=$end)){
			$eliminare6=1;
		}
		else{
			$eliminare6=0;
		}
*/
		$ziDeSarbatoare1I=strtotime(date('Y-06-01'));//1 Iunie(1I)
		if(($begin<=$ziDeSarbatoare1I)&&($ziDeSarbatoare1I<=$end)){
			$eliminare1I=1;
		}
		else{
			$eliminare1I=0;
		}
		$ziDeSarbatoareA2R=strtotime(date('Y-06-13'));//A doua zi de Rusalii(A2R)
		if(($begin<=$ziDeSarbatoareA2R)&&($ziDeSarbatoareA2R<=$end)){
			$eliminareA2R=1;
		}
		else{
			$eliminareA2R=0;
		}
		$ziDeSarbatoareSM=strtotime(date('Y-08-15'));//Sfanta Marie(SM)
		if(($begin<=$ziDeSarbatoareSM)&&($ziDeSarbatoareSM<=$end)){
			$eliminareSM=1;
		}
		else{
			$eliminareSM = 0;
		}
		$ziDeSarbatoareSAA=strtotime(date('Y-11-30'));//Sfantul Apostol Andrei(SAA)
		if(($begin<=$ziDeSarbatoareSAA)&&($ziDeSarbatoareSAA<=$end)){
			$eliminareSAA=1;
		}
		else{
			$eliminareSAA=0;
		}
		$ziDeSarbatoare1D=strtotime(date('Y-12-01'));//1 Decembrie(1D)
		if(($begin<=$ziDeSarbatoare1D)&&($ziDeSarbatoare1D<=$end)){
			$eliminare1D=1;
		}
		else{
			$eliminare1D=0;
		}
		$ziDeSarbatoare1C=strtotime(date('Y-12-25'));//Prima zi de craciun(1C)
		if(($begin<=$ziDeSarbatoare1C)&&($ziDeSarbatoare1C<=$end)){
			$eliminare1C=1;
		}
		else{
			$eliminare1C=0;
		}
		$ziDeSarbatoare2C=strtotime(date('Y-12-26'));//A doua zi de craciun(2C)
		if(($begin<=$ziDeSarbatoare2C)&&($ziDeSarbatoare2C<=$end)){
			$eliminare2C=1;
		}
		else{
			$eliminare2C=0;
		}
		//			
		if($begin>$end){
		  echo 'startdate is in the future! <br />';
		  return 0;
	 	}else{
		   $no_days=0;
		   $weekends=0;
		   while($begin<=$end){
				$no_days++; // numarul de zile din intervalul ales
				$what_day=date("N",$begin);
				 if($what_day>5) { // 6 si 7 sunt zile de weekend
					  $weekends++;
				 };
				$begin+=86400; // adaugam 1 zi
		  }
		  $eliminare=$eliminareAN+$eliminareAN2+$eliminareZUP+$eliminareVM+$eliminareA2P+$eliminare1I+$eliminareA2R+$eliminareSM+$eliminareSAA+$eliminare1D+$eliminare1C+$eliminare2C;
		  $working_days=$no_days-$weekends-$eliminare;
		  return $working_days;
	 	}
	}
?>
