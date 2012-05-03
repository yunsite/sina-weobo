<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
<body>
<?php
        /*$pattern="/(http:\/\/tp[a-zA-Z0-9.\/]+)/";
        $url = "http://data.weibo.com/top/influence/famous"; 
        $contents = file_get_contents($url); 
        //如果出现中文乱码使用下面代码 
        //$getcontent = iconv("gb2312", "utf-8","GBK",$contents); 
        echo $contents; 
        if(preg_match_all($pattern, $contents, $matches,PREG_PATTERN_ORDER))  //如果能找到微博头像链接
        {
            foreach($matches[0] as $match)   //取出50条微博头像链接进行处理
            {
                echo $match.'<br/>';
                $res=explode("/",$match);  //以“/”为标志将头像链接分割
                echo $res[3].'<br/>';
                //$uid=1+$res[3]-1;    //$res[3]是字符串型的名人微博ID，此处将其处理为float型的$uid
                //$uer_info=$c->show_user_by_id($uid);
            }
        }*/
        
         

        $yesterday = date("Y-m-d", mktime(0, 0, 0,date("m"),date("d")-2,date("Y")));
        echo $yesterday.'<br/>';
        var_dump($yesterday);
        $a="2725806687";
        $b=1+$a-1;
        echo $b.'<br/>';
        var_dump($b);
        $uid=1192329374;
        $temp=$this->session->userdata('access_token'); 
        $c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$temp );
        $weibo=$c->user_timeline_by_id($uid);
        foreach($weibo['statuses'] as $item)
        {
            echo $item['id'].'<br/>';
            if (isset ($item['retweeted_status']))
            {
                echo $item['retweeted_status']['user']['id'].'<br/>';
                echo $item['retweeted_status']['user']['screen_name'].'<br/>';
            }
        }
        
?>
    <a target=:_blank' href="http://192.168.8.79/celebritytop/index.php/db_update" _target="blank"> 更新数据库</a>
</body>
        </html>