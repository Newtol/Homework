<?php
class Homework extends CI_Controller{
	public function __construct(){
		parent::__construct();
		#$this->load->database();
		/*$this->load->model('Ho_model','hmodel');
		$this->load->library('session');
		$this->load->library('jsonformat');*/
		header('Access-Control-Allow-Origin: *');
		error_reporting(0);
	}
	//µ±Ç°Î´¹ýÆÚ×÷Òµ
	public function noDueHo(){
		$id=$_SESSION['id'];
		$res=$this->hmodel->noduHo($id);
		$this->jsonformat->show(200,'ok',$res);
	}
	//²¼ÖÃ×÷Òµ
    /*public function inAssign(){
		error_reporting(0);
		$percen=$this->input->post('percentage',true);
		$attachment=$this->input->post('attachment',true);
		$deadline=$this->input->post('deadline',true);
		//$pubtime=$this->input->post('pubtime',true);
		$addtion=$this->input->post('addtion',true);
		$jid=$this->input->post('jid',true);
		$res=$this->hmodel->inAssign($percen,$attachment,$deadline,$addtion,$jid);
		if($res==true){
			$this->jsonformat->show(200,'ok');
		}else{
			$this->jsonformat->show(201,'not ok');
		}
	}*/
	//Òª´«ÈëÀÏÊ¦µÄID£¬²é¿´Î´¹ýÆÚ×÷ÒµÖÐÄ³¸ö½ÌÑ§°àÍê³É¡¢Î´Íê³É¡¢Íê³Éµ«Î´Åú¸ÄÊýÁ¿
	public function hoDetail(){
		$asid=$this->uri->segment(3);
		$asid=intval($asid);
		$cid=$this->uri->segment(4);
		$cid=intval($cid);
		$data=$this->hmodel->hoDetail($asid,$cid);
		if($data)
		$this->jsonformat->show(200,'ok',$data);
	}

	//ÀÏÊ¦²é¿´Ä³ÈËÌá½»¹ýµÄ×÷Òµ
	public function hoPerson(){
		$asid=intval($this->uri->segment(3));
		$sid=intval($this->uri->segment(4));
		$data=$this->hmodel->hoPerson($asid,$sid);
		if($data){
		$this->jsonformat->show(200,'ok',$data);
	    }else{
	    $this->jsonformat->show(201,'not commit',$data);
	    }
	}
	//¸ø×÷Òµ´ò³É¼¨£¬Ð´ÅúÓï£¬¸ù¾Ý²¼ÖÃ×÷ÒµµÄasidºÍÑ§ºÅ
	public function hoJudge(){
		$grade=$this->input->post('grade',true);
		$addtion=$this->input->post('addtion',true);
		$asid=$this->input->post('asid',true);
		$sid=$this->input->post('sid',true);
		$result=$this->hmodel->hoAdetail($asid);
		$percen=$result['percentage'];
		$total=$result['total'];
		$jid=$result['jid'];
		// $percen=$this->input->post('percen',true);
		// $percen=$this->input->post('total',true);
		/*批改*/$res=$this->hmodel->hoJudge($grade,$addtion,$asid,$sid);
		/*查看有无成绩*/$res1=$this->hmodel->getGrade($jid,$sid);  //看grade
		$grade=$this->hmodel->getGrade2($asid,$sid);
		/*之所以要再查询一遍成绩，是为了利用enum的特性*/
		$grade=$grade['grade']*1.0/8;
		/*ÕâÀï×ª»»ENUMºÍÊý×Ö*/
	
          //$res1['grade']=$res1['grade']==NULL?0:1;
       
		if(!$res1){
		    		$res=$this->hmodel->inGrade2($percen,$jid,$sid,$grade);
	    }else{
	
	    $res=$this->hmodel->inTotal($percen,$sid,$jid,$grade,$total);
		}
		if($res==true){
			$this->jsonformat->show(200,'ok');
		}else{
			$this->jsonformat->show(201,'not ok');
		}
	
	}
	//²é¿´Ä³ÈË£¬Ä³¸ö¿Î³ÌµÄ³É¼¨
	public function getGrade(){
		$jid=$this->uri->segment(3);
		$sid=$this->uri->segment(4);
		$data=$this->hmodel->getGrade($jid,$sid);
		if($data){
	    $this->jsonformat->show(200,'ok',$data);
	    }else{
		$this->jsonformat->show(201,'not ok');
	    }
	}
	//Ñ§Éú»ñÈ¡¸÷¿Î³ÌÐÅÏ¢£¬ÒÑ»ñµÃÆ½Ê±³É¼¨¼°×÷Òµ¼ÇÂ¼Í³¼Æ
	public function getStatistc(){
		$jid=$this->uri->segment(3);
		$sid=$this->uri->segment(4);
		$data=$this->hmodel->getStatistics($jid,$sid);
		if($data){
			$this->jsonformat->show(200,'ok',$data);
		}else{
			$this->jsonformat->show(201,'not exists');
		}
	}
//²é¿´×î½üÎ´¹ýÆÚ×÷Òµ£¬»á·µ»Øasid,percentage,attachment,deadline,pubtime,addtionºÍisFinishµÈ×Ö¶ÎµÄÊý¾Ý
	public function getNodue(){
		//$jid=$this->uri->segment(3);
		$sid=$_SESSION['id'];
		$result=$this->hmodel->getNodue($sid);
		foreach($result as $key=>$value){
			$res=$this->hmodel->isFinish($value['asid'],$_SESSION['id']);
			$result[$key]['isFinish']=$res['count(*)'];
		}
		$this->jsonformat->show(200,'0k',$result);
	}
	//新加的
	public function getHo(){
		error_reporting(0);
		$sid=$_SESSION[id];
		$asid=$this->uri->segment(3);
		$data=$this->hmodel->getHo($asid,$sid);
		$this->jsonformat->show(200,'ok',$data);
	}
	//×ö×÷Òµ
	public function doHomework($asid,$attachment){
	//	$asid=$this->input->post('asid');
		//$sid=$_SESSION['id'];
	//	$attachment=$this->input->post('attachment');
		//echo "siiiiiiid:".$sid;
         //$sid=$this->input->post('sid',true);
         if($sid=$_SESSION[id]){

		}else
		$sid=$this->input->post('sid',true);
		$res=$this->hmodel->finiHomework($asid,$sid,$attachment);
		if($res){
			$this->jsonformat->show(200,'ok');
		}else{
			$this->jsonformat->show(202,'not ok');
		}
	}
//ÐÞ¸ÄÌá½»¹ýµÄ×÷Òµ.¿ØÖÆÆ÷Òª¼ÓÈç¹ûÀÏÊ¦Èç¹ûÐÞ¸Ä¹ýÁËµÄ»°£¬¾Í²»ÄÜÐÞ¸ÄÁË
	public function modiHomework($attachment,$asid){
		//$attachment=$this->input->post('attachment');
		//$asid=$this->input->post('asid');
		if($sid=$_SESSION[id]){

		}else
		$sid=$this->input->post('sid',true);

		$res=$this->hmodel->modiHomework($attachment,$asid,$sid);
		if($res==true){
			$this->jsonformat->show(200,'ok');
		}else{
			$this->jsonformat->show(201,'not ok');
		}
	}


