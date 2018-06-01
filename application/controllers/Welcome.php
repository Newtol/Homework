<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function cookie()
	{
		$this->load->helper("url");
		$this->load->library("session");
		$_SESSION['name']="苏丹";
	}
	public function seecookie(){
		$this->load->library("session");
		echo "cookie里的值为".$this->session->name;
	}

	public function upload(){
		header('Access-Control-Allow-Origin: *');
      
		echo '{"status": 200, "message": "success", "data": {"localaddr": "./files/99e31068-7a79-11e7-b86a-525400b2347eSHBackendWEB1-07-21-10-33-20-Log1.zip", "sampleid": "99e31068-7a79-11e7-b86a-525400b2347e","ostype":"windows"}}';
	}
	public function analy(){
				header('Access-Control-Allow-Origin: *');
		        
				echo '{"status": 200, "message": "analsis over", "data": null}';
	}
	public function getreport(){
				header('Access-Control-Allow-Origin: *');
		        
				echo '{"status": 200, "message": "success", "data": {"donetime": "2017-08-05 13:43:33", "txt": "\u7cfb\u7edf\u4fe1\u606f\u68c0\u67e5:\u6210\u529f|\u8fdb\u7a0b\u4fe1\u606f\u68c0\u67e5:\u5931\u8d25|\u9a71\u52a8\u4fe1\u606f\u68c0\u67e5:\u6210\u529f|\u7cfb\u7edf\u68c0\u67e52:\u6210\u529f|"}}';
	}
	
	
}
