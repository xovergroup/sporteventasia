<?php

$user_unique_id = $_GET["id"];

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
    
<?php include "inc/inc-css.php";?>

</head>

<body style="background:whitesmoke;">

<div id="register-id">
    <div id="register-box">
    	<a href="index.php"><img src="img/logo-orange.png" class="signup-form-logo"></a>
        <div id="panel">
            <div id="signupbox">
				<h2>Reset Password</h2>
                <form id="resetform" method="post" action="submit-resetpassword.php">
                    <input type="text" name="user_unique_id" value="<?php echo $user_unique_id; ?>" hidden>
                    <input type="password" placeholder="Enter New Password" name="user_password">
                    <button type="submit" value="submit" class="button-login">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php    
include "inc/inc-js.php";
?>    

<script type="text/javascript">
	document.write('<link href="css/style.css?v='+ Math.floor(Math.random()*100) +'" rel="stylesheet" type="text/css" />');
	
</script>
    
<script type="text/javascript">

$(document).ready(function() {
    
       
    $('#resetform').validate({
      rules: {
        user_password: {
          required: true,
          minlength: 6,
        }
      },
      messages: {
        user_password: {
          required: 'This field is required', 
          minlength: 'Password must be at least 6 characters long'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    }); 

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
