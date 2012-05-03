<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Navigate extends CI_Controller {

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
    public function index() {

        $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
        $code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);
        $data['code_url'] = $code_url;

        $this->load->view('celebritytop/navigate_view', $data);
    }

    

}

/* End of file navigate.php */
/* Location: ./application/controllers/navigate.php */