$(document).ready(function() {
  $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });


  var initDateTime = function() {
    $('.date_select').datepicker({
      format: 'yyyy-mm-dd',
      //startDate: new Date(),
      autoclose: true
    });

    $('.time-entry').timeEntry({
      spinnerImage: '',
      spinnerBigImage: ''
    });

    $(".chzn-select").chosen({allow_single_deselect: true});
  };

  initDateTime();
  var getFormData = function(formElementName, errorElementName) {
    var errorElementName = errorElementName || '#form-validation-error';
    errorElementName = formElementName + ' ' + errorElementName;
    var formData = {validated : true};
    $(formElementName + ' input[type!="submit"], ' + formElementName + ' select').each(function(index){
      var elementValidated = true;
      var validationMessage = '';
      // Get value
      var val = "";
      if ($(this).hasClass('time-entry')) {
        val = $(this).timeEntry('getTime');
      }
      else {
        val = $(this).val();
      }

      // Validate
      if ($(this).hasClass('required') && (val == "" || val == null)) {
        elementValidated = false;
        var missing = $(this).prop('placeholder') || $(this).data('placeholder') || "Missing Fields";
        validationMessage = 'Please Enter ' + missing;
      }
      if ($(this).data('minute-max-value') && val > $(this).data('minute-max-value')) {
        elementValidated = false;
        validationMessage = 'Maximum allowed is ' + $(this).data('minute-max-value');
      }

      if (elementValidated == false) {
         $(errorElementName + ' .error-message').text(validationMessage);
         $(errorElementName).show();
         $(this).parents('.control-group').addClass('error');
         formData.validated = false;
         return false;
      }
      else {
        $(this).parents('.control-group').removeClass('error');
        formData[$(this).prop('id')] = val;
      }
    });
    return formData;
  }

  var reloadData = function(elementName, loaderTarget, extraOpsPostLoad) {
    $(elementName).fadeOut('slow', function(){
          $(elementName).html('Please wait...');
          $(elementName).fadeIn('fast');
          $(elementName).load(loaderTarget, function(){
            $(elementName).fadeIn('slow');
            initDateTime();
            if (extraOpsPostLoad) {
              extraOpsPostLoad();
            }
          });
        });
  }

  //adding a score event for a game
  $("#addscore").live('submit', function() {
    // validate and process form
    // first hide any error messages
    $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
    var formData = getFormData('#addscore', '#form-validation-error');
    if (!formData || formData.validated == false) {
      return false;
    }

    var refresh = $("#refresh").val();
    var game_id = $("#game_id").val();
    var game_score = '/game_score.php?id=' + game_id;

    $.post('/add_score_process.php', {
      minute: formData.minute,
      type: formData.type,
      player: formData.player,
      game_id: game_id
    }, function(){
        reloadData('#scores', refresh);
        reloadData('#score', game_score);
      });
    return false;
  });


  //adding a sub event to a game
  $("#addsub").live('submit', function() {
    $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
    var formData = getFormData('#addsub', '#form-validation-error');
    if (!formData || formData.validated == false) {
      return false;
    }
    formData.subrefresh = $("#subrefresh").val();
    formData.game_id = $("#game_id").val();
    $.post('/add_sub_process.php', {
      submin: formData.submin,
      subtype: formData.subtype,
      player_on: formData.player_on,
      player_off: formData.player_off,
      game_id: formData.game_id
    }, function(){
      reloadData('#subs', formData.subrefresh);
    });

    return false;
  });



  //adding a card event to a game
  $("#addcard").live('submit', function() {
    $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
    var formData = getFormData('#addcard', '#form-validation-error');
    if (!formData || formData.validated == false) {
      return false;
    }

    formData.cardrefresh = $("#cardrefresh").val();
    formData.card_game_id = $("#card_game_id").val();

    $.post('/add_card_process.php', {
      cardmin: formData.cardmin,
      cardtype: formData.cardtype,
      cardplayer: formData.cardplayer,
      card_game_id: formData.card_game_id
    }, function(){
      reloadData('#cards', formData.cardrefresh);
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
          reloadData('#scores', refresh);
          reloadData('#score', game_score);

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
          reloadData('#subs', subDrefresh);
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
          reloadData('#cards', cardDrefresh);
        });

    return false;
    });


    //add a competition
    $("#addcomp").live('submit', function() {
      $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
      var formData = getFormData('#addcomp', '#form-validation-error');
      if (!formData || formData.validated == false) {
        return false;
      }
      else {
        return true;
      }
    });


    //hiding a competition
    $(".hidec").live('click', function() {

        var comprefresh = $("#comprefresh").val();
        var hId = $(":input").eq($(":input").index(this) + 1).val();

        $.post('/hide_comp_process.php',
        {id: hId},
        function(){
          reloadData('#comps', comprefresh);
        });

    return false;
    });


    //adding a game
    $("#addgame").live('submit', function() {
        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
        var formData = getFormData('#addgame', '#form-validation-error');

        if (!formData || formData.validated == false) {
          return false;
        }
        formData.koh = formData.ko_time.getHours();
        formData.kom = formData.ko_time.getMinutes();
        formData.grefresh = $("#grefresh").val();
        formData.comp_id = $("#comp_id").val();

        $.post('/add_game_process.php', {
          field: formData.field,
          gnum: formData.gnum,
          kdate: formData.kdate,
          koh: formData.koh,
          kom: formData.kom,
          home: formData.home,
          away: formData.away,
          comp_id: formData.comp_id
        }, function(){
            reloadData('#games', formData.grefresh);
        });
        return false;
    });



    //adding a team to a comp
    $("#addteam").live('submit', function() {

        // validate and process form
        // first hide any error messages
      $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
      var formData = getFormData('#addteam', '#form-validation-error');
     if (!formData || formData.validated == false) {
        return false;
      }
      var trefresh = $("#trefresh").val();
      var lrefresh = $("#lrefresh").val();
      var comp_id = $("#comp_id").val();
      $.post('/add_team_process.php', {
        team: formData.team,
        comp_id: comp_id
      }, function(){
          reloadData('#teams', trefresh);
          reloadData('#addteamdiv', lrefresh);
          reloadData('#addgamediv', '/add_game.php?id='+comp_id);
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
          reloadData('#games', refresh);
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
          reloadData('#teams', refresh);
          reloadData('#addteamdiv', '/add_team.php?id='+comp_id);
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
          reloadData('#signoff', srefresh);
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
             initDateTime();
             });

    return false;
    });


    //submit game edit info
    $("#eGame").live('click', function() {
    if(!confirm('Update game info as shown?')){return false;}
       $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();
        var formData = getFormData('#editgame', '#form-validation-error');

        if (!formData || formData.validated == false) {
          return false;
        }
        formData.koh = formData.ko_time.getHours();
        formData.kom = formData.ko_time.getMinutes();
        formData.comp_id = $("#comp_id").val();
        var refresh = '/game_info.php?id='+formData.game_id;
        $.post('/edit_game_info_process.php', {
          field: formData.field,
          gnum: formData.gnum,
          kdate: formData.kdate,
          koh: formData.koh,
          kom: formData.kom,
          game_id: formData.game_id
        }, function(){
            reloadData('#info', refresh);
          });
          return false;
        });


    //submit event roster edit info
    $("#ersubmit").live('click', function() {
    if(!confirm('Update roster?')){return false;}

        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();

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
          reloadData('#eroster', refresh);
        });

    return false;
    });


    //submit game roster info
    $("#grsubmit").live('click', function() {
    if(!confirm('Update roster?')){return false;}

        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();

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
          reloadData('#groster', refresh);
        });

    return false;
    });

    //submit game roster using previous game data
    $("#presubmit").live('click', function() {
    if(!confirm('Update roster?')){return false;}

        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();

            var comp_id = $("#comp_id").val();
            var game_id = $("#game_id").val();
            var team_id = $("#team_id").val();
            var roster_id = $("#roster_id").val();
            var refresh = '/edit_game_roster.php?gid='+game_id+'&tid='+team_id;

        $.post('/edit_game_roster_previous_process.php',
        {roster_id: roster_id, team_id: team_id, game_id: game_id, comp_id: comp_id},
        function(){
          reloadData('#groster', refresh);
        });

    return false;
    });



    //team to DB
    $("#teamadd").live('click', function() {
    if(!confirm('Add club to database?')){return false;}

        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();

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
          reloadData('#clublist', refresh);
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
          reloadData('#users', 'users_list.php');
        });

    return false;
    });




    //show edit info for users
            $(".eUser").live('click', function() {

            var eId = $(":input").eq($(":input").index(this) + 1).val();
           reloadData('#users', '/edit_user.php?id='+eId, function() {
             $('#useradd').hide();
           });

    return false;
    });


    //submit user edit info
    $("#eUserSubmit").live('click', function() {
    if(!confirm('Update user info as shown?')){return false;}

        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();

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
          reloadData('#users', 'users_list.php', function(){
            $('#useradd').show();
          });
        });

    return false;
    });


    //add new user
    $("#addUser").live('click', function() {
        $('.error').not(function(index){return $(this).hasClass('control-group');}).hide();

          var login = $("input#login").val();
          var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        if (login== "" || !pattern.test(login)) {
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

        $.post('/add_user_process.php',
        {login: login, team: team, access: access},
        function(data){
        if(data) alert(data);
          reloadData('#users', 'users_list.php');
        });

    return false;
    });

 });


