<?php
if(!file_exists("upload/zip/")){
mkdir("upload/zip/");
}
$description=$_REQUEST['description'];

function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}

 function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir);
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
           rrmdir($dir. DIRECTORY_SEPARATOR .$object);
         else
           unlink($dir. DIRECTORY_SEPARATOR .$object); 
       } 
     }
     rmdir($dir); 
   } 
 }
 
 
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function read_docx($new_name_path){
$target_dir="upload/zip/";
$zip = new ZipArchive;
if ($zip->open($new_name_path) === TRUE) {
  $zip->extractTo($target_dir);
  $zip->close();
  
$word_xml=$target_dir."word/document.xml";
$word_xml_relational=$target_dir."word/_rels/document.xml.rels";

$content=file_get_contents($word_xml);
//  echo htmlentities($content); echo "<hr>";
 
  preg_match_all ( '#<m:oMath>(.+?)</m:oMath>#', $content, $parts );
 // echo "<pre>"; print_r( $parts); echo "</pre>"; 
   if(count($parts[1])==0){
  preg_match_all ( '#<m:oMath xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math">(.+?)</m:oMath>#', $content, $parts );
  
  }
  
  foreach($parts[1] as $k => $val){
	  
   $xslDoc = new DOMDocument();
   $xslDoc->load("omml2mml.xsl");
$valin='<?xml version="1.0" encoding="UTF-8" standalone="yes"?><w:document xmlns:ve="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:m="http://schemas.openxmlformats.org/officeDocument/2006/math" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:wp="http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing" xmlns:w10="urn:schemas-microsoft-com:office:word" xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main" xmlns:wne="http://schemas.microsoft.com/office/word/2006/wordml"><w:body>'.$val.'</w:body></w:document>';
// echo $valin;
$tim='rfor/'.rand(111,999).time().'.xml';
   file_put_contents($tim,$valin);
   $xmlDoc = new DOMDocument();
   $xmlDoc->load($tim);
   
   $proc = new XSLTProcessor();
   $proc->importStylesheet($xslDoc);
  $mmlData=$proc->transformToXML($xmlDoc);
$mmlData=str_replace('<mml:math','<math',$mmlData);
$mmlData=str_replace('</mml:math','</math',$mmlData);
$mmlData=str_replace('</mml:','</m:',$mmlData);
$mmlData=str_replace('<mml:','<m:',$mmlData);
$mmlData=str_replace('UTF-16','UTF-8',$mmlData);
// echo $mmlData."<br>";
// echo $mmlData;
$content=str_replace($val,$mmlData,$content);
//unlink($tim);
}
 
 
 $listmathmltags=array( "abs",
  "and",
  "annotation",
  "annotation-xml",
  "apply",
  "approx",
  "arccos",
  "arccosh",
  "arccot",
  "arccoth",
  "arccsc",
  "arccsch",
  "arcsec",
  "arcsech",
  "arcsin",
  "arcsinh",
  "arctan",
  "arctanh",
  "arg",
  "bind",
  "bvar",
  "card",
  "cartesianproduct",
  "cbytes",
  "ceiling",
  "cerror",
  "ci",
  "cn",
  "codomain",
  "complexes",
  "compose",
  "condition",
  "conjugate",
  "cos",
  "cosh",
  "cot",
  "coth",
  "cs",
  "csc",
  "csch",
  "csymbol",
  "curl",
  "declare",
  "degree",
  "determinant",
  "diff",
  "divergence",
  "divide",
  "domain",
  "domainofapplication",
  "emptyset",
  "encoding",
  "eq",
  "equivalent",
  "eulergamma",
  "exists",
  "exp",
  "exponentiale",
  "factorial",
  "factorof",
  "false",
  "floor",
  "fn",
  "forall",
  "function",
  "gcd",
  "geq",
  "grad",
  "gt",
  "ident",
  "image",
  "imaginary",
  "imaginaryi",
  "implies",
  "in",
  "infinity",
  "int",
  "integers",
  "intersect",
  "interval",
  "inverse",
  "lambda",
  "laplacian",
  "lcm",
  "leq",
  "limit",
  "list",
  "ln",
  "log",
  "logbase",
  "lowlimit",
  "lt",
  "m:apply",
  "m:mrow",
  "maction",
  "malign",
  "maligngroup",
  "malignmark",
  "malignscope",
  "math",
  "matrix",
  "matrixrow",
  "max",
  "mean",
  "median",
  "menclose",
  "merror",
  "mfenced",
  "mfrac",
  "mfraction",
  "mglyph",
  "mi",
  "mi\"",
  "min",
  "minus",
  "mlabeledtr",
  "mlongdiv",
  "mmultiscripts",
  "mn",
  "mo",
  "mode",
  "moment",
  "momentabout",
  "mover",
  "mpadded",
  "mphantom",
  "mprescripts",
  "mroot",
  "mrow",
  "ms",
  "mscarries",
  "mscarry",
  "msgroup",
  "msline",
  "mspace",
  "msqrt",
  "msrow",
  "mstack",
  "mstyle",
  "msub",
  "msubsup",
  "msup",
  "mtable",
  "mtd",
  "mtext",
  "mtr",
  "munder",
  "munderover",
  "naturalnumbers",
  "neq",
  "none",
  "not",
  "notanumber",
  "notin",
  "notprsubset",
  "notsubset",
  "or",
  "otherwise",
  "outerproduct",
  "partialdiff",
  "pi",
  "piece",
  "piecewice",
  "piecewise",
  "plus",
  "power",
  "primes",
  "product",
  "prsubset",
  "quotient",
  "rationals",
  "real",
  "reals",
  "reln",
  "rem",
  "root",
  "scalarproduct",
  "sdev",
  "sec",
  "sech",
  "select",
  "selector",
  "semantics",
  "sep",
  "set",
  "setdiff",
  "share",
  "sin",
  "sinh",
  "span",
  "subset",
  "sum",
  "tan",
  "tanh",
  "tendsto",
  "times",
  "transpose",
  "true",
  "union",
  "uplimit",
  "var",
  "variance",
  "vector",
  "vectorproduct",
  "xor");
  $nmathml=array();
  foreach($listmathmltags as $k => $mlval){
  $nmathml[]="<m:".$mlval.">";
  }
  $nmathml=implode('',$nmathml);
//  print_r($content);echo "<br>----<hr>"; 
  $content = (strip_tags($content,$nmathml."<math><m:msup><m:mi><m:mo><m:mfenced><m:mfrac><mi><mphantom><mstyle><msub><msup><msubsup><maction><maligngroup> <malignmark><mlabeledtr> <mlongdiv> <mroot> <mrow><mtable><mtd><mtext><mtr><menclose><merror><mmultiscripts><ms><mscarries> <mscarry> <msgroup> <msline><munder><mn><mfenced><mfrac><mglyph><munderover><msgroup><mlongdiv><msline><mstack><mspace><msqrt><msrow><mstack><semantics><annotation><annotation-xml><a:blip>"));
// print_r($content);echo "<br>----"; die;
$xml=simplexml_load_file($word_xml_relational);
//echo "<pre>";
//print_r($xml);
//echo count($xml);
$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);

$relation_image=array();
foreach($xml as $key => $qjd){
//echo "<pre>";
 //print_r($qjd);
 $ext = strtolower(pathinfo($qjd['Target'], PATHINFO_EXTENSION));
//echo $ext."<br>";
if (in_array($ext, $supported_image)) {
$id=xml_attribute($qjd, 'Id');
$target=xml_attribute($qjd, 'Target');
//print_r($id);

$relation_image[$id]=$target;  
//print_r($qjd['Id']); echo "<-->";  
//echo $qjd['Id']."<-->";
//echo $qjd['Target']."<br>";
} 


}
//echo "<pre>";
//print_r($relation_image);

$word_folder=$target_dir."word";
$prop_folder=$target_dir."docProps";
$relat_folder=$target_dir."_rels";
$content_folder=$target_dir."[Content_Types].xml";
//return $relation_image;
$rand_inc_number=1;
foreach($relation_image as $key => $value){
$rplc_str='&lt;a:blip r:embed=&quot;'.$key.'&quot; cstate=&quot;print&quot;/&gt;';
$rplc_str2='&lt;a:blip r:embed=&quot;'.$key.'&quot;&gt;&lt;/a:blip&gt;';
$rplc_str3='&lt;a:blip r:embed=&quot;'.$key.'&quot;/&gt;';
$rplc_str4='<a:blip r:embed="'.$key.'" cstate="print"></a:blip>';
$rplc_str5='&lt;a:blip r:embed=&quot;'.$key.'&quot; cstate=&quot;print&quot;&gt;&lt;/a:blip&gt;';

$ext_img = strtolower(pathinfo($value, PATHINFO_EXTENSION));
$imagenew_name=time().$rand_inc_number.".".$ext_img;
$old_path=$word_folder."/".$value;
$new_path="upload/word_images/".$imagenew_name;

rename($old_path,$new_path);
$img='<img src="upload/word_images/'.$imagenew_name.'">';
// echo $rplc_str2."--".htmlentities($img);
 

$content=str_replace($rplc_str,$img,$content);
$content=str_replace($rplc_str2,$img,$content);
$content=str_replace($rplc_str3,$img,$content);
$content=str_replace($rplc_str4,$img,$content);
$content=str_replace($rplc_str5,$img,$content);
$rand_inc_number++;

}

 
rmdir($word_folder);
rmdir($relat_folder);
rmdir($prop_folder);
rmdir($content_folder);
 return $content;
} else {
  return 'failed';
}

    }
	
