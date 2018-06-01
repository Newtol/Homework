<?php
class Ho_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
 //ÀÏÊ¦²¼ÖÃ×÷Òµ
	public function inAssign($percen,$attachment,$deadline,$addtion,$jid){
		$array=array('asid'=>null,'percentage'=>$percen,'attachement'=>$attachment,'deadline'=>$deadline,'pubtime'=>date('y-m-d h:i:s',time()),'addtion'=>$addtion,'jid'=>$jid);
		$this->db->insert('assign',$array);
		if(!mysql_insert_id())
		return false;
        return true;
	}
	//Òª´«ÈëÀÏÊ¦µÄID,²é¿´Î´¹ýÆÚ×÷Òµ
	public function noduHo($id){
		$id=intval($id);
		$query="select asid,jx_class.cid cid,percentage,attachement,deadline,course,name from assign inner join jx_class inner join class on assign.jid=jx_class.jid and jx_class.cid=class.cid where jx_class.tid=? and deadline>now()";
		$res=$this->db->query($query,array($id));
		return $res->result_array();
	}
	//Òª´«ÈëÀÏÊ¦µÄID£¬²é¿´Î´¹ýÆÚ×÷ÒµÖÐÄ³¸ö½ÌÑ§°àÍê³É¡¢Î´Íê³É¡¢Íê³Éµ«Î´Åú¸ÄÊýÁ¿
	public function hoDetail($asid,$cid){
		$asid=intval($asid);
		$query="select count(*) finish from homework where  asid=?";
		$res=$this->db->query($query,array($asid));
		$res=$res->row_array();
        $query1="select count(*) nofinish from cla_stu  where cid=?";
		$res1=$this->db->query($query1,array($cid));
		$res1=$res1->row_array();
		$res1['nofinish']=$res1['nofinish']-$res['finish'];
        $query2="select count(*) nojudge from homework where grade is null and asid=?";		//从这里看出，做作业的时候grade要赋值为null
		$res2=$this->db->query($query2,array($asid));
		$res2=$res2->row_array();
		return array_merge($res,$res1,$res2);
	}
	//查看某次作业的详情
	public function hoAdetail($asid){
		$asid=intval($asid);
		$query="select percentage,total,jx_class.jid from assign inner join jx_class on assign.jid=jx_class.jid where  asid=?";
		$res=$this->db->query($query,array($asid));
		$res=$res->row_array();
		return $res;
	}
	//Ñ§ÉúÍê³É×÷Òµ,Ò²Ðí¿ÉÒÔ´ÓÕâ¶ù¿´³öÓÐÐÞ¸Ä
	public function finiHomework($asid,$sid,$attachment){
		//echo "sssssid:".$sid;
		$array=array('asid'=>$asid,'sid'=>$sid,'finishtime'=>date('y-m-d',time()),'attach'=>$attachment);
		$this->db->insert('homework',$array);
		if(!mysql_insert_id)
		return false;
	    return true;
	}
	//ÐÞ¸ÄÌá½»¹ýµÄ×÷Òµ.¿ØÖÆÆ÷Òª¼ÓÈç¹ûÀÏÊ¦Èç¹ûÐÞ¸Ä¹ýÁËµÄ»°£¬¾Í²»ÄÜÐÞ¸ÄÁË
	public function modiHomework($attachment,$asid,$sid){
		$query="select attach from homework where asid=? and sid=?";
		$res=$this->db->query($query,array($asid,$sid));
		$res=$res->row_array();
		//print_r($res);
		@unlink('../stuattachment'.$res['attach']);
		$query="update homework set attach=?,finishtime=now() where asid=? and sid=?";
		$this->db->query($query,array($attachment,$asid,$sid));
		if(!mysql_affected_rows())
		return false;
        return true;
	}
	//ÀÏÊ¦²é¿´Ä³ÈËÌá½»¹ýµÄ×÷Òµ
	public function hoPerson($asid,$sid){
		$asid=intval($asid);
		$sid=intval($sid);
		$query="select name,attach,finishtime,grade,addtion from homework inner join student on homework.sid=student.sid and asid=? and $sid=?";
		$res=$this->db->query($query,array($asid,$sid));
		return $res->result_array();
		/*if(!$res->result_array()){
			$quer="select name,attachment grade,addtion from homework where asid=?";
		}*/
	}
	//¸ø×÷Òµ´ò³É¼¨£¬Ð´ÅúÓï£¬¸ù¾Ý²¼ÖÃ×÷ÒµµÄasidºÍÑ§ºÅ
	public function hoJudge($grade,$addtion,$asid,$sid){
		$asid=intval($asid);
		$sid=intval($sid);
		$query="update homework set grade=? ,addtion=? where asid=? and sid=?";
		$this->db->query($query,array($grade,$addtion,$asid,$sid));
	    if(!mysql_affected_rows())
		return false;
        return true;
	}
	//È¥°Ñ±í½á¹¹ÖÐµÄtemÈ¥µô.ÒÔºó´ÎËã³É¼¨¡£ÓÃupdate
	public function inGrade2($percen,$jid,$sid,$grade){
		$query="update grade set grade=grade+total*?*? where sid=? and jid=?";
		$res=$this->db->query($query,array($percen,$grade,$sid,$jid));
		if(!mysql_affected_rows())
		return false;
        return true;
	}
	public function inTotal($percen,$sid,$jid,$grade,$total){
		echo $grade."\t".$percen."\t".$total;
		$grade=$grade*$percen*$total;
		//echo $percen."wwww".$sid."wwww".$jid."wwww".$grade."www".$total;
		//$query="insert into grade set gid=null,grade=?,total=?,sid=?,jid=?";
		echo $grade;
		$query="insert into grade values(NULL,?,?,?,NOW(),?)";
		$this->db->query($query,array($jid,$sid,$grade,$total));
		if(!mysql_affected_rows()){
		return false;
	    }else
	    return true;
	}
	//µÚÒ»´ÎËã³É¼¨ÓÃinsert
	/*public function inGrade1($percen,$jid,$sid,$grade){
		$query="insert into grade set grade=total*?*?,sid=?,jid=?";
		$this->db->query($query,array($percen,$grade,$sid,$jid));
		if(!mysql_affected_rows())
		return false;
        return true;
	}*/
	//²é¿´³É¼¨
	//查看平时分
	public function getGrade($jid,$sid){
		/*$this->db->select('grade,total');
		$this->db->from('grade');
		$array=array('sid'=>$sid,'jid'=>$jid);
		$this->db->where($array);
		$res=$this->db->get();
		$res=$res->row_array();
		return $res;*/

				$query="SELECT grade,total FROM `grade` where sid=? and jid=?";
		$res=$this->db->query($query,array($sid,$jid));
		$res=$res->row_array();
		return $res;
	}
	//查看老师打的分
	public function getGrade2($asid,$sid){
		/*$this->db->select('grade+0 grade');
		$this->db->from('homework');
		$res=$this->db->get();*/
		$query="SELECT grade+0 grade FROM `homework` where asid=? and sid=?";
		$res=$this->db->query($query,array($asid,$sid));
		$res=$res->row_array();
		return $res;
	}
	//²é¿´Ä³¸öÈËÄ³¿Æ×Ü¹²ÓÐ¶àÉÙ´Î×÷ÒµÎ´½»£¬ÒÑ»ñµÃÆ½Ê±·Ö£¬¿Î³ÌÃû
	public function getStatistics($jid,$sid){
		$query="select count(*) allh  from assign where jid=?";
		$res=$this->db->query($query,array($jid));
		$all=$res->row_array();
		$all=$all['allh'];
		$query="select count(*) commits from assign inner join homework on assign.asid=homework.asid where jid=? and sid=?";
		$res=$this->db->query($query,array($jid,$sid));
		$commits=$res->row_array();
		$commits=$commits['commits'];
		$array['absent']=$all-$commits;
		$result=$this->getGrade($jid,$sid);
		$array['score']=$result['grade'];
		$array['total']=$result['total'];
		$this->db->select('course');
		$this->db->from('jx_class');
		$this->db->where('jid',$jid);
		$res=$this->db->get();
		$res=$res->row_array();
        $array['coursename']=$res['course'];
		return $array;
	}
	//¸ù¾Ý¼ÓÈëµÄ°à¼¶,jid Ñ§Éú²é¿´Î´¹ýÆÚ×÷ÒµµÄÏêÏ¸Çé¿ö
	public function getNodue($sid){
		$query="select asid,percentage,attachement,deadline,pubtime,assign.addtion from cla_stu inner join jx_class inner join assign on cla_stu.cid=jx_class.cid and jx_class.jid=assign.jid where deadline>now() and sid=?";
		$res=$this->db->query($query,array($sid));
		$res=$res->result_array();
		return $res;
	}
	public function getHo($asid,$sid){
		$query="select assign.attachement asinattachment,homework.attach hoattachment,assign.addtion,deadline from assign inner join homework on assign.asid=homework.asid where sid=? and assign.asid=?";
		$res=$this->db->query($query,array($sid,$asid));
		$res=$res->result_array();
		if(!$res){
		 $query="select attachement asinattachment,addtion,deadline from assign where  asid=?";
		 $res=$this->db->query($query,array($asid));
		 $res=$res->result_array();
		}
		return $res[0];
	}
	public function isFinish($asid,$sid){
		$query1="select count(*) from homework where asid=? and sid=?";
		$res=$this->db->query($query1,array($asid,$sid));
		$res=$res->row_array();
		return $res;
	}
	public function downLoad($filename,$flag){
      $mime=mime_content_type($filename);
      header('Content-Type:'.$mime);
      header('Content-Disposition:attachment; filename="'.$filename.'"');
      header('Content-Length:'.filesize($filename));
      if($flag==1){
      readfile("../sirattachment/".$filename);
      }else if($flag==2){
      readfile("../stuattachment/".$filename);
      }
	}
}
?>