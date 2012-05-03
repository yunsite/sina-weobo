<<<<<<< .mine
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax_serv extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
     public function __construct()
    {
        parent::__construct();
        $this->load->model('celtop_model');
    }
    
    public function index()
    {
        $temp=$this->session->userdata('access_token');
        if ( empty($temp))   //如果用户没登陆
        {
            $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
            $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
            echo "<meta http-equiv=refresh content='0; url=$code_url'>";  //跳转到授权页面
        }
        else
        {
            $c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$temp );
            $value=$this->input->get("value");   //从get类型的Ajax请求中获取参数"value"
            //$value=$_GET['value'];
            $sql="SELECT * FROM weibo JOIN user_day 
                ON user_day.uid = weibo.cel_uid 
                WHERE user_day.id =".intval($value)." 
                    ORDER BY sum_rep_comm DESC , CAST( created_at AS DATETIME ) DESC 
                    LIMIT 0 , 15";  //从weibo数据表中取出前十条按照时间和转发与评论总量排序的微博
            $weibo_info=$this->celtop_model->get_by_sql($sql);
            if ( ! empty ($weibo_info))
            {
                //将读取的微博里的短链接转化成超链接
                $pattern_url="/(http:\/\/[a-zA-Z0-9.\/]+)/";  //匹配短链接的正则表达式
                $pattern_at="|(@[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+)|u";        //匹配@某用户的正则表达式
                foreach ($weibo_info as &$item)
                {
                    //将每一条微博中的短链接转化为超链接形式
                    if(preg_match_all($pattern_url, $item['txt'], $matches,PREG_PATTERN_ORDER))  //如果能找到短链接
                    {
                        foreach($matches[0] as $match)   //将该微博内容中的每一条短链接转化成超链接
                        {
                            $replace="<a style='text-decoration:none'  target=:_blank' href=".$match.">".$match."<a/>";    //完整的超链接
                            $item['txt']=str_replace($match, $replace, $item['txt']);   //用超链接替换博文中的短链接
                        }
                    }
                    
                    //如果非原创微博，则把原微博中的短链接转化为超链接形式
                    if( ! empty($item['retweeted_uid']))
                    {
                        if(preg_match_all($pattern_url, $item['retweeted_txt'], $matches,PREG_PATTERN_ORDER))
                        {
                            foreach($matches[0] as $match)
                            {
                                $replace="<a style='text-decoration:none' target:'_blank' href=".$match.">".$match."<a/>";
                                $item['retweeted_txt']=str_ireplace($match, $replace, $item['retweeted_txt']);
                            }
                        }
                    }
                    
                    //将微博中的@用户信息转化为超链接形式
                    if(preg_match_all($pattern_at, $item['txt'], $matches,PREG_PATTERN_ORDER))  //如果存在@信息
                    {
                        foreach($matches[0] as $match)   //将该微博内容中的每一条@信息接转化成超链接
                        {
                            $name=strtok($match, "@");  //将用户昵称识别出来
                            $user_infomation=$c->show_user_by_name( $name );   //以用户昵称为参数调用接口获取用户信息
                            $replace="<a style='text-decoration:none' target=:_blank' href=http://weibo.com/u/".(string)$user_infomation['id'].">@".$name."&nbsp<a/>";    //完整的超链接
                            $item['txt']=str_replace($match, $replace, $item['txt']);   //用超链接替换博文中的@信息
                        }
                    }
                    
                    //如果非原创微博，则把原微博中的@用户信息转化为超链接形式
                    if( ! empty($item['retweeted_uid']))
                    {
                        if(preg_match_all($pattern_at, $item['retweeted_txt'], $matches,PREG_PATTERN_ORDER))  //如果存在@信息
                        {
                            foreach($matches[0] as $match)   //将该微博内容中的每一条@信息接转化成超链接
                            {
                                $name=strtok($match, "@");  //将用户昵称识别出来
                                $user_infomation=$c->show_user_by_name( $name );   //以用户昵称为参数调用接口获取用户信息
                                $replace="<a style='text-decoration:none' target:'_blank' href=http://weibo.com/u/".(string)$user_infomation['id'].">@".$name."&nbsp<a/>";    //完整的超链接
                                $item['retweeted_txt']=str_replace($match, $replace, $item['retweeted_txt']);   //用超链接替换博文中的@信息
                            }
                        }
                    }
                }
                //生成response
                $result="
                    <ul>
                        <li id='litopbackground'></li>";
                foreach ($weibo_info as $item)
                {
                    $result.="
                        <li>
                        <div class='content'>
                        ".$item['txt'];
                    if( ! empty($item['retweeted_uid']))
                    {
                        $result.="<div class='subcontent'>".$item['retweeted_txt'].'</div>';
                    }
                    $result.="
                        <p>
                        <span >
                            <a target='_blank' href='http://www.weibo.com/".(string)$item['cel_uid']."/".$item['weibo_mid']."'>转发(".$item['repost_count'].")</a>
                            <b style='margin:0 5px; color: #E6E6E6;'>|</b>
                            <a target='_blank' href='http://www.weibo.com/".(string)$item['cel_uid']."/".$item['weibo_mid']."'>评论(".$item['comment_count'].")</a>
                        </span>".
                        date("m",strtotime($item['created_at']))."月".date("d",strtotime($item['created_at']))."日&nbsp".date("H",strtotime($item['created_at'])).":".date("m",strtotime($item['created_at']))
                    ."</p>
                    </div>
                    <div class='line'></div>
                    </li>";
                }
                $result.="
                    <li id='libottombackground'></li>
                </ul>";
                $response=array(
                    'code'=>200,
                    'tip'=>"成功",
                    'result'=>$result
                );
            }
            else
            {
                $response=array(
                    'code'=>404,
                    'tip'=>"页面请求失败",
                    'result'=>"请求的页面未找到"
                );
            }
            echo json_encode($response);
        }
    }

    

}
    

