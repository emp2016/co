<?php
    if(!isset($_SESSION)){
        session_start();
    }
    require'functii.php';
    require 'constante.php';
	$observatii=$nume=$dataInceput=$dataSfarsit=$mesaj=$inceput1=$anAles=$numeIntroCurent='';
	$okAnAles=$okNume=$okDataInceput=$okDataSfarsit=$dataComparare='';
	$numePersonalEroare=$dataInceputEroare=$dataSfarsitEroare=$dataComparareEroare=$verificareEroare='';
	$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
    if(isset($_SESSION['admin'])){
        cap();
        meniu();
			if(isset($_POST['ok'])){//am apasat butonul ok
				if($_POST['anAles']==0){
					$anAlesEroare = 'Obligatoriu';
				}
				else{
					$anAles = $_POST['anAles'];
					$okAnAles =1;
				}
				if($_POST['numePersonal']=='Alegeti o persoana'){
					$numePersonalEroare="Obligatoriu.";
				}
				else{
					$nume=$_POST['numePersonal'];
					$okNume=1;
					$numeIntroCurent=$_POST['numePersonal'];
				}
				if(empty($_POST['dataInceput'])){
					$dataInceputEroare = 'Obligatoriu';
				}
				else{
					$dataInceput=$_POST['dataInceput'];
					//verificam daca nu a mai fost introdusa aceasta data
					$sirVerificare=['dataInceput'=>$dataInceput,'nume'=>$nume];
					$sqlVerificare="select * from concediu where dataInceput=:dataInceput and nume=:nume and stare=1";
					$stmtVerificare=$con->prepare($sqlVerificare);
					$stmtVerificare->execute($sirVerificare);
					if(($stmtVerificare->rowCount())>0){
						$verificareEroare="Perioada exista in baza de date.";
					}
					else{
						$okDataInceput=1;
					}
				}
				if(empty($_POST['dataSfarsit'])){
					$dataSfarsitEroare='Obligatoriu';
				}
				else{
					$dataSfarsit=$_POST['dataSfarsit'];
					$okDataSfarsit=1;
				}
				if(empty($_POST['observatii'])){
					$observatii='';
				}
				else{
					$observatii=$_POST['observatii'];
				}
				if($dataInceput>$dataSfarsit){
					$dataComparareEroare='Data inceput trebuie sa fie mai mica sau egala cu data sfarsit.';
				}
				else{
					$dataComparare=1;
				}
				if(($okAnAles==1)&&($okNume==1)&&($okDataInceput==1)&&($okDataSfarsit==1)&&($dataComparare==1)){//introducem datele in baza de date, tabelul concediu
					/*
					$dataInceputZile = new DateTime($dataInceput);
					$dataSfarsitZile = new DateTime($dataSfarsit);
					$numar=$dataInceputZile->diff($dataSfarsitZile);
					$numarZile1=$numar->format('%a');
					$numarZile=$numarZile1+1;
					*/
					$dataInceputZile=date('Y-m-d',strtotime($dataInceput));
					$dataSfarsitZile=date('Y-m-d',strtotime($dataSfarsit));
					$numarZile=aflaZileLucratoare($dataInceputZile,$dataSfarsitZile);					
					/*if($dataInceputZile==$dataSfarsitZile){
						$numarZile=aflaZileLucratoare($dataInceputZile,$dataSfarsitZile);
					}
					else{
						$numarZile=aflaZileLucratoare($dataInceputZile,$dataSfarsitZile)+1;
					}*/
					$stare = 1;
					$data = ['nume'=>$nume,'dataInceput'=>$dataInceput,'dataSfarsit'=>$dataSfarsit,'an'=>$anAles,'numarZile'=>$numarZile, 'observatii'=>$observatii, 'stare'=>$stare,];
					$sql = "INSERT INTO concediu(nume, dataInceput, dataSfarsit,an, numarZile, observatii, stare) VALUES (:nume,:dataInceput, :dataSfarsit,:an, :numarZile, :observatii, :stare)";
					$stmt = $con->prepare($sql);
					$stmt->execute($data);
					header("Location: rapoarte.php?numePersonal=$numeIntroCurent");
				}
				//header("Location: rapoarte.php?numePersonal=$numeIntroCurent");
			}
			
        echo'<div class="col-9 col-s-12">';
				echo'<a href="./introducere-date.php"><h3>Introducere date:</h3></a>';
           echo'<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST">';
				echo'Nume: ';
				echo'<select name="numePersonal">';
					echo'<option value="Alegeti o persoana">Alegeti o persoana</option>';
					//populam option cu valorile din baza de date
					$query = "SELECT DISTINCT (nume) FROM personal_modificat WHERE stare=1 ORDER BY nume ASC";
					$stmtPersonal = $con->prepare($query);
					$stmtPersonal->execute();
					while($row=$stmtPersonal->fetch()){
						echo'<option value="'.$row['nume'].'"';
						if(isset($nume)&&($nume==$row['nume'])){
							echo'selected';
						}
						echo'>'.$row['nume'].'</option>';
					}
				echo'</select><span class="eroare">*'.$numePersonalEroare.'</span><br><br>';
				echo'Concediu aferent anului:';
				echo'<select name="anAles">';
					echo'<option value="0">...</option>';

					$an0=date("Y");
					$an1=$an0-2;
					$an2=$an0-1;
					$sirAnAles=array($an1,$an2,$an0);
/*
					$an0=date("Y");
					$an1=$an0-1;
					$an2=$an0-2;
					$an_provizoriu = '2022';//introdus anul 2022 PROVIZORIU

					$sirAnAles=array($an1,$an0,$an_provizoriu);
*/
					foreach($sirAnAles as $key=>$value){
						echo'<option value="'.$value.'"';
						if(isset($anAles)&&($anAles==$value)){
							echo 'selected';
						}
						echo'>'.$value.'</option>';
					}
				echo'</select><span class="eroare">*'.$anAlesEroare.'</span><br /><br />';
				echo'Perioada concediu de odihna: ';
				echo'<input type="date" name="dataInceput" value="'.$dataInceput.'"><span class="eroare">*'.$dataInceputEroare.'</span>';
				echo'&nbsp;&nbsp;-&nbsp;&nbsp;<input type="date" name="dataSfarsit" value="'.$dataSfarsit.'"><span class="eroare">*'.$dataSfarsitEroare.'</span>';
				echo'<span class="eroare">'.$dataComparareEroare.'</span><span class="eroare">'.$verificareEroare.'</span><br><br>';
				echo'Observatii: <textarea name="observatii" rows="4" cols="30" style="vertical-align: top;">'.$observatii.'</textarea><br><br>';
				echo'<input type="hidden" name="numeIntroCurent" value="'.$numeIntroCurent.'">';
?>
					<input type="submit" name="ok" value="OK" onClick="javascript:return confirm('Adaugati datele in baza de date?');">
<?php
            echo'</form><br><br>';
        echo'</div>';//sfarsit div col-9 col-s-12
        jos();
        //exit();
    }
    else{
        header("Location: logare.php");
    }
 ?>
