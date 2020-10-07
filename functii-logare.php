<?php
	/*functii pentru logare in aplicatia co*/
	function capLogare(){
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

	function josLogare(){
				echo'</div>';//sfarsit div linie (continut)
				//echo'<div class="jos">';
					//echo'<p>Tribunalul Salaj<br>'.date('Y').'</p>';
				//echo'</div>';//sfarsit div jos
			echo'</body>';
		echo'</html>';
	}
	function testCampLogare($camp){
		$camp = trim($camp);
		$camp =stripslashes($camp);
		$camp = htmlspecialchars($camp);
		return $camp;
	}
?>
