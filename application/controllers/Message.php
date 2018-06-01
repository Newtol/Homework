<?php
class Message extends CI_controller{
	public function __construct(){
		parent::__construct();
				$this->load->database();
		$this->load->model('Mess_model','mesmodel');
		$this->load->library('session');
		$this->load->library('jsonformat');
		header('Access-Control-Allow-Origin: *');
		error_reporting(0);
	}
	public function getMess(){
		error_reporting(0);
		$id=$_SESSION['id'];
		$total=$this->mesmodel->countMess($id);
		$pagesize=7;
		$page=intval($this->uri->segment(3));
		if($total%$pagesize==0){
			$pagecount=intval($total/$pagesize);
		}else{
	
			$pagecount=ceil($total/$pagesize);
		}
	
		if($page>$pagecount)
			//$page=$pagecount;
			return $this->jsonformat->show(200,'ok',NULL);
		if($page==0)
			$page=1;
		$data=$this->mesmodel->getMess($page,$id);
        
		$this->jsonformat->show(200,'ok',$data);
	}
    public function getMesste(){
		error_reporting(0);
		$id=$_SESSION['id'];
		$total=$this->mesmodel->countMesste($id);
		$pagesize=7;
		$page=intval($this->uri->segment(3));
		if($total%$pagesize==0){
			$pagecount=intval($total/$pagesize);
		}else{
	
			$pagecount=ceil($total/$pagesize);
		}
	
		if($page>$pagecount)
			//$page=$pagecount;
			return $this->jsonformat->show(200,'ok',NULL);
		if($page==0)
			$page=1;
		$data=$this->mesmodel->getMesste($page,$id);
        
		$this->jsonformat->show(200,'ok',$data);
	}
    public function getDetail(){
    	error_reporting(0);
		$mid=$this->uri->segment(3);
		$data=$this->mesmodel->getDetail($mid);
		if($data){
		$this->jsonformat->show(200,'ok',$data);
	    }else{
	    $this->jsonformat->show(201,'not ok');
    	}
	}
	public function postMessage(){
		error_reporting(0);
		$type=$this->input->post('type',true);
		$id=$this->input->post('id',true);
		$content=$this->input->post('content',true);
		//echo "sid:"+$_SESSION['id'];
		if($type=='class'){
			$ids=$this->mesmodel->getIds($id);
			foreach($ids as $value){
			$this->mesmodel->postMess($_SESSION['id'],$value['sid'],$content);
			}
		}else{
			$this->mesmodel->postMess($_SESSION['id'],$id,$content);
		}
		$this->jsonformat->show(200,'ok',$data);
	}
}
?>