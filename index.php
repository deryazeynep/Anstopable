<?php
// START OUTPUT
ob_start();

// START SESSION
session_start();

// LOGOUT
if(isset($_GET['logout'])){
	session_destroy();
	header('location: index.php');
}

if(!isset($_SESSION['logged_in'])){
	include('_page/page.login.php');
	exit();
}

// STANDART VARIABLE
$response = (isset($_GET['response']) ? $_GET['response'] : 'chapter');
$action = (isset($_GET['action']) ? $_GET['action'] : '1');

// SET HEADERS
$headers = array(
	'Content-Type: application/json',
	'Authorization: '.$_SESSION['token']
);

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

// GET CHAPTERLIST
$curl_chapter = curl_init("http://46.101.204.215:1337/api/V1/chapter");
curl_setopt($curl_chapter, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl_chapter, CURLOPT_HEADER, false);
curl_setopt($curl_chapter, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl_chapter, CURLOPT_RETURNTRANSFER, true);

$chapter_response = curl_exec($curl_chapter);
$json_chapter_response = json_decode($chapter_response, true);


$chapterlist = '';
$chaptercompletedlist = '';
foreach($json_chapter_response as $chapter){
	$chapterlist .= '<li><a href="index.php?action='.$chapter['_id'].'&response=chapter" style="background-color: '.$chapter['strongcolor'].'" onmouseover="this.style.backgroundColor=\''.$chapter['weakcolor'].'\'" onmouseout="this.style.backgroundColor=\''.$chapter['strongcolor'].'\'">'.$chapter['name'].'</a></li>';
	$chaptercompletedlist .= '<li><a href="index.php?action='.$chapter['_id'].'&response=chapter_completed" style="background-color: '.$chapter['strongcolor'].'" onmouseover="this.style.backgroundColor=\''.$chapter['weakcolor'].'\'" onmouseout="this.style.backgroundColor=\''.$chapter['strongcolor'].'\'">'.$chapter['name'].'</a></li>';
}

