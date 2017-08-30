function AjaxFormRequest(url_video, uid, type) {
	jQuery.ajax({
		url:     "bd.php", 
		type:     "POST", 
		data: {urls:url_video, id:uid, types:type},
		success: function(response) { 
			alert (type);
		}
	});
}

function AjaxFormPost(id_user, url_photo, name, id_post, id_photo, texts, type, uid) {
	jQuery.ajax({
		url:     "bd.php", 
		type:     "POST", 
		data: {id_user:id_user, url_photo:url_photo, name:name, id_post:id_post, id_photo:id_photo, texts:texts, types:type, id:uid},
		success: function(response) { 
			alert (type);
		}
	});
}

$(document).ready(function(){

var inProgress = false;
var startFrom = 10;
	
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 300 && !inProgress) {
		
        $.ajax({            
            url: 'obrabotchik.php',
            method: 'POST',
            data: {"startFrom" : startFrom},
            beforeSend: function() {
				inProgress = true;
			}
            /* что нужно сделать по факту выполнения запроса */            
            }).done(function(data){
            
            data = jQuery.parseJSON(data);
            
            if (data.length > 0) {            
				$.each(data, function(index, data){
            
            /* Отбираем по идентификатору блок со статьями и дозаполняем его новыми данными */    
			if(data[0,0] == "video")
				$("#content").append("<div class='video'><div id='video12'><iframe src='" + data[1] + "' allowfullscreen='' frameborder='0'></iframe></div><input type='button' value='Добавить!' onclick=\"AjaxFormRequest('"+data[1]+"', '"+data[2]+"', '"+data[0]+"');\" ></div>");
			else if(data[0,0] == "post")
			{
				if(data[2] > 0)
					$("#content").append("<div class='post_grup'><div class='ava'><div class='top_logo'><a href='https://vk.com/id" + data[2] + "'> <img src='" + data[5] +"' class='photo'> <span class='text'>" + data[6] +" <span> </a> <a href='https://vk.com/'> <img src='https://img3.goodfon.ru/wallpaper/middle/f/2c/vk-vkontakte-logo-vk.jpg' class='logo'> </a> </div> <a href='https://vk.com/search?w=wall" +data[2]+"_"+data[1]+"'> <div class='phost_photo'> <img src='"+data[3]+"'> </div> <p>"+data[4]+"</p></a><input type='button' value='Добавить!' onclick=\"AjaxFormPost('"+data[2]+"', '"+data[5]+"', '"+data[6]+"', '"+data[1]+"', '"+data[3]+"','"+data[4]+"', '"+data[0]+"','"+data[7]+"');\" ></div></div>");
				else if(data[2] < 0)
					$("#content").append("<div class='post_grup'><div class='ava'><div class='top_logo'><a href='https://vk.com/public" + data[5] + "'> <img src='" + data[6] +"' class='photo'> <span class='text'>" + data[7] +" "+  data[7] + "<span> </a> <a href='https://vk.com/'> <img src='https://img3.goodfon.ru/wallpaper/middle/f/2c/vk-vkontakte-logo-vk.jpg' class='logo'> </a> </div> <a href='https://vk.com/search?w=wall" +data[2]+"_"+data[1]+"'> <div class='phost_photo'> <img src='"+data[3]+"'> </div> <p>"+data[4]+"</p></a><input type='button' value='Добавить!' onclick=\"AjaxFormPost('"+data[2]+"', '"+data[5]+"', '"+data[6]+"', '"+data[1]+"', '"+data[3]+"','"+data[4]+"', '"+data[0]+"','"+data[7]+"');\" ></div></div>");

			} else if(data[0,0] == "human"){
				$("#content").append("<div class='user'><a href='https://vk.com/id"+data[1]+"'><div class='user_photo' ><img src='"+data[2]+"' style='display: inline-block;'><span class='unfo_user' style='position: absolute;'>"+data[3]+" "+data[4]+"<span></div></a></div>");
			} 
			else if(data[0,0] == "videoY"){
				$("#content").append("<div class='video'><div id='video12'><iframe src='" + data[1] + "' allowfullscreen frameborder='0'></iframe></div><input type='button' value='Добавить!' onclick=\"AjaxFormRequest('"+data[1]+"', '"+data[2]+"', '"+data[0]+"');\" ></div>");
			}
			
            });
			
            inProgress = false;
            startFrom += 10
			
            }});   
        }
    });
});
