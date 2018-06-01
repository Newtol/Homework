<?php
class Class_model extends CI_Model{
	//»ñÈ¡°à¼¶ÁÐ±í£¬ÁÐ±íÓÐ°à¼¶ºÅ£¬¿Î³ÌÃû£¬°à¼¶Ãû£¬´´½¨Õß
	public function getAdminclass($id){
		$id=intval($id);
		$query="select jid,a.cid cid,course,b.name classname,c.name creator from jx_class as a inner join class as b inner join student as c on a.cid=b.cid  and b.creator=c.sid where tid=?";
		$res=$this->db->query($query,array($id));
		$res=$res->result_array();
		return $res;
	}
	//»ñÈ¡°à¼¶³ÉÔ±ÁÐ±í£¬ÁÐ±íÓÐÐÕÃû£¬ÐÔ±ð¡¢ÊÇ·ñ¹ÜÀíÔ±¡¢¸öÈË½éÉÜ
	public function getClass($id){
		$id=intval($id);
		$query="select a.sid,name,gender, 'false' isadmin, selfintro from cla_stu as a inner join student as b on a.sid=b.sid where cid=?";
        $res=$this->db->query($query,array($id));
        return $res->result_array();		
	}
	//¸ù¾Ý°à¼¶ID£¬ËÑË÷°à¼¶ÐÅÏ¢
	public function serClass($cid){
		$cid=intval($cid);
		$query="select a.name name,creatime,b.name creator,description from class as a inner join student as b on a.creator=b.sid where cid=?";
		$res=$this->db->query($query,array($cid));
		return $res->row_array();
	}
	//½ø×¤Ä³°à
	public function adminClass($tid,$cid,$course,$addtion,$total){
		$array=array('jid'=>null,'tid'=>$tid,'cid'=>$cid,'course'=>$course,'addtion'=>$addtion,'total'=>$total);
		$this->db->insert('jx_class',$array);
		if(!mysql_insert_id())
	    return false;
	    return true;
	}
	//Ñ§Éú²é¿´¼ÓÈëµÄ°à¼¶
	public function inClass($sid){
		$query="select a.cid cid,a.name classname,creatime, creator,description from class as a inner join cla_stu as b on a.cid=b.cid where b.sid=?";
		$res=$this->db->query($query,array($sid));
		$res=$res->result_array();
		return $res;
	}
	public function inCourse($sid){
        $query="select jid,sid,jx_class.cid cid,course,addtion from cla_stu inner join jx_class on cla_stu.cid=jx_class.cid where cla_stu.sid=?";
        $res=$this->db->query($query,array($sid));
        $res=$res->result_array();
        return $res;
	}
	//¼ÓÈëÄ³¸ö°à¼¶
	public function joinClass($sid,$cid){
		$array=array('csid'=>null,'sid'=>$sid,'cid'=>$cid);
		$res=$this->db->insert('cla_stu',$array);
		if(!mysql_insert_id())
	    return false;
	    return true;
	}
	//²é¿´Í¬Ñ§µÄÉêÇëÐÅÏ¢
	public function showApply1($cid){
		$query="select apid,realname,selfintro,course,done,addtion,total from teacher as a inner join apply as b on a.tid=b.apid where cid=? order by id desc";
		$res=$this->db->query($query,array($cid));
		$res=$res->result_array();
		foreach($res as $key=>$value){
			$res[$key]['done']=$res[$key]['done']==1?true:false;;
		}
		return $res;
	}
	//²é¿´ÀÏÊ¦µÄÉêÇëÐÅÏ¢
	public function showApply2($cid){
		$query="select apid,realname,selfintro,done from student as a inner join apply as b on a.sid=b.apid where cid=?";
		$res=$this->db->query($query,array($cid));
		$res=$res->result_array();
		foreach($res as $key=>$value){
			$res[$key]['done']=$res[$key]['done']==1?true:false;;
		}
		return $res;
	}
	//°ÑÉêÇëÉèÖÃÎªÒÑ´¦Àí
   public function doneApply($apid,$type,$cid){
	    $array=array('apid'=> $apid,'sirorstu'=>$type,'cid'=>$cid);
		$this->db->set('done',1);
		$this->db->where($array);
		$this->db->update('apply');

   }
   //´´½¨°à¼¶
   public function creaClass($name,$creator,$description){
	   $array=array('cid'=>null,'name'=>$name,'creatime'=>date('y-m-d h:i:s',time()),'creator'=>$creator,'description'=>$description);
	   $this->db->insert('class',$array);
	   $cid=mysql_insert_id();
	   $this->joinClass($creator,$cid);
   }
   //ÐÞ¸Ä°à¼¶ÐÅÏ¢
   public function modiClass($cid,$name,$description){
	   $array=array('name'=>$name,'description'=>$description);
	   $this->db->where('cid',$cid);
	   $this->db->update('class',$array);
   }
   //ÉêÇë¼ÓÈë°à¼¶
   public function appClass($apid,$cid,$sirorstu,$couse,$addtion,$total){
	   $array=array('id'=>null,'apid'=>$apid,'cid'=>$cid,'sirorstu'=>$sirorstu,'done'=>0,'course'=>$couse,'addtion'=>$addtion,'total'=>$total);
	   $this->db->insert('apply',$array);
   }
}