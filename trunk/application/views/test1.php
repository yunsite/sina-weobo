<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        foreach($user_info['statuses'] as $item)
            echo $item['text'].'<br/>';
        ?>
    </body>
</html>
