<?php
class Celtop_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    //以SQL语句的形式查询数据库
    public function get_weibo_sql($sql)
    {
        $query=$this->db->query($sql);
        return $query->result_array();
    }
    
    //向数据表user_day中插入数据
    public function set_user_day($uid,$screen_name,$img_url)
    {
        $data=array
        (
            'id'=>'', //序号，当天名次
            'uid'=>$uid, //名人微博ID
            'screen_name'=>$screen_name,  //名人微博昵称
            'img_url'=>$img_url    //名人微博头像链接
        );
        return $this->db->insert('user_day',$data);
    }
    
    //向数据表weibo中插入数据
    public function set_weibo($cel_uid,$created_at,$txt,$weibo_mid,$repost_count,$comment_count,$retweeted_uid,$retweeted_screen_name,$retweeted_txt,$sum_rep_comm)
    {
        $data=array
        (
            'id'=>'',
            'cel_uid'=>$cel_uid, //名人微博ID
            'created_at'=>$created_at,  //微博发布时间
            'txt'=>$txt,  //微博内容
            'weibo_mid'=>$weibo_mid,  //微博ID
            'repost_count'=>$repost_count,  //转发数量
            'comment_count'=>$comment_count,  //评论数量
            'retweeted_uid'=>$retweeted_uid,   //如果有原微博，原微博博主ID
            'retweeted_screen_name'=>$retweeted_screen_name,  //原博主昵称
            'retweeted_txt'=>$retweeted_txt,  //原微博内容
            'sum_rep_comm'=>$sum_rep_comm  //转发和评论数量之和
        );
        return $this->db->insert('weibo',$data);
    }
    
    //向数据表user_total中插入数据
    public function set_user_total($uid,$screen_name,$img_url,$date_rank)
    {
        $data=array
        (
            'id'=>'',
            'uid'=>$uid,
            'screen_name'=>$screen_name,
            'date_rank'=>$date_rank
        );
        return $this->db->insert('user_total',$data);
    }
    
    
    //以SQL形式查询数据库
    public function get_by_sql($sql)
    {
        $query=$this->db->query($sql);
        return $query->result_array();
    }

    //从数据表user_day中取数据
    public function get_user_day($sheet_name='user_day',$uid=FALSE)
    {
         if($uid == FALSE)
         {
            $query=$this->db->get($sheet_name);
            return $query->result_array();
         }
         $query=$this->db->get_where($sheet_name,array('uid'=>$uid));
         return $query->result_array();
    }
    
    //从数据表weibo中取数据
    public function get_weibo($sheet_name,$cel_uid=FALSE)
    {
        if ($uid == FALSE)
        {
            $query=$this->db->get($sheet_name);
            return $query->result_array();
        }
        $query=$this->db->get_where($sheet_name,array('cel_uid'=>$cel_uid));
        return $query->result_array();
    }
}
?>
