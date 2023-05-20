<?php 
header('Access-Control-Allow-Origin: *');
ini_set('max_execution_time', 0);
include('config.php');

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}

$str=$_POST['str'];
$level=$_POST['level'];
if($level == "1"){
$ed=json_decode(file_get_contents("topic.json"),true);
$jstring="File Name, Description \n";
foreach($ed as $k => $val){
	$jstring = $jstring." ".$k.", ".$val." \n";
}
$text="At the end of this prompt there is csv data (enclosed by square bracket ) in which first column contain file name and second column contain description of that file name.  Giving you a question which you need to releate with best match possibility of description andd just return the associate file name. Question is ".$str.". Note the instructions. 1) This is very important instruction, If it does not match or relate with any description then just return response as NOT MATCHED . 2) Do not answer from outside the csv file. 3) Just return the file name. 4) Only return the file name if you are more than 50% sure else return NOT MATCHED  . [".$jstring."]";
$cmd="python ".$absolute_server_path."chatgptAPI.py '".$openai_api_key."' '".$text."' 'text-davinci-002'";
 // echo $cmd."<br><br><hr>";
exec($cmd,$result);
 $res=array();
foreach($result as $k => $val){
	if($val != ""){ 
	 $res[]=$val; 
	//  echo $val;
	}
}
 
$loop_all=0;
 
$filename=implode("",array_filter($res));
if(trim(strpos($filename,"NOT MATCHED")) != ""){
	 
	$loop_all=1;
}else{
	
	 
	if(!file_exists("data/".$filename.".txt")){
		 
		$loop_all=1;
	}else{
 

$content=file_get_contents("data/".($filename).".txt");
 

$text="Below are the paragraph enclosed with ~ which contain text, images and math html tags. At the end of paragraph there is question. Answer that question by using this paragraph. Note these instruction: 1) Return math html tag as it is. 2) Math html tag starts with <math and ends with </math>. 3) Do not extract text. Answer should contain tags if equation. 4) If any image demanded then return <img html tag if available in this paragraph `".limit_text(preg_replace( "/\r|\n/", "", str_replace("'","&lsquo;",$content)),300)."` Question is: ".$str;

 $cmd2="python ".$absolute_server_path."chatgptAPI.py '".$openai_api_key."' '".$text."' 'text-davinci-002'";
  // echo $cmd."<br><br><hr>";
exec($cmd2,$result2);
// print_r($result2);
  $res2=array();
foreach($result2 as $k => $val){
	if($val != ""){ 
	 
	$res2[]=$val;
	}
}
echo implode("",array_filter($res2));





		
	}
}
	
}
?>