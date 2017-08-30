<?php
	session_start();
	if (isset($_GET['uid'])) {
		setcookie("uid", $_GET['uid'], time() + 36000);
		setcookie("first_name", $_GET['first_name'], time() + 36000);
		setcookie("last_name", $_GET['last_name'], time() + 36000);
		setcookie("photo", $_GET['photo'], time() + 36000);
	}
	if (isset($_POST['status'])) $_SESSION['status'] = $_POST['status'];
	$startFrom = $_SESSION['status'];
	
	if ($startFrom == "not_authorized") {
		setcookie("uid", null, time() + 36000);
		echo "asdasdasdad";
	}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="//vk.com/js/api/openapi.js?143"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

    <script type="text/javascript">
        VK.init({apiId: 5965004});
    </script>
    <div id="vk_auth"></div>
    <script type="text/javascript">

        VK.Widgets.Auth("vk_auth", {authUrl: 'index.php'});

        VK.Auth.getLoginStatus(function (response) {
            if (response.session) {
                var uid = response.session.mid;
                //alert(uid);
                $.ajax({
                    url: "index.php",
                    type: "POST",
                    data: {id: uid},
                    success: function (response) {
                        //alert("Good");
                    }
                });
            } else {
                $.ajax({
                    url: "t.php",
                    type: "POST",
                    data: {id: null},
                    success: function (response) {
                        //alert("Not Good");
                    }
                });

            }
        });
    </script>

    <script src="https://connect.soundcloud.com/sdk/sdk-3.1.2.js"></script>
</head>

<body>


<?php
	
	$uid = $_COOKIE["uid"];
	include_once("bd.php");
	echo $uid;
	authorization($uid);
	$connect = logs();
	echo "____";
	$sql = mysqli_query($connect, "SELECT id_user FROM users WHERE uid = '107940536'");
	while ($result = mysqli_fetch_array($sql)) {
		echo $id_user = $result['id_user'];
	}
	
	$sql = mysqli_query($connect, "SELECT `id_posts` FROM `posts` WHERE `id_post` ='979'");
	while ($result = mysqli_fetch_array($sql)) {
		echo $id_posts = $result['id_posts'];
	}

?>

<div class="header">
    <div id="logo"><img src="img/Panda.JPG"></div>
    <h2>THE SOCIAL SEARCH ENGINE</h2>

    <div class="select">
        <form id="myForm" class="myForm" method="post" action="main.php">

            <input name="posts" id="posts1" type="radio" checked="checked" value="posts"/>пост
            <input name="posts" id="posts2" type="radio" value="video"/>видео с вк
            <input name="posts" id="posts3" type="radio" value="human"/>человек

            <input type="text" value="" name="text" id="text" placeholder="введите # или слово"
                   style="width: 69%;height: 40px;margin-right: 10px;">
            <div class="asd">
                <input type="text" value="" name="last_name" id="text" placeholder="Введите имя"
                       style="width: 69%;height: 40px;margin-right: 10px;">
                <input type="text" value="" name="first_name" id="text" placeholder="Введите фамилию"
                       style="width: 69%;height: 40px;margin-right: 10px;">
            </div>
            <input type="submit" value="SEARCH" id="submit" name="submit" style="border:2px solid #8e989a;">
        </form>
    </div>
</div>


</body>
</html>