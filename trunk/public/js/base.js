<<<<<<< .mine
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
   $(document).ready(function(){
    loadBlogs();
    $("div.member ul li a").click(function(){
        var id=$(this).attr("id");
		$(this).css({"background-image":"url(../public/images/memberlibackground.png)","background-position":"0 -72px","background-repeat":"no-repeat","display":"block","height":"68px","padding":"0 0 0 35px","text-decoration":"none"});//点击改变背景
		var userid=$.cookies.get("userid");//取cookie
		$("ul li a[id="+userid+"]").css({"background-image":"url(../public/images/memberlibackground.png)","background-position":"0 -3px","background-repeat":"no-repeat","display":"block","height":"68px","padding":"0 0 0 35px","text-decoration":"none"});//回复激活前北京
		$.cookies.set("userid",id);
    var url="http://localhost/sina/index.php/ajax_serv?value="+id;
    var dataP={
            value:id
        };
    $(".maincontent").html("\u52a0\u8f7d\u4e2d...");
    $.get(url,dataP,function(data){
        var json=$.parseJSON(data);
        $(".maincontent").html("");
        $(".maincontent").append(json.result);
        });
    });
    function loadBlogs(){
        $.cookies.set("userid","1");
        var userid=$.cookies.get("userid");//取cookie
        $("ul li a[id="+userid+"]").css({"background-image":"url(../public/images/memberlibackground.png)","background-position":"0 -72px","background-repeat":"no-repeat","display":"block","height":"68px","padding":"0 0 0 35px","text-decoration":"none"});
        $(".maincontent").html("\u52a0\u8f7d\u4e2d...");
       var url="http://localhost/sina/index.php/ajax_serv?value=1";
        $.get(url,function(data){
            var json=$.parseJSON(data);
            $(".maincontent").html("");
            $(".maincontent").append(json.result);
        });
    }
});



=======
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
   $(document).ready(function(){
    loadBlogs();
    $("div.member ul li a").click(function(){
        var id=$(this).attr("id");
		$(this).css({"background-image":"url(../public/images/memberlibackground.png)","background-position":"0 -72px","background-repeat":"no-repeat","display":"block","height":"68px","padding":"0 0 0 35px","text-decoration":"none"});//点击改变背景
		var userid=$.cookies.get("userid");//取cookie
		$("ul li a[id="+userid+"]").css({"background-image":"url(../public/images/memberlibackground.png)","background-position":"0 -3px","background-repeat":"no-repeat","display":"block","height":"68px","padding":"0 0 0 35px","text-decoration":"none"});//回复激活前北京
		$.cookies.set("userid",id);
        var url="http://192.168.8.79/celebritytop/index.php/ajax_serv?value="+id;
        var dataP={
            value:id
        };
        $(".maincontent").html("\u52a0\u8f7d\u4e2d...");
        $.get(url,dataP,function(data){
            $(".maincontent").html("");
            $(".maincontent").append(data);
        });
    });
    function loadBlogs(){
        $.cookies.set("userid",1);
        var userid=$.cookies.get("userid");//取cookie
        $("ul li a[id="+userid+"]").css({"background-image":"url(../public/images/memberlibackground.png)","background-position":"0 -72px","background-repeat":"no-repeat","display":"block","height":"68px","padding":"0 0 0 35px","text-decoration":"none"});
        $(".maincontent").html("\u52a0\u8f7d\u4e2d...");
       var url="http://192.168.8.79/celebritytop/index.php/ajax_serv?value=1";
        $.get(url,function(data){
            $(".maincontent").html("");
            $(".maincontent").append(data);
        });
    }
})
})


>>>>>>> .r4
