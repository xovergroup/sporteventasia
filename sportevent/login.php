<?php

session_start();

$user_fbid = $_SESSION['fbid'];
$user_email = $_SESSION['email'];
//$user_fname = $_SESSION['fname'].' '.$_SESSION['lname'];
$user_fname = $_SESSION['fname'];
$user_picture = $_SESSION['picture'];

session_destroy(); 
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login & Register</title>
    
<?php include "inc/inc-css.php";?>
    
  <link rel="stylesheet" href="libs/intlTelInput/css/intlTelInput.css">
    
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>

<div id="register-id" style="background:whitesmoke;">
    <div id="register-box">
    	<a href="index.php"><img src="img/logo-orange.png" class="signup-form-logo"></a>
        <div id="register-tabbox">
            <a href="#" id="signup" class="register-tab signup">Register</a>
            <a href="#" id="login" class="register-tab ">Login</a>
        </div>
        
        <div id="panel">
            <div id="signupbox">
                <div id="">
                    <button class="loginBtn loginBtn-facebook" onclick="fbsign()">
                      Register with Facebook
                    </button>
                    <button class="loginBtn loginBtn-google">
                      Register with Google
                    </button>
                </div>
                <p>Or, login with</p>

                <form id="signupform" method="post" action="submit-register.php">

                    <input type="text" name="user_fb_id" value="<?php echo $user_fbid; ?>" hidden>
                    <input type="text" name="user_picture" value="<?php echo $user_picture; ?>" hidden>
                    
                    <label>Full-Name</label>
                    <input type="text" placeholder="Enter Name" name="user_full_name" id="user_full_name" value="<?php echo $user_fname; ?>" >
                    <label>E-mail Address</label>
                    <input type="email" placeholder="Enter Email" name="user_email" id="user_email" value="<?php echo $user_email; ?>">
                    <label>Password</label>
                    <input type="password" placeholder="Enter Password" name="user_password" id="user_password">
                    <label>Repeat Password</label>
                    <input type="password" placeholder="Repeat Password" name="user_password_repeat" id="user_password_repeat">
                               
                    <label>NRIC New or Old/ Passport / Police No</label>
                    
                    <div class="icinput">
                        <select name="user_ic_status" id="user_ic_status" class="input1 ic-format">
                            <option value="1">NRIC New</option>
                            <option value="2">NRIC Old</option>
                            <option value="3">Passport</option>
                            <option value="4">Police No</option>
                        </select>

                        <span class="extra-space-ic-form"> </span>

                        <input type="number" name="icprefix" id="icprefix" class="nric-input new-ic-format new-ic-prefix" placeholder="991231"> 
                        <span class="ic-form-hyphen"> - </span>
                        <input type="number" name="icmiddle" id="icmiddle" class="nric-input new-ic-format new-ic-middle" placeholder="14"> 
                        <span class="ic-form-hyphen"> - </span>
                        <input type="number" name="icsuffix" id="icsuffix" class="nric-input new-ic-format new-ic-suffix" placeholder="9999">
                    </div>
                    
                    <label>Contact Number</label>
                    <input type="tel" name="user_contact" id="phone" class="input-tel required customphone">
                    <div class="recaptcha-div">
                    
                      <div class="g-recaptcha" data-sitekey="6LcI3f8SAAAAAKE4JS5c96MsophLaYK56lKs-ldk"></div>
                    
                    </div>
                
                    <button type="submit" value="submit" class="button-login">Sign Up</button>

                </form>

                <p>By creating an account you agree to our <a href="#" class="txt-orange">Terms & Privacy</a>.</p>
            </div>
            <div id="loginbox">
                <div id="">
                    <button href="fbconfig.php" class="loginBtn loginBtn-facebook" onclick="fbsign()">
                      Login with Facebook
                    </button>
                    <button class="loginBtn loginBtn-google">
                      Login with Google
                    </button>
                </div>
                <p>Or, login with</p>

                <form id="loginform" method="post" action="submit-login.php">

                    <label>E-mail Address</label>
                    <input type="email" placeholder="Enter E-mail Address" name="user_email" id="user_email">
                    <label>Password</label>
                    <input type="password" placeholder="Enter Password" name="user_password" id="user_password">
                    <a href="#" class="forgot-button">Forgot Password?</a>
                    <button type="submit" value="submit" class="button-login">Login</button>

                </form>
                    
            </div>
          <div id="forgetbox">
                <h3>Forgot Password</h3>

                <form id="fotgotform" method="post" action="submit-forgotpassword.php">
                    
                    <input type="email" placeholder="Enter Email" name="user_email" id="user_email">
                    <button type="submit" value="submit" class="button-login">Submit</button>

                </form>
                    
            </div>
        </div>
    </div>
