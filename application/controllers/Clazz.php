<?php
class Clazz extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('class_model','mclass');
		$this->load->library('jsonformat');
		header('Access-Control-Allow-Origin: *');
		error_reporting(0);
		//$this->
	}
	//传老师ID,这里应把id存进session.实现功能，查看以驻班班级
	public function haveClass(){
		$id=$_SESSION['id'];
		$data=$this->mclass->getAdminclass($id);
		if($data){
			$this->jsonformat->show(200,'exist',$data);
		}else{
	
			$this->jsonformat->show(201,'not exist',$data);
		}
	}
	//传班级ID，获取班级的成员信息
	public function oneClass(){
		$id=$this->uri->segment(3);
		$data=$this->mclass->getClass($id);
	    if($data){
			$this->jsonformat->show(200,'exist',$data);
		}else{
			$this->jsonformat->show(201,'not exist',$data);
		}	
		
	}
	//传班级ID，查看班级信息以便老师同学加入
	public function serClass(){
		$id=$this->uri->segment(3);
		$data=$this->mclass->serClass($id);
		if($data){
			$this->jsonformat->show(200,'exist',$data);
		}else{
			$this->jsonformat->show(201,'no exist',$data);
		}
	}
	//进驻某个班级，这里要传cid,coure,addtion
	/*public function adminClass(){
        $cid=$this->input->post('cid',true);
        $course=$this->input->post('course',true);
        $addtion=$this->input->post('addtion',true);
		$tid=$this->input->post('tid',true);
		$res=$this->mclass->adminClass($tid,$cid,$course,$addtion);
		if($res==true){
			 $this->jsonformat->show(200,'success',1);  
		}else{
			 $this->jsonformat->show(200,'faild',0);   
		}
	}*/
	//学生查看加入的班级
	public function inClass(){
		error_reporting(0);
		$sid=$_SESSION['id'];
		$data=$this->mclass->inClass($sid);
		foreach($data as $key=>$value){
			if($value['creator']==$sid){
			$data[$key]['creator']=ture;
            }else{
            $data[$key]['creator']=false;
            }
		}
		$this->jsonformat->show(200,'ok',$data);
	}

       public function inCourse(){
       	
		$sid=$_SESSION['id'];
		$data=$this->mclass->inCourse($sid);
		$this->jsonformat->show(200,'ok',$data);
	}
	//查看申请
	public function showApply(){
		$cid=$this->uri->segment(3);
		$data['teach']=$this->mclass->showApply1($cid);
		$data['stu']=$this->mclass->showApply2($cid);
		$this->jsonformat->show(200,'ok',$data);
	}
	//同意申请
	public function okApply(){
		$type=$this->uri->segment(3);
		if($type==1){
	    $cid=$this->input->post('cid',true);
        $course=$this->input->post('course',true);
        $addtion=$this->input->post('addtion',true);
		$tid=$this->input->post('tid',true);
		$total=$this->input->post('total',true);
		$apid=$tid;
		$type='sir';
		$this->mclass->adminClass($tid,$cid,$course,$addtion,$total);
		$this->jsonformat->show(200,'succssfully',null);
		}
	    if($type==2){
		$cid=$this->input->post('cid',true);
     	$sid=$this->input->post('sid',true);
		$this->mclass->joinclass($sid,$cid);
		$apid=$sid;
		$type='stu';
		$this->jsonformat->show(200,'succssfully',null);
	    }
		$this->mclass->doneApply($apid,$type,$cid);
	}
	// 拒绝申请
	public function defuseApply(){
		$apid=$this->input->post('apid',true);
		$type=$this->input->post('sirorstu',true);
		$cid=$this->input->post('cid',true);
		$this->mclass->doneApply($apid,$type,$cid);
		$this->jsonformat->show(200,'succssfully',null);
	}
	//创建班级信息
	public function creaClass(){
		$name=$this->input->post('name');
	    $creator=$_SESSION['id'];
		$description=$this->input->post('description');
		$this->mclass->creaClass($name,$creator,$description);
		$this->jsonformat->show(200,'succssfully',null);
		
	}
	//修改班级信息
	public function modiClass(){
		$cid=$this->input->post('cid');
		$name=$this->input->post('name');
		$description=$this->input->post('description');
		$this->mclass->modiClass($cid,$name,$description);
		$this->jsonformat->show(200,'succssfully',null);

	}
	//申请加入某班，管理某班
	public function appClass(){
		$apid=$_SESSION['id'];
		$cid=$this->input->post('cid');
		$sirorstu=$this->input->post('sirorstu');
		$course=$this->input->post('course');
		$addtion=$this->input->post('addtion');
		$total=$this->input->post('total');
		$this->mclass->appClass($apid,$cid,$sirorstu,$course,$addtion,$total);
		$this->jsonformat->show(200,'succssfully',null);
	}
	
}
?>