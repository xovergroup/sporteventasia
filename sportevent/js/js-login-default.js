document.write('<link href="css/style.css?v='+ Math.floor(Math.random()*100) +'" rel="stylesheet" type="text/css" />');
	
//Registration Form JS

$(document).ready(function() {
  $(".signup").addClass("login-select");
  $(".register-tab").click(function() {
    var X = $(this).attr("id");

    if (X == "signup") {
      $("#login").removeClass("login-select");
      $("#signup").addClass("login-select");
      $("#loginbox").hide(300);
      $("#signupbox").show(300);
      $("#forgetbox").hide(300);
    } else {
      $("#signup").removeClass("login-select");
      $("#login").addClass("login-select");
      $("#signupbox").hide(300);
      $("#loginbox").show(300);
      $("#forgetbox").hide(300);
    }
  });

  $(".forgot-button").click(function(){
      $("#signupbox").hide(300);
      $("#loginbox").hide(300);
      $("#forgetbox").show(300);
  });
});
// Get the modal
var modal = document.getElementById('id01');
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}