</div>




  <script src="libs/intlTelInput/js/intlTelInput.js"></script>
<?php 
require_once 'googleconfig.php';
require_once 'lib/Google_Client.php';
require_once 'lib/Google_Oauth2Service.php';    
include "inc/inc-js.php";
?>
<script type="text/javascript" src="js/js-login-default.js<?php echo '?'.mt_rand(); ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  
<script type="text/javascript" src="js/oauthpopup.js"></script>

 

<script>
  var input = document.querySelector("#phone");
  window.intlTelInput(input, {
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
       hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
       preferredCountries: ['my'],
      // separateDialCode: true,
      nationalMode: true,
      autoHideDialCode: true,
      utilsScript: "libs/intlTelInput/js/utils.js",
    });
</script> 
    
<script type="text/javascript">

$(document).ready(function() {
    
    $('body').on('change', '.ic-format', icFormat);
    $('body').on('keyup', '.new-ic-prefix', prefixIcFormat);
    $('body').on('keyup', '.new-ic-middle', middleIcFormat);
    $('body').on('keyup', '.new-ic-suffix', suffixIcFormat);    
    

    $(".input-field-dropdown").selectmenu().selectmenu("menuWidget").addClass("find-field-overflow");
    
    $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^[0-9-]*$/.test(value);
    }, "Please enter a valid phone number");

    
    $('#signupform').validate({
      rules: {
        user_full_name: 'required',
        user_email: {
          required: true,
          email: true,
        },
        user_ic: {
          required: true,
        },         
        icsuffix: {
          required: {    
              depends: function(element){
                        if ($('#icprefix').val() != '') {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
          number: true,
        },  
        user_contact: 'customphone',
        user_password: {
          required: true,
          minlength: 6,
        },
        user_password_repeat: {
          required: true,
          minlength: 6,
          equalTo: "#user_password"
        }
      },
      messages: {
        user_full_name: 'This field is required',
        user_email: {
          required: 'This field is required',
          email: 'Enter a valid email'
        },
        user_ic: {
          required: 'This field is required',
        },
        icsuffix: {
          required: 'This field is required',
          number: 'Enter a valid new Nric number'    
        },
        user_password: {
          required: 'This field is required', 
          minlength: 'Password must be at least 6 characters long'
        },
        user_password_repeat: {
          required: 'This field is required', 
          minlength: 'Password must be at least 6 characters long',
          equalTo: 'Confirm password not equal with password'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
       
    $('#loginform').validate({
      rules: {
        user_email: {
          required: true,
          email: true,
        },
        user_password: {
          required: true,
          minlength: 6,
        }
      },
      messages: {
        user_email: {
          required: 'This field is required',
          email: 'Enter a valid email'
        },
        user_password: {
          required: 'This field is required', 
          minlength: 'Password must be at least 6 characters long'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
    
    $('#fotgotform').validate({
      rules: {
        user_email: {
          required: true,
          email: true,
        }
      },
      messages: {
        user_email: {
          required: 'This field is required',
          email: 'Enter a valid email'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
    
    
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Error", "Please check on the reCaptcha checkbox before submit.", "error");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 2) {?>
	swal("Error", "ReCaptcha verification expired, please re-check again the reCaptcha checkbox.", "error");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 3) {?>
	swal("Warning", "Email already registered, please try other email.", "error");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 4) {?>
	swal("Warning", "Register fail, please try again.", "error");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 5) {?>
	swal("Warning", "Email / Password incorrect, please try again.", "error");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 6) {?>
	swal("Info", "Please check your email for password recovery", "info");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 7) {?>
	swal("Warning", "Email incorrect, please try again.", "error");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 8) {?>
	swal("Success", "Password has been reset successfully.", "success");
	<?php } ?>
    
    window.history.replaceState(null, null, window.location.pathname);
    
    $('button.loginBtn-google').oauthpopup({
            path: '<?php if(isset($authUrl)){echo $authUrl;}else{ echo '';}
      //unset($_SESSION['token']);
      //$client->revokeToken();
      ;
      ?>',
      width:650,
      height:350,
    });
    

});

    function fbsign(){
        window.location="fbconfig.php";
    }
    
    
    function suffixIcFormat(){
    
        var input               = $(this);
        var inputValue          = $(this).val();
        var inputValueLength    = $(this).val().length;

        if(inputValueLength > 4){
            var limit = inputValue.substring(0,4);
            input.val(limit);
        }
    }

    function middleIcFormat(){

        var input               = $(this);
        var inputValue          = $(this).val();
        var inputValueLength    = $(this).val().length;

        if(inputValueLength > 2){
            var limit = inputValue.substring(0,2);
            input.val(limit);
        }
    }

    function prefixIcFormat(){

        var input               = $(this);
        var inputValue          = $(this).val();
        var inputValueLength    = $(this).val().length;

        if(inputValueLength > 6){
            var limit = inputValue.substring(0,6);
            input.val(limit);
        }
    }

    function icFormat(){

        var format = parseInt($(this).find(':selected').val());

        var container = $(this).parent();
        container.find('.new-ic-format').remove();
        container.find('.other-ic-format').remove();
        container.find('.ic-form-hyphen').remove();

        var html            = generateIcInput(format);
        var spaceElement    = container.find('.extra-space-ic-form');
        $(html).insertAfter(spaceElement);


    }

    function generateIcInput(format){

        var html = ``;
        if(format == 1){
            html += `
                    <input type="number" name="icprefix" id="icprefix" class="nric-input new-ic-format new-ic-prefix" placeholder="991231"> 
                    <span class="ic-form-hyphen"> - </span>
                    <input type="number" name="icmiddle" id="icmiddle" class="nric-input new-ic-format new-ic-middle" placeholder="14"> 
                    <span class="ic-form-hyphen"> - </span>
                    <input type="number" name="icsuffix" id="icsuffix" class="nric-input new-ic-format new-ic-suffix" placeholder="9999">
            `;
        } else {

            html += `<input type="text" placeholder="Enter NRIC Old/ Passport / Police No" name="user_ic" id="user_ic" class="nric-input other-ic-format">
            `;
        }

        return html;
    }
    

</script>

<style>

    .error {
        color: red;
        padding-left: 5%;
        padding-bottom: 3%;
    }  
    
    .iti-flag {
        background-image: url("libs/intlTelInput/img/flags.png");
        margin-left: 15px !important;
    }
 
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
      .iti-flag {background-image: url("libs/intlTelInput/img/flags@2x.png");}
    }
    
/*
    .intl-tel-input {
        padding-top: 15px;
    }
*/
    
    .intl-tel-input {
        width: 100%;
        padding-top: 15px;
    }
    
    .flag-container {
        padding-top: inherit !important;
    }
    
    .input-tel {
        text-indent: 100px;
    }
    
    .selected-flag {
        width: 80px !important;
        height: 60px !important;
    }
    
    .flag-box {
        width: 70px !important;
    }
    
    .input1 {
        width: 27% !important;
    }
    .new-ic-prefix {
        width: 27% !important;
        display: inline-block;
    }
    .new-ic-middle {
        width: 15% !important;
        display: inline-block;
    }
    .new-ic-suffix {
        width: 25% !important;
        display: inline-block;
    }
    
    .ic-form-hyphen {
        display: inline-block;
    }
    
    .other-ic-format {
        width: 72% !important;
    }
    
    .icinput {
        width: 100%;
        background: #ffffff;
    }
    
</style>

</body>
</html>













