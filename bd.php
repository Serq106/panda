<?php

	$type = $_POST['types'];

	if($type == "video" || $type == "videoY"){		
		$connect = logs();
		$urls = $_POST['urls'];
		$uid = $_POST['id'];
		mysqli_query($connect, "INSERT INTO `video` (`id_video`, `player`, `type`) 	VALUE (NULL, '$urls', '$type')");
		
		$sql = mysqli_query($connect, "SELECT id_user FROM users WHERE uid = '$uid'");
		while ($result = mysqli_fetch_array($sql)) {
			$id_user =  $result['id_user'];
		}
		
		$sql = mysqli_query($connect, "SELECT `id_video` FROM `video` WHERE `player` ='$urls' ");
		while ($result = mysqli_fetch_array($sql)) {
			$id_video =  $result['id_video'];
		}
		
		mysqli_query($connect, "INSERT INTO `user_video` (`id_user`,`id_video`) VALUE('$id_user', '$id_video')");
		
	} else if($type =="posts"){
		$connect = logs();
		$id_user = $_POST['id_user'];
		$url_photo = $_POST['url_photo'];
		$name = $_POST['name'];
		$id_post = $_POST['id_post'];
		$id_photo = $_POST['id_photo'];
		$text = $_POST['texts'];
		$uid = $_POST['id'];
		mysqli_query($connect, "INSERT INTO  `posts` (`id_post`,`id_user`,`id_photo`,`texts`,`url_photo`,`name`) 
			VALUE('$id_post','$id_user','$id_photo','$text','$url_photo','$name')");
			
		$sql = mysqli_query($connect, "SELECT id_user FROM users WHERE uid = '$uid'");
		while ($result = mysqli_fetch_array($sql)) {
			$id_user =  $result['id_user'];
		}
		
		$sql = mysqli_query($connect, "SELECT `id_posts` FROM `posts` WHERE `id_post` ='$id_post'");
		while ($result = mysqli_fetch_array($sql)) {
			$id_posts =  $result['id_posts'];
		}

		mysqli_query($connect, "INSERT INTO `user_post` (`id_user`,`id_post`) VALUE('$id_user', '$id_posts')");
		
	}
	
	function search_video($uid){
		$connect = logs();
		$sql = mysqli_query($connect, "SELECT v.`player` FROM `users` AS u INNER JOIN `user_video` AS uv ON u.`id_user` = uv.`id_user` 
			INNER JOIN `video` AS v ON uv.`id_video` = v.`id_video` WHERE u.uid = '$uid'");
		return $sql;
	}
	
	function search_post($uid){
		$connect = logs();
		$sql = mysqli_query($connect, "SELECT p.* FROM `users` AS u INNER JOIN `user_post` AS up ON u.`id_user` = up.`id_user` 
			INNER JOIN `posts` AS p ON up.`id_post` = p.`id_posts` WHERE u.uid =  '$uid'");
		return $sql;
	}
	
	function logs(){
		$connect = mysqli_connect('localhost','mysql', 'mysql');
		if (!$connect) {
		   die('Connect error: '.mysql_error());
		}
		mysqli_select_db($connect, "panda");
		return $connect;
	}
	
	
	function authorization( $uid ){
		$connect = logs();
		$result = mysqli_query($connect, "SELECT id_user FROM users WHERE uid = $uid");
		$rows = mysqli_num_rows($result);
		
		if($rows == 0){
			$result = mysqli_query($connect, "INSERT INTO `users` (`id_user`,`uid`,`first_name`,`last_name`,`photo`,`id_social_network`) VALUES (null, '2' ,'asd' ,'asd' , 'asd', 1)");
			//$result = mysqli_query($connect, "INSERT INTO `users` (`id_user`,`uid`,`first_name`,`last_name`,`photo`,`id_social_network`) VALUES (null, '$uid' ,'$first_name' ,'$last_name' , '$photo', 1)");

		}
	}
	
	function history($text, $type, $uid){
		$connect = logs();
		if($uid != null){
			mysqli_query($connect, "INSERT INTO `history` (`id_history`,`text`,`type`,`uid` ) VALUES (NULL, '$text' ,'$type', '$uid')");
		} else {
			mysqli_query($connect, "INSERT INTO `history` (`id_history`,`text`,`type`,`uid` ) VALUES (NULL, '$text' ,'$type', '1234')");
		}
	}
	/*добовление в базу видео*/
	/*$startFrom = 0;
						do{
							$result = video_search($text, 200, $startFrom,  $access_token);
							for($i=0;$i<sizeof($result ->response -> items);$i++){
								$id = $result -> response -> items[$i] -> id;
								$owner_id = $result -> response -> items[$i] -> owner_id;
								$player = $result -> response -> items[$i] -> player;
								$title = $result -> response -> items[$i] -> title;
								$description = $result -> response -> items[$i] -> description;
								$views = $result -> response -> items[$i] -> views;	
								$width = $result -> response -> items[$i] -> width;
								$height = $result -> response -> items[$i] -> height;
								$date = $result -> response -> items[$i] -> date;
								$index = mysqli_query($connect, "SELECT id_video FROM video WHERE id = $id and owner_id = $owner_id");
								
								$rows = mysqli_num_rows($index);
								echo $rows;
								if($rows == 0){
									$sql = "INSERT INTO `video` (`id_video`,`id`,`owner_id`,`player`,`title`,`description`,`views`,`width`,`height`,`date`) 
										VALUE (NULL, '$id' ,'$owner_id', '$player', '$title', '$description', '$views', '$width', '$height', '$date')";
									mysqli_query($connect, $sql);
								} else {
									break;
									$startFrom = 1000;
								}*
							}
							$startFrom += 200;
						}while( $startFrom > 1000);
	*/
?>