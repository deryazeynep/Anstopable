<?php
// GET STUDENT
$curl_student = curl_init("http://46.101.204.215:1337/api/V1/student");
curl_setopt($curl_student, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl_student, CURLOPT_HEADER, false);
curl_setopt($curl_student, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl_student, CURLOPT_RETURNTRANSFER, true);

$student_response = curl_exec($curl_student);
$json_student_response = json_decode($student_response, true);


// GET AVATARLIST
$curl_avatar = curl_init("http://46.101.204.215:1337/api/V1/avatar");
curl_setopt($curl_avatar, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl_avatar, CURLOPT_HEADER, false);
curl_setopt($curl_avatar, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl_avatar, CURLOPT_RETURNTRANSFER, true);

$avatar_response = curl_exec($curl_avatar);
$json_avatar_response = json_decode($avatar_response, true);

$current_avatar = $json_avatar_response[$json_student_response['avatarId']]['avatarBigUrl'];

$avatarlist = '';
foreach($json_avatar_response as $image) {
	$avatarlist .= '<img class="changeimg" id="'.$image['_id'].'" src="'.$image['avatarBigUrl'].'" /> &nbsp;';
}

if(isset($_POST['chancel'])){
	header('location: index.php');
}

if(isset($_POST['change_avatar'])){
	
	$curl_avatar = curl_init("http://46.101.204.215:1337/api/V1/avatar/".$_POST['avatar']);
	curl_setopt($curl_avatar, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($curl_avatar, CURLOPT_HEADER, false);
	curl_setopt($curl_avatar, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl_avatar, CURLOPT_RETURNTRANSFER, true);

	$avatar_response = curl_exec($curl_avatar);
	$json_avatar_response = json_decode($avatar_response, true);

	echo '

			<div class="overlay-box success">
				<div class="close-button">
					<img src="_assets/_img/delete.png" class="close" alt="close-img" />
				</div>
				<img src="_assets/_img/confirmation.png" class="confirmation" alt="close-img" />
				<div class="overlay-text">
					Das Profilbild wurde erfolgreich geändert! <br />
					Lorem ipsum dolar sit amet
				</div>
			</div>		
	
		';
}
?>


<div class="center-block">
	<div class="center-block-inner">
		<img id="avatar" src="<?=$current_avatar?>" class="avatar">
		
		<h1>Profilbild Ändern</h1>
		
		<form method="post" action="">
			<input class="button inactive" type="submit" name="chancel" value="Abbrechen" />
			&nbsp;
			<input class="button" type="submit" name="change_avatar" value="Speichern" />
			
			<input type="hidden" name="avatar" value="" />
		</form>
		
		<br /><br />
		<?=$avatarlist?>
		
	</div>
</div>

<?php exit(); ?>