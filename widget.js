$(document).ready(function() {

$(document).on("click",".gptbit-footer",function(){
	$('.gptbit-footer').toggle();
	$('.gptbit-container').toggle();
});

$(document).on("click",".gptbit-header",function(){
	$('.gptbit-footer').toggle();
	$('.gptbit-container').toggle();
});

$(document).on('keypress',function(e) {
    if(e.which == 13) {
        $(".send-btn").click();
    }
});


$(document).on("click",".send-btn",function(){
	
	var str=$('#gptbit-text').val();
	if(str == ""){
		return false;
	}
	$('#gptbit-text').val("");
	$('.gptbit-response').append("<div class='gptbit-msg margin-top text-right'>"+str+"</div>");
		$('.gptbit-response').scrollTop(10000);
	$('.gptbit-header').html("Processing...");
	$.post(app_url+"chatgptAPI.php",{str:str,level:'1'},function(data){
		
			$('.gptbit-response').append("<div class='gptbit-msg '>"+data.trim()+"</div>");
			$('.gptbit-response').scrollTop(10000);
			$('.gptbit-header').html("Ask me");
		try{
			MathJax.typeset();
		}catch(ex){
			console.log(ex);
		}		
	});
	
});


});