/* End of file ajax_serv.php */
/* Location: ./application/controllers/ajax_serv.php */=======
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax_serv extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
     public function __construct()
    {
        parent::__construct();
        $this->load->model('celtop_model');
    }
    
    public function index()
    {
        $temp=$this->session->userdata('access_token');
        if ( empty($temp))   //如果用户没登陆
        {
            $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
            $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
            echo "<meta http-equiv=refresh content='0; url=$code_url'>";  //跳转到授权页面
        }
        else
        {
            $c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$temp );
            $value=$this->input->get("value");   //从get类型的Ajax请求中获取参数"value"
            //$value=$_GET['value'];
            $sql="SELECT * FROM weibo JOIN user_day 
                ON user_day.uid = weibo.cel_uid 
                WHERE user_day.id =".intval($value)." 
                    ORDER BY sum_rep_comm DESC , CAST( created_at AS DATETIME ) DESC 
                    LIMIT 0 , 15";  //从weibo数据表中取出前十条按照时间和转发与评论总量排序的微博
            $weibo_info=$this->celtop_model->get_by_sql($sql);
            if ( ! empty ($weibo_info))
            {
                //将读取的微博里的短链接转化成超链接
                $pattern_url="/(http:\/\/[a-zA-Z0-9.\/]+)/";  //匹配短链接的正则表达式
                $pattern_at="|(@[\x{4e00}-\x{9fa5}A-Za-z0-9_-]+)|u";        //匹配@某用户的正则表达式
                foreach ($weibo_info as &$item)
                {
                    //将每一条微博中的短链接转化为超链接形式
                    if(preg_match_all($pattern_url, $item['txt'], $matches,PREG_PATTERN_ORDER))  //如果能找到短链接
                    {
                        foreach($matches[0] as $match)   //将该微博内容中的每一条短链接转化成超链接
                        {
                            $replace="<a style='text-decoration:none'  target=:_blank' href=".$match.">".$match."<a/>";    //完整的超链接
                            $item['txt']=str_replace($match, $replace, $item['txt']);   //用超链接替换博文中的短链接
                        }
                    }
                    
                    //如果非原创微博，则把原微博中的短链接转化为超链接形式
                    if( ! empty($item['retweeted_uid']))
                    {
                        if(preg_match_all($pattern_url, $item['retweeted_txt'], $matches,PREG_PATTERN_ORDER))
                        {
                            foreach($matches[0] as $match)
                            {
                                $replace="<a style='text-decoration:none' target:'_blank' href=".$match.">".$match."<a/>";
                                $item['retweeted_txt']=str_ireplace($match, $replace, $item['retweeted_txt']);
                            }
                        }
                    }
                    
                    //将微博中的@用户信息转化为超链接形式
                    if(preg_match_all($pattern_at, $item['txt'], $matches,PREG_PATTERN_ORDER))  //如果存在@信息
                    {
                        foreach($matches[0] as $match)   //将该微博内容中的每一条@信息接转化成超链接
                        {
                            $name=strtok($match, "@");  //将用户昵称识别出来
                            $user_infomation=$c->show_user_by_name( $name );   //以用户昵称为参数调用接口获取用户信息
                            $replace="<a style='text-decoration:none' target=:_blank' href=http://weibo.com/u/".(string)$user_infomation['id'].">@".$name."&nbsp<a/>";    //完整的超链接
                            $item['txt']=str_replace($match, $replace, $item['txt']);   //用超链接替换博文中的@信息
                        }
                    }
                    
                    //如果非原创微博，则把原微博中的@用户信息转化为超链接形式
                    if( ! empty($item['retweeted_uid']))
                    {
                        if(preg_match_all($pattern_at, $item['retweeted_txt'], $matches,PREG_PATTERN_ORDER))  //如果存在@信息
                        {
                            foreach($matches[0] as $match)   //将该微博内容中的每一条@信息接转化成超链接
                            {
                                $name=strtok($match, "@");  //将用户昵称识别出来
                                $user_infomation=$c->show_user_by_name( $name );   //以用户昵称为参数调用接口获取用户信息
                                $replace="<a style='text-decoration:none' target:'_blank' href=http://weibo.com/u/".(string)$user_infomation['id'].">@".$name."&nbsp<a/>";    //完整的超链接
                                $item['retweeted_txt']=str_replace($match, $replace, $item['retweeted_txt']);   //用超链接替换博文中的@信息
                            }
                        }
                    }
                }

               /* //如果是非原创微博，则将原微博中的短链接也转化成超链接
                if( ! empty($weibo_info['retweeted_uid']))
                {
                    foreach ($weibo_info as &$item) 
                    {
                        if(preg_match_all($pattern_url, $item['retweeted_txt'], $matches,PREG_PATTERN_ORDER))
                        {
                            foreach($matches[0] as $match)
                            {
                                $replace="<a style='text-decoration:none' target:'_blank' href=".$match.">".$match."<a/>";
                                $item['retweeted_txt']=str_ireplace($match, $replace, $item['retweeted_txt']);
                            }
                        }
                    }
                }//解析短链接结束

                //将读取的微博中有@到某一用户的信息转化成超链接
                
                foreach($weibo_info as &$item)
                {
                    if(preg_match_all($pattern_at, $item['txt'], $matches,PREG_PATTERN_ORDER))  //如果存在@信息
                    {
                        foreach($matches[0] as $match)   //将该微博内容中的每一条@信息接转化成超链接
                        {
                            $name=strtok($match, "@");  //将用户昵称识别出来
                            $user_infomation=$c->show_user_by_name( $name );   //以用户昵称为参数调用接口获取用户信息
                            $replace="<a style='text-decoration:none' target=:_blank' href=http://weibo.com/u/".(string)$user_infomation['id'].">@".$name."&nbsp<a/>";    //完整的超链接
                            $item['txt']=str_replace($match, $replace, $item['txt']);   //用超链接替换博文中的@信息
                        }
                    }
                 }
                if( ! empty($weibo_info['retweeted_txt']))
                {
                    foreach($weibo_info as &$item)
                    {
                        if(preg_match_all($pattern_at, $item['retweeted_txt'], $matches,PREG_PATTERN_ORDER))  //如果存在@信息
                        {
                            foreach($matches[0] as $match)   //将该微博内容中的每一条@信息接转化成超链接
                            {
                                $name=strtok($match, "@");  //将用户昵称识别出来
                                echo $name.'<br/>';
                                $user_infomation=$c->show_user_by_name( $name );   //以用户昵称为参数调用接口获取用户信息
                                $replace="<a style='text-decoration:none' target:'_blank' href=http://weibo.com/u/".(string)$user_infomation['id'].">@".$name."&nbsp<a/>";    //完整的超链接
                                $item['retweeted_txt']=str_replace($match, $replace, $item['retweeted_txt']);   //用超链接替换博文中的@信息
                            }
                        }
                     }
                }//解析@结束*/
                $response="
                    <ul>
                        <li id='litopbackground'></li>";
                foreach ($weibo_info as $item)
                {
                    $response.="
                        <li>
                        <div class='content'>
                        ".$item['txt'];
                    if( ! empty($item['retweeted_uid']))
                    {
                        $response.="<div class='subcontent'>".$item['retweeted_txt'].'</div>';
                    }
                    $response.="
                        <p>
                        <span >
                            <a target='_blank' href='http://www.weibo.com/".(string)$item['cel_uid']."/".$item['weibo_mid']."'>转发(".$item['repost_count'].")</a>
                            <b style='margin:0 5px; color: #E6E6E6;'>|</b>
                            <a target='_blank' href='http://www.weibo.com/".(string)$item['cel_uid']."/".$item['weibo_mid']."'>评论(".$item['comment_count'].")</a>
                        </span>".
                        date("m",strtotime($item['created_at']))."月".date("d",strtotime($item['created_at']))."日&nbsp".date("H",strtotime($item['created_at'])).":".date("m",strtotime($item['created_at']))
                    ."</p>
                    </div>
                    <div class='line'></div>
                    </li>";
                }
                $response.="
                    <li id='libottombackground'></li>
                </ul>";
            }
            else
            {
                $response="Can't find that page!";
            }
            echo $response;
        }
    }

    

}
    

/* End of file ajax_serv.php */
/* Location: ./application/controllers/ajax_serv.php */>>>>>>> .r4
