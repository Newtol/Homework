<?php
class Jsonformat{
public	function json_encode_ex($value)
{
    if (version_compare(PHP_VERSION,'5.4.0','<'))
    {
        $str = json_encode($value);
        $str = preg_replace_callback(
                                    "#\\\u([0-9a-f]{4})#i",
                                    function($matchs)
                                    {
                                         return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
                                    },
                                     $str
                                    );
        echo $str;
    }
    else
    {
        $json = json_encode($value, JSON_UNESCAPED_UNICODE);
        echo $json;
    }
}
	public  function show($code,$message='',$data){
		if(!is_numeric($code)){
			return "";
		}
        //$data=$data==NULL?"NULL":$data;
        $code=$data=="NULL"?404:$code;
        //$code=$data=="NULL"?200:$code;
		$result=array(
			'status'=>$code,
			'message'=>$message,
			'data'=>$data
			);
		$this->json_encode_ex($result);
	}
}
?>