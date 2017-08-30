<?php

	session_start();	
	$text = $_SESSION['s_text'];
	$type = $_SESSION['s_type'];
	$access_token = $_SESSION['s_access_token'];
	$access_token_youtube = $_SESSION['s_access_token_youtube'];
	$startFrom = $_POST['startFrom'];
	$uid = $_COOKIE["uid"];	
	include_once("method.php");
	
	if(($text !='' && $type == "video")){
		$result =  video_search($text, 10, $startFrom, $access_token);
			
		$articles = array();
		for($i=0; $i< 10; $i++)
		{
			$url_video = $result -> response -> items[$i] -> player;
			$articles[] =  array("video" ,$url_video, $uid);
		}
		echo json_encode($articles);
		
	} else if(($text !='' && $type == "posts")){
			$text=str_replace(" ","%20",$text);
			$f=str_replace("#","%23",$text);
			$u_info = newsfeed_search($f, 10, $startFrom , 5.12, $access_token);

			
		$articles = array();
		for($i=0; $i< 10; $i++)
		{
			$id_post = $u_info -> response -> items[$i] -> id;
			$id_user = $u_info -> response -> items[$i] -> owner_id;
			$id_photo = $u_info -> response -> items[$i] -> attachments[0] -> photo -> photo_604;	
			$text = $u_info -> response -> items[$i] -> text;
			if ($user_id > 0){
				$result = users_get($id_user, "photo_50", 5.52, $access_token);
				$url_photo =$result ->response[0] -> photo_50;
				$first_name =$result ->response[0] -> first_name;
				$last_name =$result ->response[0] -> last_name;
				$name = $first_name." ".$last_name;
				$articles[] = array("post" ,$id_post, $id_user, $id_photo, $text, $url_photo, $name, $uid) ;

			} else {	
				$id_group =  abs($id_user);							
				$result = groups_getById($id_user, 5.63, $access_token);
				$url_photo = $result ->response[0] -> photo_50;
				$name_group = $result ->response[0] -> name;
				$articles[] = array("post" ,$id_post, $id_user, $id_photo, $text, $id_group, $url_photo, $name_group, $uid) ;
			}
			
		}
		echo json_encode($articles);
	} else if((/*$text !='' && */$type == "human")){
		$last_name = $_SESSION['s_last_name'];
		$first_name = $_SESSION['s_first_name'];
		if ($last_name != null && $first_name != null){
			$q = $last_name.'%20'.$first_name;
		} else if ($last_name != null && $first_name == null)
		{
			$q = $last_name;
		}else if ($last_name == null && $first_name != null)
		{
			$q = $first_name;
		}
		$result = users_search($q, 392, 5.63, $access_token, $startFrom);

			
		$articles = array();
		for($i=0; $i< 10; $i++)
		{	
				$id_user = $result -> response -> items[$i] -> id;						
				$url_photo = $result -> response -> items[$i] -> photo_200;
				$first_name = $result -> response -> items[$i] -> first_name;
				$last_name = $result -> response -> items[$i] -> last_name;
				$articles[] = array("human" ,$id_user, $url_photo, $first_name, $last_name) ;

		}
		echo json_encode($articles);
	} else if(($text !='' && $type == "videoY")){
		$nextPageToken = $_SESSION['nextPageToken'];
		$result = video_search_youtube("snippet", 10, $text, $nextPageToken, $access_token_youtube);
		$_SESSION['nextPageToken'] = $result -> nextPageToken;
		$e = $result -> nextPageToken;		
		$articles = array();
		for($i=0; $i< 10; $i++)
		{
			$url_video = $result ->items[$i] -> id -> videoId;
			$url_video = 'https://www.youtube.com/embed/'.$url_video;
			$articles[] =  array("videoY", $url_video, $uid);
		}
		echo json_encode($articles);	
	}
?>
