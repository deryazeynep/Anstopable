<?php
if(isset($_POST['change_pass'])){
	
	if($_POST['old_pass'] != '⁠⁠⁠M111K'){
		
		if($_POST['new_pass'] == $_POST['new_pass_again']){
			
			$curl = curl_init("http://46.101.204.215:1337/api/V1/requestPasswordRecovery");
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($curl);
			$json_response = json_decode($response, true);
			
			if(array_key_exists('token', $json_response)){
			
				echo '

						<div class="overlay-box success">
							<div class="close-button">
								<img src="_assets/_img/delete.png" class="close" alt="close-img" />
							</div>
							<img src="_assets/_img/confirmation.png" class="confirmation" alt="close-img" />
							<div class="overlay-text">
								Das Passwort wurde erfolgreich geändert! <br />
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
						<img src="_assets/_img/warning.png" class="confirmation" alt="close-img" />
						<div class="overlay-text">
							Fehler beim Aufruf der API <br />
							Lorem ipsum dolar sit amet
						</div>
					</div>		
			
				 ';	
			}
		
		} else {
			
			echo '

					<div class="overlay-box warning">
						<div class="close-button">
							<img src="_assets/_img/delete.png" class="close" alt="close-img" />
						</div>
						<img src="_assets/_img/warning.png" class="confirmation" alt="close-img" />
						<div class="overlay-text">
							Die Passwörter stimmen nicht überein! <br />
							Lorem ipsum dolar sit amet
						</div>
					</div>		
			
				 ';
		}
		
		
	} else {
			
			echo '

					<div class="overlay-box warning">
						<div class="close-button">
							<img src="_assets/_img/delete.png" class="close" alt="close-img" />
						</div>
						<img src="_assets/_img/warning.png" class="confirmation" alt="close-img" />
						<div class="overlay-text">
							Das alte Passwort ist falsch! <br />
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
			<img src="_assets/_img/change-password.png" class="change-pass" />
			
			<h1>Passwort Ändern</h1>

			<form method="post">
				<div class="form-group">
					<label>Altes Passwort*</label>
					<input type="password" name="old_pass" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Neues Passwort*</label>
					<input type="password" name="new_pass" class="form-control" required />
				</div>
				<div class="form-group">
					<label>Passwort Bestätigung*</label>
					<input type="password" name="new_pass_again" class="form-control" required />
				</div>
				<br />
				<input type="submit" class="button" name="change_pass" value="Ändern" />
			</form>
			

			
		</div>
	</div>
</div>
<?php exit(); ?>