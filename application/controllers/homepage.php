<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Homepage extends CI_Controller {

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
            $user_info=$this->celtop_model->get_user_day();
            $data['user_info']=$user_info;
            $this->load->view('celebritytop/homepage_view',$data);
        }
    }

    

}

/* End of file navigate.php */
/* Location: ./application/controllers/navigate.php */