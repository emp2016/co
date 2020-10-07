<?php
	/*introducem date personalului*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		require'constante.php';
		require'functii.php';
		cap();
		meniu();
		echo'<div class="col-9 col-s-12">';
			echo'Salutare';
		echo'</div>';//inchidem div class col-9 col-s-12
		jos();
	}
	else{
		header("Location: logare.php");
	}
?>
