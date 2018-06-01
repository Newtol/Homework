<?php
class Analy_model extends CI_Model{
      public function __construct(){
      	parent::__construct();
      }
      public function whenJoin($id,$flag){
      	if($flag==1){
        $query="select jointime from teacher where tid=?";
        }else{
        $query="select jointime from student where sid=?";
        }
        $res=$this->db->query($query,array($id));
        $result=$res->row_array();
        return $result;
      }
      public function whichHigh(){
      $query="select max(total) max from jx_class";
      $res=$this->db->query($query);
      $res=$res->row_array();
      $max=$res['max'];
      $query="select realname teachername,course,total from jx_class inner join teacher on jx_class.tid=teacher.tid where total=?";
      $res=$this->db->query($query,array($max));
      $res=$res->result_array();
      return $res[0];
      }
      public function bestBad($sid){
      $query="select bestcourse,bcscore,worsecourse,wcscore,absent,did from AnalyYear where sid=? and YEAR(year)=YEAR(now())";
      $res=$this->db->query($query,array($sid));
      $res=$res->row_array();
      return $res;
      }
      public function getStuids(){
      	$this->db->select('sid');
      	$this->db->from('student');
      	$res=$this->db->get();
        return $res->result_array();
      }
    public function analyYear($sid){
     //获取sid数组
           //插入数据进analyyear表
   $query11="select count(*) a from AnalyYear where sid=?";
   $resx=$this->db->query($query11,array($sid));
   $resx=$resx->row_array();
   print_r($resx['a']);
   if($resx['a'])
   	return;
    $query0="select MAX(grade) bcscore,course bestcourse from grade inner join jx_class on grade.jid=jx_class.jid where sid=? and year=now()";
    $res0=$this->db->query($query0,array($sid));
    $res0=$res0->row_array();
    $query1="select MIN(grade) wcscore,course worsecourse from grade inner join jx_class on grade.jid=jx_class.jid where sid=? and year=now()";
      $res1=$this->db->query($query1,array($sid));
    $res1=$res1->row_array();
    $query2="select jid from jx_class inner join class inner join cla_stu on jx_class.cid=class.cid and class.cid=cla_stu.cid where sid=?";
    $res2=$this->db->query($query2,array($sid));
    $res2=$res2->result_array();
    $all=0;
 
    foreach($res2 as $key=>$value){

        $query="select count(*) total from assign where jid=? and YEAR(pubtime)=YEAR(now())";
        $resx=$this->db->query($query,array($value['jid']));
        $resx=$resx->row_array();
        $all=$all+$resx['total'];

    }

        $query="select count(*) did from homework where YEAR(finishtime)=YEAR(now()) and sid=?";
        $resy=$this->db->query($query,array($sid));
        $resy=$resy->row_array();
        $res3=array('absent'=>$all-$resy['did'],'did'=>$resy['did']);
        $res3=array_merge($res0,$res1,$res3);
      $insert="insert into AnalyYear values(null,?,?,?,?,?,now(),?,?)";
      $this->db->query($insert,array($sid,$res3['bestcourse'],$res3['bcscore'],$res3['worsecourse'],$res3['wcscore'],$res3['absent'],$res3['did']));
  }
}
?>