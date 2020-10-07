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
		$anul0Functie=date("Y");
		$anul1Functie=$anul0Functie-1;
		$anul2Functie=$anul0Functie+1;
		$sirAniFunctie=[$anul1Functie,$anul0Functie,$anul2Functie];
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
		$begin=strtotime($startDate);
		$end=strtotime($endDate);
		//excludem zilele de sarbatoare
		$ziDeSarbatoare1=strtotime(date('Y-01-01'));//anul nou
		if(($begin<=$ziDeSarbatoare1)&&($ziDeSarbatoare1<=$end)){
			$eliminare1=1;
		}
		else{
			$eliminare1=0;
		}
		$ziDeSarbatoare2=strtotime(date('Y-01-02'));//a doua zi de An Nou
		if(($begin<=$ziDeSarbatoare2)&&($ziDeSarbatoare2<=$end)){
			$eliminare2=1;
		}
		else{
			$eliminare2=0;
		}
		$ziDeSarbatoare3=strtotime(date('Y-01-24'));//Ziua Unirii Principatelor
		if(($begin<=$ziDeSarbatoare3)&&($ziDeSarbatoare3<=$end)){
			$eliminare3=1;
		}
		else{
			$eliminare3=0;
		}
		$ziDeSarbatoare4=strtotime(date('Y-04-17'));//Vinerea Mare
		if(($begin<=$ziDeSarbatoare4)&&($ziDeSarbatoare4<=$end)){
			$eliminare4=1;
		}
		else{
			$eliminare4=0;
		}
		$ziDeSarbatoare5=strtotime(date('Y-04-20'));//A doua zi de Paste
		if(($begin<=$ziDeSarbatoare5)&&($ziDeSarbatoare5<=$end)){
			$eliminare5=1;
		}
		else{
			$eliminare5=0;
		}
		$ziDeSarbatoare6=strtotime(date('Y-05-01'));//1 Mai
		if(($begin<=$ziDeSarbatoare6)&&($ziDeSarbatoare6<=$end)){
			$eliminare6=1;
		}
		else{
			$eliminare6=0;
		}
		$ziDeSarbatoare7=strtotime(date('Y-06-01'));//1 Iunie
		if(($begin<=$ziDeSarbatoare7)&&($ziDeSarbatoare7<=$end)){
			$eliminare7=1;
		}
		else{
			$eliminare7=0;
		}
		$ziDeSarbatoare8=strtotime(date('Y-06-08'));//A doua zi de Rusalii
		if(($begin<=$ziDeSarbatoare8)&&($ziDeSarbatoare8<=$end)){
			$eliminare8=1;
		}
		else{
			$eliminare8=0;
		}
		$ziDeSarbatoare9=strtotime(date('Y-11-30'));//Sfantul Apostol Andrei
		if(($begin<=$ziDeSarbatoare9)&&($ziDeSarbatoare9<=$end)){
			$eliminare9=1;
		}
		else{
			$eliminare9=0;
		}
		$ziDeSarbatoare10=strtotime(date('Y-12-01'));//1 Decembrie
		if(($begin<=$ziDeSarbatoare10)&&($ziDeSarbatoare10<=$end)){
			$eliminare10=1;
		}
		else{
			$eliminare10=0;
		}
		$ziDeSarbatoare11=strtotime(date('Y-12-25'));//Prima zi de craciun
		if(($begin<=$ziDeSarbatoare11)&&($ziDeSarbatoare11<=$end)){
			$eliminare11=1;
		}
		else{
			$eliminare11=0;
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
		  $eliminare=$eliminare1+$eliminare2+$eliminare3+$eliminare4+$eliminare5+$eliminare6+$eliminare7+$eliminare8+$eliminare9+$eliminare10+$eliminare11;
		  $working_days=$no_days-$weekends-$eliminare;
		  return $working_days;
	 	}
	}
?>
