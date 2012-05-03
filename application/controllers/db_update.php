<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Db_update extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('celtop_model');
    }
    
    public function midToStr($mid) {   //将mid转化成短字符串的形式
	settype($mid, 'string');
	$mid_length = strlen($mid);
	$url = '';
	$str = strrev($mid);
	$str = str_split($str, 7);
 
	foreach ($str as $v) {
		$char = $this->intTo62(strrev($v));
		$char = str_pad($char, 4, "0");
		$url .= $char;
	}
	$url_str = strrev($url);
	return ltrim($url_str, '0');
    }

    public function str62keys_int_62($key) //62进制字典
    {
        $str62keys = array (
            "0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q",
            "r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q",
            "R","S","T","U","V","W","X","Y","Z"
        );
        return $str62keys[$key];
    }

    /* url 10 进制 转62进制*/

    public function intTo62($int10) {
        $s62 = '';
        $r = 0;
        while ($int10 != 0) {
            $r = $int10 % 62;
            $s62 .= $this->str62keys_int_62($r);
            $int10 = floor($int10 / 62);
        }
        return $s62;
    }
    
    public function index()
    {
        $pattern="/(http:\/\/tp[a-zA-Z0-9.\/]+)/";  //匹配网页中的微博头像链接
        $url = "http://data.weibo.com/top/influence/famous";   //名人影响力排行榜官方主页
        $contents = file_get_contents($url);    //抓取页面
        //如果出现中文乱码使用下面代码 
        //$getcontent = iconv("gb2312", "utf-8","GBK",$contents); 
        
        $temp=$this->session->userdata('access_token');  //从session中获取access_token
        if ( empty($temp))   //如果用户没登陆
        {
            $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
            $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
            echo "<meta http-equiv=refresh content='0; url=$code_url'>";  //跳转到授权页面
        }
        else
        {
            $c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$temp );
            //向user_day中写数据之前先清空前一天的数据
            $this->db->query('truncate table user_day'); 
            
            //向weibo表中写数据之前先清空前一天的数据
            $this->db->query('truncate table weibo'); 
            
            if(preg_match_all($pattern, $contents, $matches,PREG_PATTERN_ORDER))  //如果能找到微博头像链接
            {
                for($i=0;$i<20;$i++)  //取出前20条微博头像链接进行处理
                {
                    $match=$matches[0][$i];
                    $res=explode("/",$match);  //以“/”为标志将头像链接分割
                    $uid=1+$res[3]-1;    //$res[3]是字符串型的名人微博ID，此处将其处理为float型的$uid
                    $user_info=$c->show_user_by_id($uid);   //获取用户信息
                    //$weibo=$c->user_timeline_by_id(array('uid'=>$uid,'count'=>100));  //取100条微博
                    $weibo=$c->user_timeline_by_id($uid,1,100);
                    
                    
                    //向数据表user_day中写入数据
                    $this->celtop_model->set_user_day($uid,$user_info['screen_name'],$match);  //$match即为用户的头像链接
                    
                    
                    //向数据表weibo中写数据
                    $weibo_info=$weibo['statuses'];
                    foreach ($weibo_info as $item)  //循环插入100条微博
                    {
                        $created_at=$item['created_at'];
                        $txt=$item['text'];
                        $weibo_mid= $this->midToStr($item['mid']);
                        //echo $weibo_mid;

                        $repost_count=$item['reposts_count'];  //转发量
                        $comment_count=$item['comments_count']; //评论量
                        $sum_rep_comm=$repost_count+$comment_count;  //转发与评论数量之和

                         if (isset ($item['retweeted_status']))  //如果有原创微博
                         {
                             if (isset ($item['retweeted_status']['user']))
                             {
                                 $retweeted_uid=$item['retweeted_status']['user']['id'];  //原博主ID
                                 $retweeted_screen_name=$item['retweeted_status']['user']['screen_name']; //原博主昵称
                             }
                             else
                             {
                                 $retweeted_uid='';
                                 $retweeted_screen_name='';
                             }
                             $retweeted_txt=$item['retweeted_status']['text'];   //原微博内容
                         }
                         else
                         {
                             $retweeted_uid='';
                             $retweeted_screen_name='';
                             $retweeted_txt='';
                         }
                         $this->celtop_model->set_weibo($uid,$created_at,$txt,$weibo_mid,$repost_count,$comment_count,$retweeted_uid,$retweeted_screen_name,$retweeted_txt,$sum_rep_comm);
                    }
                     //向数据表user_total中写入数据
                     $date_rank=date("Y-m-d", mktime(0, 0, 0,date("m"),date("d")-1,date("Y")));  //当前显示的是前一天的名人影响力排行
                     $this->celtop_model->set_user_total($uid,$user_info['screen_name'],$match,$date_rank);
                }
            }
        }
        echo "DB has been updated!";
        
    }
    
}
?>