$(document).ready(function() {
  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

 //adding a score event for a game
 $("#addscore").live('submit', function() {

        //alert('in button');
        // validate and process form
        // first hide any error messages
    $('.error').hide();

          var minute = $("#minute").val();
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
        if (player == "" && type!=5) {
      $("label#player_error").show();
      $("input#player").focus();
      return false;
    }

            var refresh = $("#refresh").val();
            var game_id = $("#game_id").val();
            var game_score = '/game_score.php?id=' + game_id;

        $.post('/add_score_process.php',
        {minute: minute, type: type, player: player, game_id: game_id},
        function(){

                 $('#scores').fadeOut('slow', function(){
                     $('#scores').html('Please wait...');
                     $('#scores').fadeIn('fast');
                       $('#scores').load(refresh, function(){
                     $('#scores').fadeIn('slow');
                     });
                 });
                 $('#score').fadeOut('slow', function(){
                     $('#score').html('Please wait...');
                     $('#score').fadeIn('fast');
                     $('#score').load(game_score, function(){
                     $('#score').fadeIn('slow');
                     });
                 });

        });



    return false;
    });


    //adding a sub event to a game
    $("#addsub").live('submit', function() {

    //event.preventDefault();

        // validate and process form
        // first hide any error messages
            $('.error').hide();

          var submin = $("#submin").val();
        if (submin == "") {
              $("label#submin_error").show();
              $("input#submin").focus();
              return false;
            }

        var subtype = $('#subtype').val();
        if (subtype == "") {
              $("label#subtype_error").show();
              $("input#subtype").focus();
              return false;
            }

        var player_on = $('#player_on').val();
        if (player_on == "") {
              $("label#player_on_error").show();
              $("input#player_on").focus();
              return false;
            }

            var player_off = $('#player_off').val();
        if (player_off == "") {
              $("label#player_off_error").show();
              $("input#player_off").focus();
              return false;
            }

            var subrefresh = $("#subrefresh").val();
            var game_id = $("#game_id").val();

        $.post('/add_sub_process.php',
        {submin: submin, subtype: subtype, player_on: player_on, player_off: player_off, game_id: game_id},
        function(){
                 $('#subs').fadeOut('slow', function(){
                     $('#subs').html('Please wait...');
                     $('#subs').fadeIn('fast');
                       $('#subs').load(subrefresh, function(){
                     $('#subs').fadeIn('slow');
                     });
                 });
        });

        return false;
    });



    //adding a card event to a game
     $("#addcard").live('submit', function() {

        // validate and process form
        // first hide any error messages
    $('.error').hide();

          var cardmin = $("#cardmin").val();
        if (cardmin == "") {
      $("label#cardmin_error").show();
      $("input#cardmin").focus();
      return false;
    }
        var cardtype = $('#cardtype').val();
        if (cardtype == "") {
      $("label#cardtype_error").show();
      $("input#cardtype").focus();
      return false;
    }

        var cardplayer = $('#cardplayer').val();
        if (cardplayer == "") {
      $("label#cardplayer_error").show();
      $("input#cardplayer").focus();
      return false;
    }
            var cardrefresh = $("#cardrefresh").val();
            var card_game_id = $("#card_game_id").val();

        $.post('/add_card_process.php',
        {cardmin: cardmin, cardtype: cardtype, cardplayer: cardplayer, card_game_id: card_game_id},
        function(){

                 $('#cards').fadeOut('slow', function(){
                     $('#cards').html('Please wait...');
                     $('#cards').fadeIn('fast');
                       $('#cards').load(cardrefresh, function(){
                     $('#cards').fadeIn('slow');
                     });
                 });

        });



    return false;
    });



    //deleting a scoring event from a game
    $(".dScore").live('click', function() {

        var refresh = $("#refresh").val();
            var dId = $(":input").eq($(":input").index(this) + 1).val();

            var game_id = $("#game_id").val();
            var game_score = '/game_score.php?id=' + game_id;

        $.post('/delete_score_process.php',
        {id: dId, game_id: game_id},
        function(){

                 $('#scores').fadeOut('slow', function(){
                     $('#scores').html('Please wait...');
                     $('#scores').fadeIn('fast');
                       $('#scores').load(refresh, function(){
                     $('#scores').fadeIn('slow');
                     });
                 });
                 $('#score').fadeOut('slow', function(){
                     $('#score').html('Please wait...');
                     $('#score').fadeIn('fast');
                     $('#score').load(game_score, function(){
                     $('#score').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //delete a sub event from a game
    $(".dSub").live('click', function() {

        var subDrefresh = $("#subDrefresh").val();
        var dId = $(":input").eq($(":input").index(this) + 1).val();
            var game_id = $("#game_id").val();

        $.post('/delete_sub_process.php',
        {id: dId, game_id: game_id},
        function(){

                 $('#subs').fadeOut('slow', function(){
                     $('#subs').html('Please wait...');
                     $('#subs').fadeIn('fast');
                       $('#subs').load(subDrefresh, function(){
                     $('#subs').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //delete a card event from a game
    $(".dCard").live('click', function() {

        var cardDrefresh = $("#cardrefresh").val();
        var dId = $(":input").eq($(":input").index(this) + 1).val();

            var game_id = $("#game_id").val();

        $.post('/delete_card_process.php',
        {id: dId, game_id: game_id},
        function(){

                 $('#cards').fadeOut('slow', function(){
                     $('#cards').html('Please wait...');
                     $('#cards').fadeIn('fast');
                       $('#cards').load(cardDrefresh, function(){
                     $('#cards').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //add a competition
    $("#addcomp").live('submit', function() {

        // validate and process form
        // first hide any error messages
            $('.error').hide();

          var name = $("input#name").val();
        if (name == "") {
              $("label#name_error").show();
              $("input#name").focus();
              return false;
            }

        var type = $('#type').val();
        if (type == "") {
              $("label#type_error").show();
              $("input#type").focus();
              return false;
            }

        var max_event = $('#max_event').val();
        if (max_event == "") {
              $("label#max_event_error").show();
              $("input#max_event").focus();
              return false;
            }

            var max_match = $('#max_match').val();
        if (max_match == "") {
              $("label#max_match_error").show();
              $("input#max_match").focus();
              return false;
            }

        return true;
    });


    //hiding a competition
    $(".hidec").live('click', function() {

        var comprefresh = $("#comprefresh").val();
        var hId = $(":input").eq($(":input").index(this) + 1).val();

        $.post('/hide_comp_process.php',
        {id: hId},
        function(){

                 $('#comps').fadeOut('slow', function(){
                     $('#comps').html('Please wait...');
                     $('#comps').fadeIn('fast');
                       $('#comps').load(comprefresh, function(){
                     $('#comps').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //adding a game
    $("#addgame").live('submit', function() {

    //event.preventDefault();

        // validate and process form
        // first hide any error messages
            $('.error').hide();

          var field = $("input#field").val();

          var gnum = $("input#gnum").val();
        if (gnum == "") {
              $("label#gnum_error").show();
              $("input#gnum").focus();
              return false;
            }

        var kdate = $('#kdate').val();
        if (kdate == "") {
              $("label#kdate_error").show();
              $("input#kdate").focus();
              return false;
            }

        var koh = $('#koh').val();
        if (koh == "") {
              $("label#koh_error").show();
              $("input#koh").focus();
              return false;
            }

            var kom = $('#kom').val();
        if (kom == "") {
              $("label#kom_error").show();
              $("input#kom").focus();
              return false;
            }

        var home = $('#home').val();
        if (home == "") {
              $("label#home_error").show();
              $("input#home").focus();
              return false;
            }

            var away = $('#away').val();
        if (away == "") {
              $("label#away_error").show();
              $("input#away").focus();
              return false;
            }

            var grefresh = $("#grefresh").val();
            var comp_id = $("#comp_id").val();

        $.post('/add_game_process.php',
        {field: field, gnum: gnum, kdate: kdate, koh: koh, kom: kom, home: home, away: away, comp_id: comp_id},
        function(){
                 $('#games').fadeOut('slow', function(){
                     $('#games').html('Please wait...');
                     $('#games').fadeIn('fast');
                       $('#games').load(grefresh, function(){
                     $('#games').fadeIn('slow');
                     });
                 });
        });

        return false;
    });



    //adding a team to a comp
    $("#addteam").live('submit', function() {

    //event.preventDefault();

        // validate and process form
        // first hide any error messages
            $('.error').hide();

          var team = $("#team").val();
        if (team == "") {
              $("label#team_error").show();
              $("input#team").focus();
              return false;
            }

            var trefresh = $("#trefresh").val();
            var lrefresh = $("#lrefresh").val();
            var comp_id = $("#comp_id").val();
        $.post('/add_team_process.php',
        {team: team, comp_id: comp_id},
        function(){
                 $('#teams').fadeOut('slow', function(){
                     $('#teams').html('Please wait...');
                     $('#teams').fadeIn('fast');
                       $('#teams').load(trefresh, function(){
                     $('#teams').fadeIn('slow');
                     });
                 });
                 $('#addteamdiv').fadeOut('slow', function(){
                     $('#addteamdiv').html('Please wait...');
                     $('#addteamdiv').fadeIn('fast');
                       $('#addteamdiv').load(lrefresh, function(){
                     $('#addteamdiv').fadeIn('slow');
                     });
                 });
                 $('#addgamediv').fadeOut('slow', function(){
                     $('#addgamediv').html('Please wait...');
                     $('#addgamediv').fadeIn('fast');
                       $('#addgamediv').load('/add_game.php?id='+comp_id, function(){
                     $('#addgamediv').fadeIn('slow');
                     });
                 });
        });

        return false;
    });



    //deleting a game from the competition list
    $(".dGame").live('click', function() {
    if(!confirm('Are you sure you want to delete this game?')){return false;}

        var refresh = $("#grefresh").val();
            var dId = $(":input").eq($(":input").index(this) + 1).val();

        $.post('/delete_game_process.php',
        {game_id: dId},
        function(){
                 $('#games').fadeOut('slow', function(){
                     $('#games').html('Please wait...');
                     $('#games').fadeIn('fast');
                       $('#games').load(refresh, function(){
                     $('#games').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //deleting a team from the competition list
    $(".dTeam").live('click', function() {
    if(!confirm('Are you sure you want to delete this team from this competition?')){return false;}

        var refresh = $("#trefresh").val();

            var team_id = $(":input").eq($(":input").index(this) + 1).val();
            var comp_id = $("#comp_id").val();

        $.post('/delete_team_process.php',
        {comp_id: comp_id, team_id: team_id},
        function(){
                 $('#teams').fadeOut('slow', function(){
                     $('#teams').html('Please wait...');
                     $('#teams').fadeIn('fast');
                       $('#teams').load(refresh, function(){
                     $('#teams').fadeIn('slow');
                     });
                 });
                 $('#addteamdiv').fadeOut('slow', function(){
                     $('#addteamdiv').html('Please wait...');
                     $('#addteamdiv').fadeIn('fast');
                       $('#addteamdiv').load('/add_team.php?id='+comp_id, function(){
                     $('#addteamdiv').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //game confirmation sign off
    $(".signbox").live('change', function() {
    if(!confirm('Change signoff status?')){return false;}

        var srefresh = $("#srefresh").val();

            if ($("#ref").is(':checked'))var ref=1; else var ref=0;
            if ($("#num4").is(':checked'))var num4=1; else var num4=0;
            if ($("#homec").is(':checked'))var homec=1; else var homec=0;
            if ($("#awayc").is(':checked'))var awayc=1; else var awayc=0;

            var game_id = $("#game_id").val();

        $.post('/signatures_process.php',
        {ref: ref, num4: num4, homec: homec, awayc: awayc, game_id: game_id},
        function(){
                 $('#signoff').fadeOut('slow', function(){
                     $('#signoff').html('Please wait...');
                     $('#signoff').fadeIn('fast');
                       $('#signoff').load(srefresh, function(){
                     $('#signoff').fadeIn('slow');
                     });
                 });

        });

    return false;
    });



    //show edit info
            $("#eShow").live('click', function() {

            var game_id = $("#game_id").val();

            $('#info').html('Please wait...');
        $('#info').fadeIn('fast');
               $('#info').load('/edit_game_info.php?id='+game_id, function(){
             $('#info').fadeIn('slow');
             });

    return false;
    });


    //submit game edit info
    $("#eGame").live('click', function() {
    if(!confirm('Update game info as shown?')){return false;}

        $('.error').hide();

          var field = $("input#field").val();

          var gnum = $("input#gnum").val();
        if (gnum == "") {
              $("label#gnum_error").show();
              $("input#gnum").focus();
              return false;
            }

        var kdate = $('#kdate').val();
        if (kdate == "") {
              $("label#kdate_error").show();
              $("input#kdate").focus();
              return false;
            }

        var koh = $('#koh').val();
        if (koh == "") {
              $("label#koh_error").show();
              $("input#koh").focus();
              return false;
            }

            var kom = $('#kom').val();
        if (kom == "") {
              $("label#kom_error").show();
              $("input#kom").focus();
              return false;
            }

            var game_id = $("#game_id").val();

            var refresh = '/game_info.php?id='+game_id;

        $.post('/edit_game_info_process.php',
        {field: field, gnum: gnum, kdate: kdate, koh: koh, kom: kom, game_id: game_id},
        function(){
                 $('#info').fadeOut('slow', function(){
                     $('#info').html('Please wait...');
                     $('#info').fadeIn('fast');
                       $('#info').load(refresh, function(){
                     $('#info').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //submit event roster edit info
    $("#ersubmit").live('click', function() {
    if(!confirm('Update roster?')){return false;}

        $('.error').hide();

          var max = $("input#max").val();

          var players = '-';
          for (var i=1;i<=max;i++){
          var temp = 'p'+i;
          var val = $("#"+temp).val()
          if(val != '' && val != undefined){
          players = players+val+'-';
          }
          }

            var roster_id = $("#roster_id").val();

            var refresh = '/edit_event_roster.php?id='+roster_id;
        $.post('/edit_event_roster_process.php',
        {players: players, roster_id: roster_id},
        function(){
                 $('#eroster').fadeOut('slow', function(){
                     $('#eroster').html('Please wait...');
                     $('#eroster').fadeIn('fast');
                       $('#eroster').load(refresh, function(){
                     $('#eroster').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //submit game roster info
    $("#grsubmit").live('click', function() {
    if(!confirm('Update roster?')){return false;}

        $('.error').hide();

          var max = $("input#max").val();

          var players = '-';
          for (var i=1;i<=max;i++){
          var temp = 'p'+i;
          var val = $("#"+temp).val()
          if(val != '' && val != undefined){
          players = players+val+'-';
          }
          }

          var numbers = '-';
          for (var i=1;i<=max;i++){
          var temp = 'n'+i;
          var val = $("#"+temp).val()

          if(val != undefined){
            if(val==''){
            numbers = numbers+'B-';
            }
            else
            {
            numbers = numbers+val+'-';
            }
          }

          }

          var frontrows = '-';
          for (var i=1;i<=max;i++){
          var temp = 'fr'+i;
          var val = $("#"+temp+":checked").val()
            if(val != undefined){
            frontrows = frontrows+'1-';
            }
            else
            {
            frontrows = frontrows+'0-';
            }
          }


            var game_id = $("#game_id").val();
            var team_id = $("#team_id").val();
            var roster_id = $("#roster_id").val();

            var refresh = '/edit_game_roster.php?gid='+game_id+'&tid='+team_id;

        $.post('/edit_game_roster_process.php',
        {players: players, numbers: numbers, frontrows: frontrows, roster_id: roster_id, team_id: team_id},
        function(){
                 $('#groster').fadeOut('slow', function(){
                     $('#groster').html('Please wait...');
                     $('#groster').fadeIn('fast');
                       $('#groster').load(refresh, function(){
                     $('#groster').fadeIn('slow');
                     });
                 });

        });

    return false;
    });

    //submit game roster using previous game data
    $("#presubmit").live('click', function() {
    if(!confirm('Update roster?')){return false;}

        $('.error').hide();

            var comp_id = $("#comp_id").val();
            var game_id = $("#game_id").val();
            var team_id = $("#team_id").val();
            var roster_id = $("#roster_id").val();
            var refresh = '/edit_game_roster.php?gid='+game_id+'&tid='+team_id;

        $.post('/edit_game_roster_previous_process.php',
        {roster_id: roster_id, team_id: team_id, game_id: game_id, comp_id: comp_id},
        function(){
                 $('#groster').fadeOut('slow', function(){
                     $('#groster').html('Please wait...');
                     $('#groster').fadeIn('fast');
                       $('#groster').load(refresh, function(){
                     $('#groster').fadeIn('slow');
                     });
                 });

        });

    return false;
    });



    //team to DB
    $("#teamadd").live('click', function() {
    if(!confirm('Add club to database?')){return false;}

        $('.error').hide();

          var name = $("#name").val();
        if (name == "") {
              $("#name_error").show();
              $("#name").focus();
              return false;
            }

          var num = $("#num").val();
        if (num == "") {
              $("#num_error").show();
              $("#num").focus();
              return false;
            }

            var short = $("#short").val();

            //check if team exists with that name or num
            $.post('/db_update_team_check.php',
        {name: name, num: num},
        function(data){
                 if(data!=''){
                 alert(data);
                 return false;
                 }
                 else
                 {



            var refresh = '/db_update_team_list.php';

        $.post('/db_update_team_process.php',
        {name: name, num: num, short: short},
        function(){
                 $('#clublist').fadeOut('slow', function(){
                     $('#clublist').html('Please wait...');
                     $('#clublist').fadeIn('fast');
                       $('#clublist').load(refresh, function(){
                     $('#clublist').fadeIn('slow');
                     });
                 });

        });
            }//end of check else
            });

    return false;
    });



    //deleting a user
    $(".dUser").live('click', function() {
    if(!confirm('Are you sure you want to delete this user?')){return false;}

            var dId = $(":input").eq($(":input").index(this) + 1).val();

        $.post('/delete_user_process.php',
        {user_id: dId},
        function(){
                 $('#users').fadeOut('slow', function(){
                     $('#users').html('Please wait...');
                     $('#users').fadeIn('fast');
                       $('#users').load('users_list.php', function(){
                     $('#users').fadeIn('slow');
                     });
                 });

        });

    return false;
    });




    //show edit info for users
            $(".eUser").live('click', function() {

            var eId = $(":input").eq($(":input").index(this) + 1).val();

            $('#users').html('Please wait...');
        $('#users').fadeIn('fast');
               $('#users').load('/edit_user.php?id='+eId, function(){
             $('#users').fadeIn('slow');
             });

    return false;
    });


    //submit user edit info
    $("#eUserSubmit").live('click', function() {
    if(!confirm('Update user info as shown?')){return false;}

        $('.error').hide();

          var login = $("input#login").val();
        if (login== "") {
              $("label#login_error").show();
              $("input#login").focus();
              return false;
            }

        var team = $('#team').val();

        var access = $('#access').val();
        if (access == "") {
              $("label#access_error").show();
              $("input#access").focus();
              return false;
            }

            var user_id = $("#user_id").val();

        $.post('/edit_user_process.php',
        {login: login, team: team, access: access, user_id: user_id},
        function(){
                 $('#users').fadeOut('slow', function(){
                     $('#users').html('Please wait...');
                     $('#users').fadeIn('fast');
                       $('#users').load('users_list.php', function(){
                     $('#users').fadeIn('slow');
                     });
                 });

        });

    return false;
    });


    //add new user
    $("#addUser").live('click', function() {
        $('.error').hide();

          var login = $("input#login").val();
          var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        if (login== "" || !pattern.test(login)) {
              $("label#login_error").show();
              $("input#login").focus();
              return false;
            }

        /*var uuid = $('#uuid').val();
        if (uuid != "") {
        	var uuid_test_pattern = new RegExp(/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/i);
        	if (!uuid_test_pattern.test(uuid)) {
        		$("label#uuid_error").show();
                $("input#uuid").focus();
        	}
        }*/
        var team = $('#team').val();

        var access = $('#access').val();
        if (access == "") {
              $("label#access_error").show();
              $("input#access").focus();
              return false;
            }

        $.post('/add_user_process.php',
        {login: login, team: team, access: access},
        function(data){
        if(data) alert(data);
                 $('#users').fadeOut('slow', function(){
                     $('#users').html('Please wait...');
                     $('#users').fadeIn('fast');
                       $('#users').load('users_list.php', function(){
                     $('#users').fadeIn('slow');
                     });
                 });

        });

    return false;
    });

 });


