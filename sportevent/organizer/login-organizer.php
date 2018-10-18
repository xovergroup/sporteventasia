<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login & Register</title>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>

<div id="login-page" style="background:whitesmoke;">
	<div class="org-login-logo">
    	<a href="../index.php"><img src="img/logo-orange.png" class=""></a>
    </div>
    <div id="org-login-form">
        <form id="loginform" method="post" action="submit-loginorganizer.php">
            <h2>For Organizer Login</h2>
            <label>E-mail Address</label>
            <input type="email" placeholder="Enter E-mail Address" name="organizer_email">
            <label>Password</label>
            <input type="password" placeholder="Enter Password" name="organizer_password">
            <button type="submit" class="org-login-button">Login</button>
        </form>
    </div>
</div>

<?php    
include "inc/inc-js.php";
?>

<script type="text/javascript">
	document.write('<link href="css/style.css?v='+ Math.floor(Math.random()*100) +'" rel="stylesheet" type="text/css" />');
	
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
    
       
    $('#loginform').validate({
      rules: {
        organizer_email: {
          required: true,
          email: true,
        },
        organizer_password: {
          required: true,
          minlength: 6,
        }
      },
      messages: {
        organizer_email: {
          required: 'This field is required',
          email: 'Enter a valid email'
        },
        organizer_password: {
          required: 'This field is required', 
          minlength: 'Password must be at least 8 characters long'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
    
    
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Warning", "Email / Password incorrect, please try again.", "error");
	<?php } ?>
    

});

</script>

<style>

    .error {
        color: red;
        padding-left: 5%;
        padding-bottom: 3%;
    }    
    
</style>
</body>
</html>
