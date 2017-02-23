<main class="site-content" style="background-color: <?=($background_color ? $background_color : '');?>">
	<div class="containerwrap">
		<div class="container">
			
			<?php if($response == 'chapter' OR $response == 'chapter_completed'){ if($action != 'show_all_completed') { ?>
			<div class="nav-scroller" id="nav-top" style="position: relative; float: right; margin-right: 60px; margin-top: 10px">
				<img src="_assets/_img/chapter<?=$action?>/scrollUp.png" style=" position: fixed">
			</div>
			<?php } } else { ?>		
			<div class="nav-scroller" id="nav-top" style="position: relative; float: right; margin-right: 60px; margin-top: 10px">
				<img src="images/education/scrollUp.png" style="position: fixed">
			</div>
			<?php } ?>
		
			<div class="headline">
				<?php if($response == 'chapter' OR $response == 'chapter_completed'){ if($action != 'show_all_completed') {?>
					<img src="images/chapter<?=$action?>/littleChapterFlag.png">
				<?php } } else { ?>
					<img src="images/education/littleChapterFlag.png">
				<?php } ?>
			</div>	
			
			<?php if($action != 'show_all_completed'){ ?>
			<div class="left-bar"></div>
			<?php } ?>
	
				<div class="content" <?=($action == 'show_all_completed' ? 'style="position: relative; float: none !important; margin-top: 100px; left: 50%; width: 1080px; transform: translateX(-15%)"' : '')?>>
					<div class="content-inner">												
						<?php
						if($response == 'chapter' && $action != 'show_all_completed'){
							
							// GET COMPLETED CHAPTER
							$curl_chapter_completed = curl_init("http://46.101.204.215:1337/api/V1/studentcompetence?checked=true&chapterId=".$action);
							curl_setopt($curl_chapter_completed, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_chapter_completed, CURLOPT_HEADER, false);
							curl_setopt($curl_chapter_completed, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_chapter_completed, CURLOPT_RETURNTRANSFER, true);

							$chaptercompleted_response = curl_exec($curl_chapter_completed);
							$json_chaptercompleted_response = json_decode($chaptercompleted_response, true);
							
							
							// GET UNCOMPLETED CHAPTER
							$curl_chapter_uncompleted = curl_init("http://46.101.204.215:1337/api/V1/studentcompetence?checked=false&chapterId=".$action);
							curl_setopt($curl_chapter_uncompleted, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_chapter_uncompleted, CURLOPT_HEADER, false);
							curl_setopt($curl_chapter_uncompleted, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_chapter_uncompleted, CURLOPT_RETURNTRANSFER, true);

							$chapteruncompleted_response = curl_exec($curl_chapter_uncompleted);
							$json_chapteruncompleted_response = json_decode($chapteruncompleted_response, true);

							// GET EDUCATION
							$curl_education = curl_init("http://46.101.204.215:1337/api/V1/educationalPlan/".$action);
							curl_setopt($curl_education, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_education, CURLOPT_HEADER, false);
							curl_setopt($curl_education, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_education, CURLOPT_RETURNTRANSFER, true);

							$education_response = curl_exec($curl_education);
							$json_education_response = json_decode($education_response, true);
						
							
							// SET VIARABLES
							$completed_chapter_list = '';
							$uncompleted_chapter_list = '';							
							
							// SORT COMPLETED CHAPTER
							usort($json_chaptercompleted_response, function($a1, $a2) {
								$v1 = strtotime($a1['fromDate']);
								$v2 = strtotime($a2['fromDate']);
								return $v1 - $v2;
							});
							
							// START LOOP OF UNCOMPLETED CHAPTER
							foreach($json_chapteruncompleted_response as $uncompleted_chapter){
								if($uncompleted_chapter['checked'] != '1'){
									
									$competence_popover = 'Du hast diese Kompetenz noch nicht erreicht!';
									$img_src = 'images/chapter'.$action.'/competenceUndone.png';									
									
									$uncompleted_chapter_list .= '
																	<div class="bubble-text">
																		<p>'.$uncompleted_chapter['teacherText'].'</p>
																		<img src="'.$img_src.'" alt="chapter">
																		<span class="date">
																			'.$uncompleted_chapter['number'].'
																		</span>
																		<div class="popover">
																			'.$competence_popover.'
																		</div>
																	</div>	
																';
								}
							}
							
							// START LOOP OF COMPLETED CHAPTER
							foreach($json_chaptercompleted_response as $completed_chapter){
								
								$strtime = strtotime($completed_chapter['fromDate']);
								
								$competence_popover = 'Du hast diese Kompetenz am '.date('d.m.Y', $strtime).' erreicht!';								
								$img_src = 'images/chapter'.$action.'/competenceDone.png';
								
								$completed_chapter_list .= '
																<div class="bubble-text">
																	<p>'.$completed_chapter['teacherText'].'</p>
																	<img src="'.$img_src.'" alt="chapter">
																	<span class="date">
																		'.$completed_chapter['number'].'
																	</span>
																	<div class="popover">
																		'.$competence_popover.'
																	</div>
																</div>	
															';
								
							
							}
							
							// OUTPUT BUBBLES
							echo $completed_chapter_list . $uncompleted_chapter_list;
						
						} elseif($response == 'chapter_completed' && $action != 'show_all_completed'){

							// GET COMPLETED CHAPTER
							$curl_chapter_completed = curl_init("http://46.101.204.215:1337/api/V1/studentcompetence?checked=true&chapterId=".$action);
							curl_setopt($curl_chapter_completed, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_chapter_completed, CURLOPT_HEADER, false);
							curl_setopt($curl_chapter_completed, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_chapter_completed, CURLOPT_RETURNTRANSFER, true);

							$chaptercompleted_response = curl_exec($curl_chapter_completed);
							$json_chaptercompleted_response = json_decode($chaptercompleted_response, true);
							
							// SET VIARABLES
							$completed_chapter_list = '';						
							
							// SORT COMPLETED CHAPTER
							usort($json_chaptercompleted_response, function($a1, $a2) {
								$v1 = strtotime($a1['fromDate']);
								$v2 = strtotime($a2['fromDate']);
								return $v1 - $v2;
							});
							
						
							
							// START LOOP OF COMPLETED CHAPTER
							foreach($json_chaptercompleted_response as $completed_chapter){
								
								$strtime = strtotime($completed_chapter['fromDate']);
								
								$competence_popover = 'Du hast diese Kompetenz am '.date('d.m.Y', $strtime).' erreicht!';
								$img_src = 'images/chapter'.$action.'/competenceDone.png';
								
								$completed_chapter_list .= '
																<div class="bubble-text">
																	<p>'.$completed_chapter['teacherText'].'</p>
																	<img src="'.$img_src.'" alt="chapter">
																	<span class="date">
																		'.$completed_chapter['number'].'
																	</span>
																	<div class="popover">
																		'.$competence_popover.'
																	</div>
																</div>	
															';
								
							}
							
							// OUTPUT BUBBLES
							echo $completed_chapter_list;
						
						} elseif($response == 'education' && $action != 'show_all_completed'){
							
							$curl_education_completed = curl_init("http://46.101.204.215:1337/api/V1/educationalPlan/".$action);
							curl_setopt($curl_education_completed, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_education_completed, CURLOPT_HEADER, false);
							curl_setopt($curl_education_completed, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_education_completed, CURLOPT_RETURNTRANSFER, true);

							$educationcompleted_response = curl_exec($curl_education_completed);
							$json_educationcompleted_response = json_decode($educationcompleted_response, true);
							
							$curl_chapter_completed = curl_init("http://46.101.204.215:1337/api/V1/studentcompetence");
							curl_setopt($curl_chapter_completed, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_chapter_completed, CURLOPT_HEADER, false);
							curl_setopt($curl_chapter_completed, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_chapter_completed, CURLOPT_RETURNTRANSFER, true);

							$chaptercompleted_response = curl_exec($curl_chapter_completed);
							$json_chaptercompleted_response = json_decode($chaptercompleted_response, true);

							$completed_education_list = '';
							foreach($json_educationcompleted_response[0]['competences'] as $completed_education){

								$img_src = 'images/chapter'.$json_chaptercompleted_response[$completed_education['competenceId']]['chapterId'].'/competenceDone.png';
								
								$completed_education_list .= '
																	<div class="bubble-text">
																		<p>'.$json_chaptercompleted_response[$completed_education['competenceId']]['teacherText'].'</p>
																		<img src="'.$img_src.'" alt="chapter">
																		<span class="date">
																			'.$completed_education['order'].'
																		</span>
																		<div class="popover">
																			'.$completed_education['note'].'
																		</div>
																	</div>	
																';
							
								
							}
							
							echo $completed_education_list;
						}
						
						if($action == 'show_all_completed'){
							// GET COMPLETED CHAPTER
							$curl_chapter_completed = curl_init("http://46.101.204.215:1337/api/V1/studentcompetence?checked=true");
							curl_setopt($curl_chapter_completed, CURLOPT_CUSTOMREQUEST, "GET");
							curl_setopt($curl_chapter_completed, CURLOPT_HEADER, false);
							curl_setopt($curl_chapter_completed, CURLOPT_HTTPHEADER, $headers);
							curl_setopt($curl_chapter_completed, CURLOPT_RETURNTRANSFER, true);

							$chaptercompleted_response = curl_exec($curl_chapter_completed);
							$json_chaptercompleted_response = json_decode($chaptercompleted_response, true);	

							// SORT COMPLETED CHAPTER
							usort($json_chaptercompleted_response, function($a1, $a2) {
								$v1 = strtotime($a1['fromDate']);
								$v2 = strtotime($a2['fromDate']);
								return $v1 - $v2;
							});
							
							$completed_chapter_list = '';

							
							// START LOOP OF COMPLETED CHAPTER
							foreach($json_chaptercompleted_response as $completed_chapter){
								
								$strtime = strtotime($completed_chapter['fromDate']);
								
								$competence_popover = 'Du hast diese Kompetenz am '.date('d.m.Y', $strtime).' erreicht!';								
								$img_src = 'images/chapter'.$completed_chapter['chapterId'].'/competenceDone.png';
								
								$completed_chapter_list .= '
																<div class="bubble-text">
																	<p>'.$completed_chapter['teacherText'].'</p>
																	<img src="'.$img_src.'" alt="chapter">
																	<span class="date">
																		'.$completed_chapter['number'].'
																	</span>
																	<div class="popover">
																		'.$competence_popover.'
																	</div>
																</div>	
															';
								
							
							}
							
							echo $completed_chapter_list;
						}
						
						?>
					</div>
				</div>
				
			<?php if($action != 'show_all_completed'){ ?>
			<div class="right-bar"></div>
			<?php } ?>
			
			<?php if($response == 'chapter' OR $response == 'chapter_completed'){ if($action != 'show_all_completed') {?>
			<div class="nav-scroller" id="nav-down" style="position: relative; float: right; margin-right: 60px">
				<img src="_assets/_img/chapter<?=$action?>/scrollDown.png" style=" position: fixed; bottom: 70px">
			</div>	
			<?php } } else { ?>		
			<div class="nav-scroller" id="nav-down" style="position: relative; float: right; margin-right: 60px">
				<img src="images/education/scrollDown.png" style="position: fixed; bottom: 70px">
			</div>
			<?php } ?>
			
			<div class="clearfix"></div>
		</div>
	</div>
</main>
