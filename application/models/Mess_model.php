<?php
class Mess_model extends CI_Model{
	//根据页数查看消息
	public function getMess($page,$id){
		$this->db->select('mid,poster,reciever,isRead');
		$this->db->order_by('mid','DESC');
		$this->db->limit(7,($page-1)*7);
		$this->db->where('reciever',$id);
		$this->db->from('message');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function getMesste($page,$id){
		$this->db->select('mid,poster,reciever,isRead');
		$this->db->order_by('mid','DESC');
		$this->db->limit(7,($page-1)*7);
		$this->db->where('poster',$id);
		$this->db->from('message');
		$res=$this->db->get();
		return $res->result_array();
	}
	//看消息总数
	public function countMess($id){
		$this->db->where('reciever',$id);
		$this->db->from('message');
		return $this->db->count_all_results();
	}
	public function countMesste($id){
		$this->db->where('poster',$id);
		$this->db->from('message');
		return $this->db->count_all_results();
	}
	//查看消息具体内容
	public function getDetail($mid){
		$query="update message set isRead =1 where mid=?";
		$this->db->query($query,array($mid));
		$this->db->select('content');
		$this->db->from('message');
		$this->db->where('mid',$mid);
		$res=$this->db->get();
		return $res->row_array();
	}
	//设置为已读
	public function readOver($mid){
		$this->db->set('isRead',1);
		$this->db->where('mid',$mid);
		$this->db->update('message');
		
	}
	//发消息
	public function postMess($poster,$reciever,$content){
		$array=array('mid'=>null,'poster'=>$poster,'reciever'=>$reciever,'content'=>$content,'isRead'=>0);
		$this->db->insert('message',$array);
		if(!mysql_insert_id())
		return false;
	    return true;
	}
	//查看某个班的成员ID
	public function getIds($cid){
		$query="select sid from cla_stu where ";
		$this->db->select('sid');
		$this->db->where('cid',$cid);
		$this->db->from('cla_stu');
		$res=$this->db->get();
		$res=$res->result_array();
		return $res;
	}
}
?>