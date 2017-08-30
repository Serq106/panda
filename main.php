<?php
	session_start();
	$_SESSION['s_type'] = $_POST['posts'];
	$_SESSION['s_text'] = $_POST['text'];
	$_SESSION['s_last_name'] = $_POST['last_name'];
	$_SESSION['s_first_name'] = $_POST['first_name'];
	$_SESSION['s_access_token'] = "efc73f65255e2b4d695f33b3684c1449aed343f60b8a42d29aff9f69259458598d9f4903ec36469f8b942";
	$_SESSION['s_access_token_youtube'] = "AIzaSyDq9g7EfYCwjLXo6Z0Dfrzs5LMXb_ZVaFY";
	
	
	include_once("method.php");
	include_once("bd.php");
	include_once("controller/PostController.php");
	include_once("controller/VideoController.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery-3.2.1.minjs"></script>
    <script src="js/grid.js"></script>


</head>

<body>


<div class="navbar-left">
    <form id="demo-b" method="post" action="main.php">
        <input type="search" value="" name="text" id="text" placeholder="введите # или слово">
        <input type="submit" value="SEARCH" id="submit" name="submit" style="border:2px solid #8e989a;">
    </form>
</div>


<div id="res">
    <div id="content">
		<?php
			$uid = $_COOKIE["uid"];
			$text = $_SESSION['s_text'];
			$type = $_SESSION['s_type'];
			$access_token = $_SESSION['s_access_token'];
			$access_token_youtube = $_SESSION['s_access_token_youtube'];
			
			if ($uid != null) {
				print("
							<form method='POST' action='account.php'>
								<input type='submit' value='личный каинет'>
							</form>
						");
			}
			
			history($text, $type, $uid);
			
			
			if (($text != '' && $type == "posts")) {
				
				$text = str_replace(" ", "%20", $text);
				$text = str_replace("#", "%23", $text);
				$post = new PostController();
				$post->getPostVk($text, $access_token);
				
			} else if (($text != '' && $type == "video")) {
				//Ютуб
				$VideoControl = new VideoController();
				$VideoYoutube = $VideoControl->GetYouTubeVideo($text, $access_token_youtube);
				$_SESSION['nextPageToken'] = $VideoArray->nextPageToken;
				//vk
				$VideoVK = $VideoControl->GetVKVideo($text, $access_token);
				$VideoControl->PrintVideo($VideoYoutube, $VideoVK);
			} else if ((/*$text !='' &&*/
				$type == "human")) {
				$last_name = $_SESSION['s_last_name'];
				$first_name = $_SESSION['s_first_name'];
				if ($last_name != null && $first_name != null) {
					$q = $last_name . '%20' . $first_name;
				} else if ($last_name != null && $first_name == null) {
					$q = $last_name;
				} else if ($last_name == null && $first_name != null) {
					$q = $first_name;
				}
				
				$result = users_search($q, 392, 5.63, $access_token, 0);
				
				
				for ($i = 0; $i < sizeof($result->response->items); $i++) {
					$id_user = $result->response->items[ $i ]->id;
					$url_photo = $result->response->items[ $i ]->photo_200;
					$first_name = $result->response->items[ $i ]->first_name;
					$last_name = $result->response->items[ $i ]->last_name;
					if ($url_photo != null) {
						print("
									<div class='user'>
										<a href='https://vk.com/id$id_user'>
											<div class='user_photo' >
												<img src='$url_photo' style='display: inline-block;'>
												<span class='unfo_user' style='position: absolute;'>$first_name $last_name<span>
											</div>
										</a>
									</div>
								");
					}
				}
				
			} else {
				echo "Информация не найдена, попробйте ввести другой текст";
			}
		?>

    </div>
</div>

</body>
</html>