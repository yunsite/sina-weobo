<<<<<<< .mine
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>名人头条</title>        
        <link href="<?php echo base_url(); ?>public/css/base.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url();?>public/js/jquery.min.js" type="text/javascript"></script>
       <script src="<?php echo base_url();?>public/js/jquery.cookies.js" type="text/javascript"></script>
       <script src="<?php echo base_url();?>public/js/base.js" type="text/javascript"></script>   

    </head>

    <body >
        <div class="globalheader">
            <div class="header"><!--头部-->
                <a href="#>">
                    <img class="headerlogo"  src="<?php echo base_url(); ?>public/images/logo.png" /></a>
                <span></span>
                <img class="headerlogo2" src="<?php echo base_url(); ?>public/images/headerlogo2.png" />
            </div>
        </div>
        <div class="topbar"><!--上边栏-->
            <a href="#"><span>分享名人头条</span></a>
            <span>名人每天最关注的事</span>
        </div>
        <div class="container"><!--容器-->
            <div class="member"><!--名人名单-->
                <ul>
                    <?php $count = 1;
                    foreach ($user_info as $item): ?>
                        <li><a id="<?= $count; ?>"><img src="<?= $item['img_url'] ?>" /><span> <?= $item['screen_name']; ?> </span></a></li>
                        <?php $count++;
                    endforeach; ?>
                </ul>
            </div>
            <div class="maincontent" id="maincontent"><!--微博内容-->

            </div>
        </div>
        <div class="footer"><!--下边栏-->
        </div>
        <a class="gotop" href="#"><!--返回顶部-->
        	<span>
            	<em class="sj">♦</em>
				<em class="fk">▐</em>
				返回顶部
            </span>
        </a>
    </body>
</html>
=======
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>名人头条</title>        
        <link href="<?php echo base_url(); ?>public/css/base.css" rel="stylesheet" type="text/css" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>public/js/jquery.cookies.js" type="text/javascript"></script>
       <script src="<?php echo base_url();?>public/js/base.js" type="text/javascript"></script>   

    </head>

    <body >
        <div class="globalheader">
            <div class="header"><!--头部-->
                <a href="#>">
                    <img class="headerlogo"  src="<?php echo base_url(); ?>public/images/logo.png" /></a>
                <span></span>
                <img class="headerlogo2" src="<?php echo base_url(); ?>public/images/headerlogo2.png" />
            </div>
        </div>
        <div class="topbar"><!--上边栏-->
            <a href="#"><span>分享名人头条</span></a>
            <span>名人每天最关注的事</span>
        </div>
        <div class="container"><!--容器-->
            <div class="member"><!--名人名单-->
                <ul>
                    <?php $count = 1;
                    foreach ($user_info as $item): ?>
                        <li><a id="<?= $count; ?>"  href="#" ><img src="<?= $item['img_url'] ?>" /><span> <?= $item['screen_name']; ?> </span></a></li>
                        <?php $count++;
                    endforeach; ?>
                </ul>
            </div>
            <div class="maincontent" id="maincontent"><!--微博内容-->

            </div>
        </div>
        <div class="footer"><!--下边栏-->
        </div>
    </body>
</html>
>>>>>>> .r4
