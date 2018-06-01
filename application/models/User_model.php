<?php
class User_model extends CI_Model{
	public function __constuct(){
		parent::__constuct();
	}
	public function insertTeacher($name,$pwd,$gender,$introduce,$realname){
		$array=array('tid'=>null,'name'=>$name,'gender'=>$gender,'selfintro'=>$introduce,'password'=>md5($pwd),'realname'=>$realname,'jointime'=>date("y-m-d h:i:s",time()));
		$this->db->insert('teacher',$array);
		if(!mysql_insert_id())
		return false;
	    return true;
	}
	public function insertStudent($name,$pwd,$gender,$introduce,$realname){
		$array=array('sid'=>null,'gender'=>$gender,'name'=>$name,'selfintro'=>$introduce,'password'=>md5($pwd),'realname'=>$realname,'jointime'=>date("y-m-d h:i:s",time()));
		$this->db->insert('student',$array);
		if(!mysql_insert_id())
		return false;
	    return true;
	}
	//这里也决定了注册帐号的时候，所以。我们改变策略，应用一个昵称和truename
	public function getPwd($flag,$user){
	   switch($flag)
	   { 
           case 1:
		   $this->db->select('tid,password');
		   $this->db->from('teacher');
		   $this->db->where('name',$user);
		   $res=$this->db->get();
		   return $res->row_array();
           break;	
           case 2:
		   $this->db->select('sid,password');
		   $this->db->from('student');
		   $this->db->where('name',$user);//也许这里就可以看出user字段该加索引了
		   $res=$this->db->get();
		   return $res->row_array();	 
		    break;  
	   }	
	}
	//修改个人信息
	public function modSeflin($id,$flag,$array){
		$this->db->set($array);
		
		if($flag==1){
			$this->db->where('tid',$id);

		$this->db->update('teacher');
		}else if($flag==2){
			$this->db->where('sid',$sid);
			$this->db->update('student');
		}
		
		if(!mysql_affected_rows())
		return false;
        return true;
	}
	public function getUser($flag,$user){
		switch($flag)
		{
			case 1:
			$this->db->from('student');
			$this->db->where('name',$user);
			return $this->db->count_all_results();
			break;
			case 2:
			$this->db->from('teacher');
			$this->db->where('name',$user);
			return $this->db->count_all_results();
		}
	}
}
?>
