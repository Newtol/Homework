<?php
class Analy extends CI_Controller{
	public function __construct(){

		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->library('jsonformat');
		$this->load->model('analy_model','anmodel');
		error_reporting(0);
	}
	public function whenjoin(){
		$flag=$this->uri->segment(3);
		$id=$_SESSION['id'];
		$data=$this->anmodel->whenjoin($id,$flag);
		$this->jsonformat->show(200,'ok',$data);
	}
	public function whichHigh(){
		$data=$this->anmodel->whichHigh();
		$this->jsonformat->show(200,'ok',$data);
	}
	public function bestBad(){
		$id=$_SESSION['id'];
		$data=$this->anmodel->bestBad($id);
		$this->jsonformat->show(200,'ok',$data);
	}

	public function analyYear(){
		$ids=$this->anmodel->getStuids();//获取sid数组
		       //插入数据进analyyear表
		foreach ($ids as $key => $value) {
			$this->anmodel->analyYear($value['sid']);
		}
		
	}
}
?>