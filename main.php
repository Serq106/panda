<?php
session_start();
$_SESSION['s_type'] = $_POST['posts'];
$_SESSION['s_text'] = $_POST['text'];
$_SESSION['s_last_name'] = $_POST['last_name'];
$_SESSION['s_first_name'] = $_POST['first_name'];
$_SESSION['s_access_token'] = "efc73f65255e2b4d695f33b3684c1449aed343f60b8a42d29aff9f69259458598d9f4903ec36469f8b942";
/*"75ab00befad9388b7d1feda9be310ed76cdf445557ec1ec2aed71e0659a29b04a9c657428b0138e7807b0";*/
$_SESSION['s_access_token_youtube'] = "AIzaSyDq9g7EfYCwjLXo6Z0Dfrzs5LMXb_ZVaFY";


include_once("method.php");
include_once("bd.php");
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

        if($uid != null){
            print("	
							<form method='POST' action='account.php'>
								<input type='submit' value='личный каинет'>
							</form>
						");
        }

        history($text, $type, $uid);

        echo  $text;
        if(($text !='' && $type == "video")){
            //Ютуб
            $result = video_search_youtube("snippet", 10, $text, "", $access_token_youtube);
            $_SESSION['nextPageToken'] = $result -> nextPageToken;
            echo $nextPageToken;
            for($i=0;$i<sizeof($result -> items);$i++){
                $url_video = $result ->items[$i] -> id -> videoId;
                $url_video = 'https://www.youtube.com/embed/'.$url_video;
                if($uid != null){
                    print("	
									<div class='video'>
										<div id='video12'>
										  <iframe src='$url_video' frameborder='0' allowfullscreen></iframe>
										</div>
										<input type='button' value='Добавить!' onclick=\"AjaxFormRequest('$url_video', '$uid', '$type');\" >
									</div>
								");
                } else {
                    print("	
										<div id='video12'>
										  <iframe src='$url_video' frameborder='0' allowfullscreen></iframe>
										</div>										
								");
                }
            }
            $articles = array();	//vk
            $result = video_search($text, 10, 0,  $access_token);
            for($i=0;$i<sizeof($result ->response -> items);$i++){
                $url_video = $result -> response -> items[$i] -> player;

                if($uid != null){
                    print("	
									<div class='video'>
										<div id='video12'>
											<iframe src='$url_video' frameborder='0' allowfullscreen></iframe>									  
										</div>
										 <input type='button' value='Добавить!' onclick=\"AjaxFormRequest('$url_video', '$uid', '$type');\" >
									</div>"
                    );
                } else {
                    print("	
										<div id='video12'>
											<iframe src='$url_video' frameborder='0' allowfullscreen></iframe>									  
										</div>
								");
                }

            }


        }else if(($text !='' && $type == "posts")){

            $text=str_replace(" ","%20",$text);
            $text=str_replace("#","%23",$text);
            $u_info = newsfeed_search($text, 10, 0, 5.12, $access_token);
            for($i=0; $i<sizeof($u_info->response -> items);$i++){
                $id_post = $u_info -> response -> items[$i] -> id;
                $id_user = $u_info -> response -> items[$i] -> owner_id;
                $id_photo = $u_info -> response -> items[$i] -> attachments[0] -> photo -> photo_604;
                $text = $u_info -> response -> items[$i] -> text;
                $E = '_';

                if ($id_user > 0){
                    $result = users_get($id_user, "photo_50", 5.52, $access_token);
                    $url_photo =$result ->response[0] -> photo_50;
                    $first_name =$result ->response[0] -> first_name;
                    $last_name =$result ->response[0] -> last_name;
                    $name = $first_name." ".$last_name;

                } else {
                    $id_group =  abs($id_user);
                    $result = groups_getById($id_user, 5.63, $access_token);
                    $url_photo = $result ->response[0] -> photo_50;
                    $name = $result ->response[0] -> name;
                }

                //if($uid != null){
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
                                <input type='button' value='Добавить!' onclick=\"AjaxFormPost('$id_user', '$url_photo', '$name', '$id_post', '$id_photo','$text', '$type','$uid');\" >

                            </div>
                        </div>
                                            
									");
                } else {

                    print("	                                                                                  
                        <div class='post_grup '> 
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
                                <input type='button' value='Добавить!' onclick=\"AjaxFormPost('$id_user', '$url_photo', '$name', '$id_post', '$id_photo','$text', '$type', '$uid');\" >

                            </div>
                        </div>
								");
                }
                //}
            }
        } else if((/*$text !='' &&*/ $type == "human")){
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

            $result = users_search($q, 392, 5.63, $access_token, 0);


            for($i=0;$i<sizeof($result ->response -> items);$i++){
                $id_user = $result -> response -> items[$i] -> id;
                $url_photo = $result -> response -> items[$i] -> photo_200;
                $first_name = $result -> response -> items[$i] -> first_name;
                $last_name = $result -> response -> items[$i] -> last_name;
                if ($url_photo != null){
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

        }else{
            echo "Информация не найдена, попробйте ввести другой текст";
        }
        ?>

    </div>
</div>

</body>
</html>