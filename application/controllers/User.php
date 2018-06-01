<?php
class User extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('user_model','mclass');
		$this->load->library('jsonformat');
		$this->load->library('session');
		header('Access-Control-Allow-Origin: *');
		error_reporting(0);
	}
	//修改个人信息用的
	public function perInfo(){
		$flag=$this->uri->segment(3);
		$id=$_SESSION['id'];
		if($flag==2){
		$query="select name,realname,gender,selfintro from student where sid=?";
        }else if($flag==1){
        	$query="select name,realname,gender,selfintro from teacher where tid=?";
        }
       $res=$this->db->query($query,array($id));
       $res=$res->row_array();
       $this->jsonformat->show(200,'ok',$res);
	}
	public function modiSelf(){
		$flag=$this->input->post('flag',true);
		$id=$_SESSION['id'];
		$gender=$this->input->post('gender',true);
		$realname=$this->input->post('realname',true);
		$selfintro=$this->input->post('selfintro',true);
		$name=$this->input->post('name');
		$res=$this->mclass->getUser($flag,$name);
		if($res)
		$name='';
		if($gender)
		$array['gender']=$gender;
	    if($realname)
		$array['realname']=$realname;
	    if($selfintro)
		$array['selfintro']=$selfintro;
	    if($name)
		$array['name']=$name;
		$res=$this->mclass->modSeflin($id,$flag,$array);
		if($res){
			$this->jsonformat->show(200,'ok');
		}else{
			$this->jsonformat->show(201,'not ok');
		}
	}
}
?>