<?php 
function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
	$u=str_replace("index.php","",$_SERVER['REQUEST_URI']);
	$u=explode("?",$u);
	if(count($u) >= 2){
		$u=$u[0];		
	}
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $u;
}

if(isset($_REQUEST['remove'])){
	unlink($_REQUEST['remove']);
		$ed=file_get_contents('topic.json');
		$d_arr="";
		if($ed != ""){
			$d_arr=json_decode(trim($ed), true);
			unset($d_arr[(str_replace(".txt","",str_replace("data/","",$_REQUEST['remove'])))]);
			file_put_contents("topic.json",json_encode($d_arr));
		}
}
$files=glob("data/*.txt");
$ed=file_get_contents('topic.json');
$json_topic=array();
if($ed != ""){
$json_topic=json_decode($ed, true);	
}
?>							
<html>
	<head>
		<title>GPTbit</title>
		<link rel="stylesheet" href="style.css?q=<?php echo time();?>">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script   src="//code.jquery.com/jquery-3.7.0.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container-logo">
			<h1 class="logo-text">GPTbit</h1>
			<p class="logo-heading">Create a Chatbot with Custom Data by using ChatGPT</p>
		</div>
		<div class="container m20 grey-round-border">
			<?php 
			if(isset($_REQUEST['msg'])){
				if($_REQUEST['msg'] == "Uploaded"){
					echo "<div class='alert-green alert-msg'>File successfully imported</div>";
				}else{
					echo "<div class='alert-red alert-msg'>".$_REQUEST['msg']."</div>";
					
				}
				?>
				<script>
				setTimeout(function(){
					$('.alert-msg').fadeOut();
				},6000);
				</script>
				<?php 
			}
			
			?>
			<form action="upload.php" method="POST" enctype="multipart/form-data" onSubmit="return validateForm();">
				<p>Upload docx file containing custom data. It support text, images and Mathematical equations.</p>
				<button type="button" class="file-browse" onclick="callFileBrowse();"><i class="fa fa-file-arrow-up"></i/> Select .Docx or .Txt File</button>
				 <input type="file" name="fileToUpload" class="hidden" accept=".docx,.txt" id="fileToUpload" onchange="fileSelected(this.value);"  />
				 <input type="text" name="description" class="text-field" style="width:350px;" autocomplete=off placeholder="File Description in 10-20 words" required >
				  
				<input type="submit" class="upload-btn"/>
				<br>
				<span id="selectedFile" class="min-text"></span>
			</form>
			<br> 
			<p class="min-text"><i class="fa fa-circle-info"></i> Tips</p>
			<p class="min-text">Split your data into multiple topics or chapters and create separate .docx or .txt file. Recommend maximum 350 words per file.</p>
			<p class="min-text">File Description: Short description about topic and content in docx file.</p>
		</div>	
		<div class="container-w m20 ">
				<div class="container-60 m20 grey-round-border">
				
					<p>Uploaded Documents</p>
					<?php
					if(count($files) > 0){ 
					?>
					<table class="table">
						<tr><th>File Name</th><th>Description</th><th>Remove</th></tr>
						<?php
							 
								foreach($files as $k => $file){ 
								?>
								<tr><td><?php echo substr(str_replace("data/","",$file),0,30);?></td>
								<td>
								<?php 
								if(isset($json_topic[(str_replace(".txt","",str_replace("data/","",$file)))])){ echo substr($json_topic[(str_replace(".txt","",str_replace("data/","",$file)))],0,60); } ?>
								</td>
								<td><a href="index.php?remove=<?php echo $file;?>" style="color:#ffffff;"><i class="fa fa-trash"></i></a></td></tr>
								
								<?php 
								}
								
							

						?>
					</table>
					<?php
					}
					if(count($files) == 0){
								?>
								<div class="alert-red">No document uploaded yet</div>
								<?php 
							}
					?>

				</div>
				<div class="container-40 m20 grey-round-border">
					<p>Chatbot JavaScript</p>
					<?php
					if(count($files) == 0){ 
					?>
					<div class="alert-red">Javascript widget code will be generated after upload of first document</div>
					<?php 
							}else{
					?>
					
<textarea  style="width: 321px; height: 197px;">
<script   src="//code.jquery.com/jquery-3.7.0.js?q=<?php echo time();?>" crossorigin="anonymous"></script>
<link rel="stylesheet" href="<?php echo url();?>widget.css?q=<?php echo time();?>"  crossorigin="anonymous" referrerpolicy="no-referrer" />
<script> var app_url="<?php echo url();?>"; </script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3.2.2/es5/mml-chtml.min.js?config=TeX-AMS-MML_HTMLorMML"></script>
<script   src="<?php echo url();?>widget.js?q=<?php echo time();?>" crossorigin="anonymous"></script>		
<div class="gptbit-container">
<div class="gptbit-header">Ask me</div>
<div class="gptbit-content">
<div class="gptbit-response"></div>
<div class="gptbit-form"><input type="text" class="gptbit-text" id="gptbit-text"> <button type="button" class="gptbit-btn send-btn" >Send</button></div>
</div>
<div class="gptbit-footer-inner">Powered by <a href="">GPTbit</a></div>
</div>
<div class="gptbit-footer">Ask me</div>
</textarea>
							<?php } ?>
				</div>
		</div>
	</body>
	<script>
		function callFileBrowse(){
			$('#fileToUpload').click();
		}
		
		function fileSelected(d){
			if(d==""){
				$('#selectedFile').html("");
				$('.file-browse').addClass('red-border');
			}else{
				$('#selectedFile').html("<i class='fa fa-check'></i> "+d.split(/(\\|\/)/g).pop());
				$('.file-browse').removeClass('red-border');
			}
		}
		function validateForm(){
			if($('#fileToUpload').val()==""){
				$('.file-browse').addClass('red-border');
				return false;
			}
			return true;
		}
	</script>
</html>