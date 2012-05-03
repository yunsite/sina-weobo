        <?php
        if (!defined('BASEPATH'))
            exit('No direct script access allowed');

        class Callback extends CI_Controller {

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
                $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY, null, null);

                if (isset($_REQUEST['code'])) {
                    $keys = array();
                    $keys['code'] = $_REQUEST['code'];
                    $keys['redirect_uri'] = WB_CALLBACK_URL;
                    try {
                        $token = $o->getAccessToken('code', $keys);
                        $data['token']=$token;
                    } catch (OAuthException $e) {
                        echo $e;
                    }
                }
                if (isset($token)) {
                    $this->session->set_userdata($token);  //设定Session，将$token写入session
                    $this->input->set_cookie('weibojs_' . $o->client_id, http_build_query($token));  //设定cookie
                    $data['flag']='Y';
                }
                else
                    $data['flag']='N';
                
                
                $data['o']=$o;
                
                
                $this->load->view('celebritytop/callback_view',$data);
            }

        }
        ?>
