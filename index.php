<?php
    /*pagina de start*/
	if(!isset($_SESSION)){
		session_start();
	}
	if(isset($_SESSION['admin'])){
		require 'functii.php';
		require 'constante.php';
		cap();
		meniu();
		echo'<div class="col-9 col-s-12">';
			echo '<h3>Salut, '.ucfirst($_SESSION['admin']).'.';
		echo'</div>';//sfarsit div col-10 col-s-12
		jos();
		//exit();
	}
	else{
		require 'logare.php';
	}

?>
