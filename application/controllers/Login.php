<?php
class Login extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('User_model','umodel');
		$this->load->library('jsonformat');
	}
	/*public function index(){
		$this->load->model('user_model','user');
		$this->user->getALL();
		$redis=new Redis();
		$redis->connect('127.0.0.1',6379);
		$redis->setbit('setbitjxb:3:sid:1637759:week:16',7,0);
		var_dump($redis);
		if($_SESSION['uid']==1){
			 redirect('sir/index');
		}else if($_SESSION['uid']==2){
			redirect('stu/index');
		}else{
			$this->load->view('hosystem/ho_login');
		}
	}*/
	public function quit(){
		header('Access-Control-Allow-Origin: *');
		$_SESSION=array();
		$this->session->sess_destroy();
		if(isset($_COOKIE[session_name()])){
			setcookie(session_name(),'',time()-4200,'/');
		}
		$this->jsonformat->show(200,'destroy succesfull',array('sessionid'=>$_SESSION));
	}
	//这里的id就是他们的ID，数据库里的.
	public function isValid(){
		error_reporting(0);
		header('Access-Control-Allow-Origin: *');
		$username=$this->input->post('username',true);
		$password=$this->input->post('password',true);
		$flag=$this->input->post('sirstu',true);
		$result=$this->umodel->getPwd($flag,$username);
		if($result['password']==md5($password)){
		if($flag==1){
		$_SESSION['id']=$result['tid'];
	    }else{
	    $_SESSION['id']=$result['sid'];
	    }
	    //echo $_SESSION['id'];
		$this->jsonformat->show(200,'success',array('sessionid'=>$_SESSION['id']));

		}else{
			$this->jsonformat->show(404,'faild');
		}
	}
	
	public function inSert(){
		header('Access-Control-Allow-Origin: *');
		$username=$this->input->post('username',true);
		$password=$this->input->post('password',true);
		$gender=$this->input->post('gender',true);
		$introduce=$this->input->post('introduce',true);
		$flag=$this->input->post('sirstu',true);
		$realname=$this->input->post('realname',true);
		switch($flag)
		{
		   case 1:
		   $res=$this->umodel->insertTeacher($username,$password,$gender,$introduce,$realname);
		   if($res==true){
			 $this->jsonformat->show(200,'success',1);  
		   }else{
			 $this->jsonformat->show(200,'faild',0);   
		   }
		   break;
		   case 2:
		   $res=$this->umodel->insertStudent($username,$password,$gender,$introduce,$realname);
		   if($res==true){
			 $this->jsonformat->show(200,'success',1);  
		   }else{
			 $this->jsonformat->show(200,'faild',0);   
		   }
		   break;
		}
	}
}
?>