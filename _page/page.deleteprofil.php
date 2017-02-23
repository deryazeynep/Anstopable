<?php
if(isset($_POST['delete_profile'])){
		
	if($_POST['pass'] == '⁠⁠⁠M111K'){
				
		$curl = curl_init("http://46.101.204.215:1337/api/V1/student");
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($curl);
		$json_response = json_decode($response, true);
				
		echo '

				<div class="overlay-box success">
					<div class="close-button">
						<img src="_assets/_img/delete.png" class="close" alt="close-img" />
					</div>
					<img src="_assets/_img/confirmation.png" class="confirmation" alt="close-img" />
					<div class="overlay-text">
						Dein Profil wurde erfolgreich gelöscht! <br />
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
					<img src="_assets/_img/confirmation.png" class="confirmation" alt="close-img" />
					<div class="overlay-text">
						Das angegebene Passwort stimmt nicht! <br />
						Lorem ipsum dolar sit amet
					</div>
				</div>		
		
			 ';
	}
}
		
?>

<div class="container">
	<div class="center-block">
		<div class="center-block-inner">
			<img src="_assets/_img/delete-profile.png" class="delete-profil" />
			
			<h1>Profil Löschen</h1>

			<form method="post">
				<div class="form-group">
					<label>Passwort*</label>
					<input type="password" name="pass" class="form-control" required />
				</div>
				<br />
				<input type="submit" class="button" name="delete_profile" value="Löschen" />
			</form>
			
		</div>
	</div>
</div>

<?php exit(); ?>