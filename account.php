<html>

	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/style.css">	
	</head>

	<body>
		<?php
			print("	
				<form method='POST' action='index.php'>
					<input type='submit' value='главная'>
				</form>
			");
			include_once("bd.php");	
			
			$uid = $_COOKIE["uid"];	
			echo $uid;
			
			$sql = search_video($uid);
			while ($result = mysqli_fetch_array($sql)) {
					$url_video =  $result['player'];
					print("	
							<div id='video12'>
								<iframe src='$url_video' frameborder='0' allowfullscreen></iframe>									  
							</div>
					");
				}
			$sql = search_post($uid);
			while ($result = mysqli_fetch_array($sql)) {
				$id_post =  $result['id_post'];
				$id_user =  $result['id_user'];
				$id_photo =  $result['id_photo'];
				$text =  $result['texts'];
				$url_photo =  $result['url_photo'];
				$name =  $result['name'];
				if ($id_user > 0){
					print("			 
						<div class='post_grup'> 
							<div class='ava'>	
								<div class='top_logo'>
										<a href='https://vk.com/id$id_user'>
											<img src='$url_photo' class='photo'>
											<span class='text'>$name<span>
										</a>
									<a href='https://vk.com/'>
										<img src='https://img3.goodfon.ru/wallpaper/middle/f/2c/vk-vkontakte-logo-vk.jpg' class='logo'>
									</a>
								</div>
								<a href='https://vk.com/search?w=wall$id_user$E$id_post'>
								<div class='phost_photo'>
									<img src='$id_photo'>
								</div>										
								<p>$text</p>
								</a>
								

							</div>
						</div>
					");
				} else {
					print("			 
						<div class='post_grup'> 
							<div class='ava'>	
								<div class='top_logo'>
										<a href='https://vk.com/public$id_group'>
											<img src='$url_photo' class='photo'>
											<span class='text'>$name<span>
										</a>
									<a href='https://vk.com/'>
										<img src='https://img3.goodfon.ru/wallpaper/middle/f/2c/vk-vkontakte-logo-vk.jpg' class='logo'>
									</a>
								</div>
								<a href='https://vk.com/search?w=wall$id_user$E$id_post'>
								<div class='phost_photo'>
									<img src='$id_photo'>
								</div>	
								<p>$text</p>
								</a>

							</div>
						</div>
					");
				}
			}
		?>
	</body>
</html>