<?php
    /*pagina de login*/
	require 'functii-logare.php';
	require 'constante-logare.php';
	$flagParola = $flagUtilizator ='';
	$utilizatorEroare='';
	$parolaEroare='';
	$mesajAutentificare='';
	$utilizator=$parola='';
	capLogare();
   echo'<div class="col-9 col-s-12">';
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['admin'])){
      header("Location: index.php");
    }
    else{
		if(isset($_POST['ok'])){
                if(empty($_POST['utilizator'])){
                    $utilizatorEroare = "Numele utilizatorului este obligatoriu.";
                    $flagUtilizator=0;
                }else{
                    $utilizator = testCampLogare($_POST["utilizator"]);
                    $flagUtilizator = 1;
                }
                if(empty($_POST['parola'])){
                    $parolaEroare = 'Parola este obligatorie.';
                    $flagParola = 0;
                }else{
                    //$parola=sha1($_POST['parola']);
                    $parola=$_POST['parola'];
                    $flagParola = 1;
                }
            
            if(($flagUtilizator == 1)&&($flagParola==1)){
                //verificam parola utilizatorului
                try{
                    $dbh = new PDO('mysql:host='.serverLogare.';dbname='.bazadateLogare,userLogare, parolaLogare);
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $dbh->prepare("select * from administrare where nume=:utilizator and parola=:parola");
                    $stmt->bindParam(':utilizator',$utilizator);
                    $stmt->bindParam(':parola',$parola);
                    $stmt->execute();
                    if($stmt->rowCount()<1){
                        $mesajAutentificare='Autentificare esuata. Incercati din nou.';
                    }
                    else{//adaugam metadatele utilizatorului in tablelul concedii.logare
                        $dataLogare=date('Y-m-d H:i:s');
                        if(isset($_SERVER["REMOTE_ADDR"])){
                            $ip = $_SERVER["REMOTE_ADDR"];
                        }
                        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                        }
                        elseif (isset($_SERVER["HTTP_CLIENT_IP"])){
                            $ip = $_SERVER["HTTP_CLIENT_IP"];
                        }
                        else{
                            $ip = 'necunoscut';
                        }
                        $_SESSION['admin'] = $utilizator;
                        $stare = 1;
                        $stmt1 = $dbh->prepare("INSERT INTO logare (utilizator,ip,data_logare,data_iesire,stare) VALUES
                            (:utilizator, :ip, :dataLogare, :dataIesire,:stare)");
                        $stmt1->bindParam(':utilizator', $utilizator);
                        $stmt1->bindParam(':ip', $ip);
                        $stmt1->bindParam(':dataLogare', $dataLogare);
                        $stmt1->bindParam(':dataIesire', $dataLogare);
                        $stmt1->bindParam(':stare', $stare);
                        $stmt1->execute();
                        header("Location: index.php");
                    }

                }
                catch (PDOException $e){
                    echo 'Eroare: '.$e->getMessage();
                }
                $dbh = null;
            }
        }
	}
	echo'<p><span class="eroare">*campuri obligatorii</span></p>';
		echo'<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST">';
			echo'Utilizator: <input type="text" name="utilizator" value="'.$utilizator.'" autofocus>';
			echo'<span class="eroare">*'.$utilizatorEroare.'</span><br><br>';
			echo'Parola: <input type="password" name="parola">';
			echo'<span class="eroare">*'.$parolaEroare.'</span><br><br>';
			echo'<input type="submit" name="ok" value="OK"><br><br>';
			echo '<span class="eroare">'.$mesajAutentificare.'</span>';
		echo'</form>';
	echo'</div>';//sfarsit div col-9 col-s-12
	josLogare();
 ?>