// GET EDUCATION LIST
$curl_education = curl_init("http://46.101.204.215:1337/api/V1/educationalPlan");
curl_setopt($curl_education, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($curl_education, CURLOPT_HEADER, false);
curl_setopt($curl_education, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl_education, CURLOPT_RETURNTRANSFER, true);

$education_response = curl_exec($curl_education);
$json_education_response = json_decode($education_response, true);

$educationlist = '';
foreach($json_education_response as $education){
	$educationlist .= '<li><a href="index.php?action='.$education['_id'].'&response=education">'.$education['name'].'</a></li>';
}

if($action != 'show_all_completed'){
	
	if($response == 'chapter' OR $response == 'chapter_completed'){
		$background_color = $json_chapter_response[$action-1]['weakcolor'];
	} else {
		$background_color = '#4565AD';
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
	
	<body class="site">
		<div class="navbar container">
			
			<div class="logo"><img src="/_assets/_img/logo.png"></div>
			
			<!-- NAVBAR LEFT -->
			<ul class="nav-left nav">
				<li id="chapter">
					<ul>
						<div class="dropdown-header">
							<img src="_assets/_img/confirmation.png">
							<p>CHECK! <br />KOMPETENZLISTE</p>
						</div>
						<div class="clearfix"><br /></div>
						<div class="overflow" style="">
							<div class="overflow-inner">
								<?=$chapterlist?>
							</div>
						</div>
					</ul>
				</li>
				<li id="education">
					<ul>
						<div class="dropdown-header">
							<img src="_assets/_img/educationalPlan-big.png">
							<p>FÖRDERPLAN</p>
						</div>
						<div class="clearfix"><br /></div>
						<div class="overflow" style="">
							<div class="overflow-inner">				
								<?=$educationlist?>
							</div>
						</div>
					</ul>
				</li>
				<li id="compotences">
					<ul>
						<div class="dropdown-header">
							<img src="_assets/_img/educationalPlan-big.png">
							<p>DAS <br /> KANN <br /> ICH!</p>
						</div>
						<div class="clearfix"><br /></div>
						<div class="overflow" style="">
							<div class="overflow-inner">				
								<li><a href="index.php?action=show_all_completed">Alle Kompetenzen</a></li>
								<?=$chaptercompletedlist?>
							</div>
						</div>
					</ul>
				</li>
			</ul>
			
			<!-- NAVBAR RIGHT -->
			<ul class="nav-right nav">
				<li id="profile">
					<ul>
						<div class="dropdown-header">
							<img src="<?=$current_avatar?>" style="width: 70px">
							<p><?=$json_student_response['forename']?> <br /><?=$json_student_response['surname']?> </p>
							<div class="birthday"><?=$json_student_response['birth']?></div>
						</div>
						<div class="clearfix"><br /></div>
						<div class="overflow">
							<div class="overflow-inner">				
								<li><a href="index.php?p=profil">Mein Profilbild Ändern</a></li>
								<li><a href="index.php?p=password">Mein Passwort Ändern</a></li>
								<li><a href="index.php?p=deleteprofil">Mein Profil löschen</a></li>
							</div>
						</div>
					</ul>
				</li>
				<li id="school">
					<ul>
						<div class="dropdown-header">
							<img src="_assets/_img/school/school-rose-big-active.png">
							<p><?=$json_student_response['school']['name']?></p>
						</div>
						<div class="dropdown-text">
							<?php
							// EXPLODE ADDRESS TO GET THE RIGHT FORM
							$address_street = explode(',', $json_student_response['school']['address'])[0];
							$address_zipcode = explode(',', $json_student_response['school']['address'])[1];
							?>
							
							<?=$address_street?> <br />
							<?=$address_zipcode?> <br />
							<?=$json_student_response['school']['country']?><br /><br />
							<?=$json_student_response['school']['email']?><br />
							<?=$json_student_response['school']['telefon']?>
						</div>
					</ul>
				</li>
				<li id="school_class">
					<ul>
						<div class="dropdown-header">
							<img src="<?=$json_student_response['studyGroups']['imageUrlBig']?>">
							<p>KLASSE <br /> <?=$json_student_response['studyGroups']['class']?></p>
						</div>
						<div class="dropdown-text">
							KLASSENLEHRER*IN <br />
							<?=$json_student_response['formteacher']?>
						</div>
					</ul>
				</li>
				
				<li class="seperator"></li>
				
				<li id="help">
					<ul>
						<div class="dropdown-header">
							<img src="_assets/_img/help-big.png">
							<p>BRAUCHST DU <br /> HILFE?</p>
						</div>
						<div class="clearfix"><br /></div>
						<div class="overflow">
							<div class="overflow-inner">				
								<li><a href="http://www.check-lehrerzimmer.com/hilfe/erste-schritte/" target="_blank">SO GEHT'S!</a></li>
								<li><a href="http://www.check-lehrerzimmer.com/tutorial/" target="_blank">VIDEO-TUTORIALS</a></li>
								<li><a href="http://www.check-lehrerzimmer.com/faq/" target="_blank">HÄUFIG GESTELLTE FRAGEN</a></li>
								<li><a href="http://www.check-lehrerzimmer.com/contact/" target="_blank">KONTAKT</a></li>
							</div>
						</div>
					</ul>
				</li>
				<li id="logout">
					<ul>
						<div class="dropdown-header">
							<img src="_assets/_img/logout-big.png">
							<p>MÖCHTEST DU <br /> CHECK <br /> VERLASSEN?</p>
						</div>
						<div class="clearfix"><br /></div>
						<div class="overflow">
							<div class="overflow-inner">				
								<li><a href="index.php?logout">JA</a></li>
								<li><a href="#">NEIN</a></li>
							</div>
						</div>
					</ul>
				</li>		
			</ul>
		</div>	
		<div class="clearfix"></div>
		<?php
		if(isset($_SESSION['logged_in'])){
			if(!isset($_GET['p'])){
				$page = 'home';
			} else {
				$page = $_GET['p'];
			}
			include('_page/page.'.$page.'.php');
		}
		?>
		<footer>
			<img src="/_assets/_img/login/footer.png"><br /><small>edition 2016 dark night blue 1.0</small>
		</footer>	
	</body>
</html>
<?php
// CLEAN OUTPUT
ob_end_flush();
?>