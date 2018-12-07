$(document).ready(function () {

/*###############################################*/ 
/*##### Toggle Login and Registration form  #####*/ 
/*###############################################*/ 

  if ($('#login-form').show()){  
    $('#login').css('background', 'rgba(36, 250, 161, 0.74)'); 
  }
  $('#login,#login-trigger').click(function(){
    $('#login').css('background', 'rgba(36, 250, 161, 0.74)'); 
    $('#regform').css('background', 'rgba(36, 130, 161, 0.9)'); 
    $('#login-form').show();
    $('#reg-form').hide();
  });
  $('#regform,#register-trigger').click(function(){
    $('#regform').css('background', 'rgba(36, 250, 161, 0.74)');
    $('#login').css('background', 'rgba(36, 130, 161, 0.9)'); 
    $('#reg-form').show();
    $('#login-form').hide();
  });

  // $('[data-toggle="tooltip"]').tooltip();
  // $('[data-toggle="popover"]').popover();
  // $('.carousel').carousel();
});