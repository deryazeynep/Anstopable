<?php
if(isset($_POST['login'])){	
	
	// SET ARRAY
	$arr = array("username"=>$_POST['username'], "password" => $_POST['password']);	
	
	// PUT ARRAY INTO JSON OBJECT
	$json_object = json_encode($arr);

	// GET API WITH CURL
	$curl = curl_init("http://46.101.204.215:1337/api/V1/login");
	
	// SET CURL OPTIONS
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json_object);
	
	// GET THE CURL RESPONSE
	$response = curl_exec($curl);

	// DECODE JSON DATA INTO ARRAY
	$json_response = json_decode($response, true);
	
	// CHECK IF TOKEN GIVEN
	if(array_key_exists('token', $json_response)){
		
		// SET SESSIONS
		$_SESSION['logged_in'] = 'loged_in';
		$_SESSION['token'] = $json_response['token'];
		
		echo '

				<div class="overlay-box success">
					<div class="close-button">
						<img src="_assets/_img/delete.png" class="close" alt="close-img" />
					</div>
					<img src="_assets/_img/confirmation.png" class="confirmation" alt="close-img" />
					<div class="overlay-text">
						<a href="/">Weiter auf die Startseite</a><br />
						Lorem ipsum dolar sit amet
					</div>
				</div>		
		
			 ';		
	
	} else {
		
		echo '
		
			<div class="overlay-box warning">
				<div class="close-button">
					<img src="_assets/_img/delete.png" class="close" alt="close-img" />
				</div>
				<img src="_assets/_img/warning.png" class="warning" alt="close-img" />
				<div class="overlay-text">
					invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accu- sam et justo duo dolores et ea rebum.
				</div>
			</div>
	
		';		
	}	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Check!</title>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

		<!-- Style -->
		<link rel="stylesheet" href="_assets/_css/core.css" media="screen" >

		<!-- Scripts -->
		<script src="/_assets/_js/core.js"></script>
	</head>
	
	<body class="site login">

		<div class="center-block">
			<img src="_assets/_img/login/header.png" alt="head_pic"/><br>
			
			<form method="post" action="">

				<input type="text" placeholder="BENUTZERNAME" name="username" class="form-control" /><br />
				<input type="password" placeholder="PASSWORT" name="password" class="form-control" id="LoginInputPassword" />
				<div class="password_text">Aus Sicherheitsgründen muss das Passwort mindestens 7-stellig sein sowie einen Großbuchstaben, eine Ziffer und ein Sonderzeichen enthalten</div><br /><br />
				<input type="submit" class="button" name="login" value="LOS!" />
				<div class="reg-text">
					Sie möchten mit CHECK! arbeiten? <br/> <a href="#">Jetzt registrieren</a>.
				</div>
			</form>
		</div>
		
		<footer>
			<img src="_assets/_img/login/footer.png"><br />
			<span class="darktext">edition 2016 dark night blue 1.0</span><br /><br />
			<small>
			CHECK! und CHECK! Lehrerzimmer sind Produkte des Raup&Ritter Verlag und der OnWerk Softwareagentur Mannheim <br /> www.raupundritter.com - Kontakt - Impressum - Preise - Hilfe
			</small>
		</footer>
	</body>
</html>