<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>新浪微博PHP SDK V2版 Demo - Powered by Sina App Engine</title>
    </head>

    <body>

        <?php
        if ($flag == 'Y') {
            echo "登录成功。跳转中……";
            echo "<meta http-equiv=refresh content='0; url=".base_url()."index.php/homepage'>";
        } else {
            echo "授权失败。";
        }
        ?>
    </body>
</html>
