<?php
	
	function video_search_youtube( $part, $maxResults, $q, $pageToken, $key ){
		$request_params = array(
				'part' => $part,
				'maxResults' => $maxResults,
				'q' => $q,
				'pageToken' => $pageToken,
				'key' => $key
			);
			
			$url = "https://www.googleapis.com/youtube/v3/search?".http_build_query($request_params);
			$result = json_decode(file_get_contents($url));
			return $result;
	}
	
	function video_search( $text, $count, $offset, $access_token ){
		$request_params = array(
				'q' => $text,
				'count' => $count,
				'offset' => $offset,
				'v' => 5.63,
				'access_token' => $access_token
			);
			
			$url = "https://api.vk.com/method/video.search?".http_build_query($request_params);
			$result = json_decode(file_get_contents($url));
			return $result;
	}
	
	function newsfeed_search( $q, $count, $offset, $v, $access_token ){

		$request_params = array(
				'count' => $count,
				'offset' => $offset,
				'v' => $v,
				'access_token' => $access_token
			);
			
			$u_info = json_decode(file_get_contents('https://api.vk.com/method/newsfeed.search?q='.$q.'&'.http_build_query($request_params)));
			return $u_info;
	}
		
	function users_get($user_id, $fields, $v, $access_token){
		
		$request_params = array(
			'user_id' => $user_id,
			'fields' => $fields,
			'v' => $v,
			'access_token' => $access_token
		);
			
		$get_params = http_build_query($request_params);
		$result = json_decode(file_get_contents('https://api.vk.com/method/users.get?'.$get_params.'&fields=photo_50'));
		return $result;
	}
	
	function groups_getById($id_user, $v, $access_token){
		$id_group =  abs($id_user);
		
		$request_params = array(
			'group_id' => $id_group,
			'v' => $v,
			'access_token' => $access_token
		);
			
		$get_params = http_build_query($request_params);
		$result = json_decode(file_get_contents('https://api.vk.com/method/groups.getById?'.$get_params));
		return $result;
	}
	
	function users_search($q, $city, $v, $access_token, $offset)
	{
		$request_params = array(
			'count' => 10,
			'offset' => $offset,
			'city' => $city,
			'v' => $v,
			'access_token' => $access_token			
		);
		
		$get_params = http_build_query($request_params);
		$result = json_decode(file_get_contents('https://api.vk.com/method/users.search?q='.$q.'&'.$get_params.'&fields=photo_200'));
		return $result;
	}
	
	

?>