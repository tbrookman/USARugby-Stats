$(document).ready(function() {  
  $('.error').hide();
 
 $("#add_score").click(function() {
 //alert('in button');
		// validate and process form
		// first hide any error messages
    $('.error').hide();
		
	  	var minute = $("input#minute").val();
		if (minute == "") {
      $("label#minute_error").show();
      $("input#minute").focus();
      return false;
    }
		var type = $('#type').val();
		if (type == "") {
      $("label#type_error").show();
      $("input#type").focus();
      return false;
    }
		
		var player = $('#player').val();
		if (player == "") {
      $("label#player_error").show();
      $("input#player").focus();
      return false;
    } 

    		var refresh = $("#refresh").val();
    		var game_id = $("#game_id").val();
    		var game_score = '/competition/game_score.php?game_id=' + game_id;
		
		$.post('http://usarugby.us/competition/add_score_process.php', 
		{minute: minute, type: type, player: player, game_id: game_id}, 
		function(){
		     	$('#scores').fadeOut('slow', function(){
		     		$('#scores').html('Please wait...');
		     		$('#scores').fadeIn('fast');
       				$('#scores').load(refresh, function(){
         			$('#scores').fadeIn('slow');
         			});
         		});
			
     			
		});
		
		
		
    return false;
	});
   
 });