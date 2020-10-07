<?php
	/*date personal instante*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		$nume=$instanta=$functia=$an=$acordate='';
		$okNume=$okInstanta=$okFunctia=$okAcordate='';
		$numeEroare=$instantaEroare=$functiaEroare=$acordateEroare=$verificareEroare='';
		$sirAni=[date("Y")-1,date("Y")+1];
		require'functii.php';
		require'constante.php';
		$con = new PDO('mysql:host='.server.';dbname='.bazadate, user, parola);
		cap();
		meniu();
		if(isset($_POST['Adauga'])){//am apasat butonul Adauga
			if(empty($_POST['nume'])){
				$numeEroare='Obligatoriu';
			}
			else{
				$nume=$_POST['nume'];
				$okNume = 1;
			}
			if($_POST['instanta']==1){
				$instantaEroare = 'Obligatoriu';
			}
			else{
				$instanta = $_POST['instanta'];
				$okInstanta = 1;
			}
			if(empty($_POST['functia'])){
				$functiaEroare = 'Obligatoriu';
			}
			else{
				$functia = $_POST['functia'];
				$okFunctia = 1;
			}
			if(empty($_POST['acordate'])){
				$acordateEroare = 'Obligatoriu';
			}
			else{
				$acordate = $_POST['acordate'];
				$okAcordate = 1;
			}
		}
		if(($okNume==1)&&($okInstanta==1)&&($okFunctia==1)&&($okAcordate==1)){//introducem datele
			$an = $_POST['an']; 
			//verificam daca exista deja o inregistrare pentru persoana si anul ales
			$sirVerificare = ['numeVerificare'=>$nume,'anul'=>$an];
			$sqlVerificare = "SELECT anul FROM personal_modificat where nume=:numeVerificare and anul=:anul";
			$stmtVerificare = $con->prepare($sqlVerificare);
			$stmtVerificare->execute($sirVerificare);
			$rezultat = $stmtVerificare->rowCount();
			if($rezultat>0){
				$verificareEroare = '<span class="eroare">Exista o inregistrare in baza de date pentru anul ales.<br />Alegeti alt an sau modificati valorile <a href="modifica-personal.php" target="_blank">aici</a></span>';
			}
			else{
$sirAdauga = ['functia'=>$functia,'nume'=>$nume,'acordate'=>$acordate,'anul'=>$an,'instanta'=>$instanta];
				$sql = "INSERT INTO personal_modificat(functia,nume,acordate,anul,instanta,stare) VALUES (:functia,:nume,:acordate,:anul,:instanta,1)";
				$stmt = $con->prepare($sql);
				$stmt->execute($sirAdauga);
			}
		}
		echo'<div class="col-9 col-s-12">';
			echo'<h3>Adaugare persoana noua:</h3>';
			echo'<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="POST">';
				echo'Nume:&nbsp;&nbsp;';
				echo'<input type="text" name="nume" value="'.$nume.'" autofocus>';
				echo'<span class="eroare">*'.$numeEroare.'</span><br /><br />';
				echo'Instanta:&nbsp;&nbsp;';
				echo'<select name="instanta">';
					echo'<option value="1">Alege o instanta</option>';
					//populam option cu valorile din tabelul instante
					$query="SELECT * FROM instante WHERE stare=1";
					$stmt_instante=$con->prepare($query);
					$stmt_instante->execute();
					while($row=$stmt_instante->fetch()){
						echo'<option value="'.$row['instanta'].'"';
							if(isset($instanta)&&($instanta==$row['instanta'])){
								echo'selected';
							}
						echo'>'.$row['instanta'].'</option>';
					}
				echo'</select><span class="eroare">*'.$instantaEroare.'</span><br /><br />';
				echo'Functia:&nbsp;&nbsp';
				echo'<input type="text" name="functia" value="'.$functia.'">';
				echo'<span class="eroare">*'.$functiaEroare.'</span><br /><br />';
				echo'Concediu aferent anului:&nbsp;&nbsp;';
				echo'<select name="an">';
					echo'<option value="'.date("Y").'">'.date("Y").'</option>';
					foreach($sirAni as $key=>$value){
						echo'<option value="'.$value.'"';
							if(isset($an)&&($an==$value)){echo "selected";}
						echo'>'.$value.'</option>';
					}
				echo'</select><br /><br />';
				echo'Numar de zile cuvenite pentru anul ales:&nbsp;&nbsp';
				echo'<input type="number" min="0" max="35" name="acordate" value="'.$acordate.'">';
				echo'<span class="eroare">*'.$acordateEroare.'</span><br /><br />';
?>
				<input type="submit" name="Adauga" value="OK" onClick="javascript:return confirm('Adaugati persoana in baza de date?');">
<?php
			echo'</form>';
			echo $verificareEroare;
		echo'</div>';//end div class col-9 col-s-12
		jos();
	}
	else{
   		header("Location: logare.php");
   }
?>