if(isset($_FILES['fileToUpload'])){
    $errors= array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_name_wd_ext=str_replace(".docx","",$file_name );
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['fileToUpload']['name'])));
    
    $extensions= array("docx","txt");
    
    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a DOCX file.";
    }
    
    if($file_size > 2097152) {
        $errors[]='File size must be less than 2 MB';
    }
    
    if(empty($errors)==true) {
        move_uploaded_file($file_tmp,"upload/".$file_name);
		$nm=time().".docx";
        $nf="upload/".$nm;
		rename("upload/".$file_name,$nf);
		if($file_ext=="docx"){
		$content=read_docx($nf);
		}else if($file_ext=="txt"){
		$content=file_get_contents($nf);	
		}else{
		 header("location:index.php?msg=".$file_ext);	
		}
		$datafile=clean($file_name_wd_ext)."-".time();
		file_put_contents("data/".$datafile.".txt",$content);
		unlink($nf);
		$rfors=glob("rfor/*.xml");
		foreach($rfors as $k => $rfor){
				unlink($rfor);
		}
		  rrmdir("upload/zip");
		$ed=file_get_contents('topic.json');
		$d_arr="";
		if($ed != ""){
			$d_arr=json_decode(trim($ed), true);
			$d_arr[$datafile]=$description;
		}else{
			$d_arr=array();
			$d_arr[$datafile]=$description;
		}
		file_put_contents("topic.json",json_encode($d_arr));
		header("location:index.php?msg=Uploaded");
   }else{
	   
       //  print_r($errors);
	   header("location:index.php?msg=".implode("<br>",$errors));
    }
}
?>