	public function inAssign($percen,$attachment,$deadline,$addtion,$jid){
		error_reporting(0);
		$res=$this->hmodel->inAssign($percen,$attachment,$deadline,$addtion,$jid);
		if($res==true){
			$this->jsonformat->show(200,'ok');
		}else{
			$this->jsonformat->show(201,'not ok');
		}
	}
	//老师发布作业
	public function sirUpload(){
		error_reporting(0);
		//var_dump($_POST);
		$hz=array_pop(explode(".", $_FILES['file']['name']));
		$path="..";
		if(!is_uploaded_file($_FILES['file']['tmp_name'])){
			exit;
		}
		$filename=date("YmdHis").rand(100,999).".".$hz;
	    //var_dump($_FILES['file']);// $FILES['file']['tmp_name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $path."/sirattachment/".$filename);
		$attachment=$filename;
		$percen=$this->input->post('percentage',true);
		$deadline=$this->input->post('deadline',true);
		$addtion=$this->input->post('addtion',true);
		$jid=$this->input->post('jid',true);
		//echo $percen.$attachment,$deadline,$addtion,$jid;
		$this->inAssign($percen,$attachment,$deadline,$addtion,$jid);
	
	}
	//同学做作业
	public function stuUpload(){
		$flag=$this->uri->segment(3);
		error_reporting(0);
		//var_dump($_POST);
		$hz=array_pop(explode(".", $_FILES['file']['name']));
		$path="..";
		if(!is_uploaded_file($_FILES['file']['tmp_name'])){
			exit;
		}
		$filename=date("YmdHis").rand(100,999).".".$hz;
	    //var_dump($_FILES['file']);// $FILES['file']['tmp_name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $path."/stuattachment/".$filename);
		$attachment=$filename;
		$asid=$this->input->post('asid');
		//$deadline=$this->input->post('deadline',true);
		//$addtion=$this->input->post('addtion',true);
		//$jid=$this->input->post('jid',true);
		//echo $percen.$attachment,$deadline,$addtion,$jid;
		if($flag==1){

		$this->doHomework($asid,$attachment);
	    }else if($flag==2){
	    $this->modiHomework($attachment,$asid);
	    }
	}
	//文件下载的接口
	public function downLoad(){
		error_reporting(0);
		$filename=$this->uri->segment(3);
		$flag=$this->uri->segment(4);
      $this->hmodel->downLoad($filename,$flag);
	}

}