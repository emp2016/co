<?php
	/*date personal instante*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		require'functii.php';
		require'constante.php';
		cap();
		meniu();
		echo'<div class="col-9 col-s-12">';
			echo'<ul style="list-style-type:square"><h3>Personal instante:</h3>';
				echo'<li><a href="adauga-personal.php"><h3>Adaugare persoana noua</h3></a></li>';
				echo'<li><a href="modifica-personal.php"><h3>Modificare date personal instante</h3></a></li>';
			echo'</ul>';
		echo'</div>';//end div class col-9 col-s-12
		jos();
	}
	else{
   		header("Location: logare.php");
   }
?>
