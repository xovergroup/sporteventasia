<?php 
include "inc/app-top.php";
$user_id = $_SESSION['id'];

$_SESSION['page'] = "profile";

    $sql_user = "SELECT * FROM users WHERE user_id ='$user_id'";        
    $query_user = $mysqli->query($sql_user);
    while($row_user = $query_user->fetch_assoc()) {
        
        $user_id = $row_user["user_id"];
        $user_full_name = $row_user["user_full_name"];
        $user_email = $row_user["user_email"];
        $user_ic = $row_user["user_ic"];
        $user_ic_status = $row_user["user_ic_status"];
        $user_gender = $row_user["user_gender"];
        $user_contact = $row_user["user_contact"];
        $user_full_contact = $row_user["user_full_contact"];
        $user_picture = $row_user["user_picture"];
    }

$icprefix = substr($user_ic,0,6);
$icmiddle = substr($user_ic,6,2);
$icsuffix = substr($user_ic,8,4);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Profile</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
     <link rel="stylesheet" href="libs/intlTelInput/css/intlTelInput.css">
    
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    <div class="pt-5">
    	<div class="container">
        	<div class="row pt-5">
                
                <?php include_once "inc/side-nav.php"; ?>
                
                <div class="col-lg-9 ml-auto mb-5">
                    <h2>Edit Profile</h2>
                    
                    <form id="userprofileform" method="post" action="submit-userprofile.php">
                        
                    <div class="event-news-box p-4 mb-3">
                        <p class="txt-orange mb-2">Basic Information</p>
                        <div class="row mb-3">
                        	<div class="col-2">
                            	<img src="<?php if(empty($user_picture)){ echo 'img/profile/Facebook_Color.png'; }else { echo $user_picture; } ?>" class="profileimage">
                            </div>
                            <div class="col-md-3">
                                <label id="user-upload-label" class="mt-3"> Upload Profile
                                	<input class="user-upload-btn" type="file" name="$user_picture" id="$user_picture" />
                                </label> 
                            	
                            </div>
                        </div>
                                <input type="text" name="user_id" id="user_id" value="<?php echo $user_id; ?>" hidden>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Name</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="text" class="col-md-11 bg-gray no-border p-2" name="user_full_name" id="user_full_name" value="<?php echo $user_full_name; ?>" placeholder="Name">
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>NRIC/Passport</h5>
                            </div>
                            <div class="col-md-8">
                            	<select class="p-2 col-md-3 bg-gray no-border ic-format" name="user_ic_status" id="user_ic_status">
                                    <option value="1" <?php if($user_ic_status == 1){ echo "selected"; } ?> >NRIC New</option>
                                    <option value="2" <?php if($user_ic_status == 2){ echo "selected"; } ?> >NRIC Old</option>
                                    <option value="3" <?php if($user_ic_status == 3){ echo "selected"; } ?> >Passport</option>
                                    <option value="4" <?php if($user_ic_status == 4){ echo "selected"; } ?> >Police No</option>
                                </select>
                                
                                <span class="extra-space-ic-form"> </span>
                                
                                <?php if($user_ic_status == 1){ ?>
                    
                                <input type="number" name="icprefix" id="icprefix" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-prefix" placeholder="991231" value="<?php echo $icprefix; ?>"> 
                                <span class="ic-form-hyphen"> - </span>
                                <input type="number" name="icmiddle" id="icmiddle" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-middle" placeholder="14" value="<?php echo $icmiddle; ?>"> 
                                <span class="ic-form-hyphen"> - </span>
                                <input type="number" name="icsuffix" id="icsuffix" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-suffix" placeholder="9999" value="<?php echo $icsuffix; ?>">
                                
                                <?php } else{ ?>
                                
                                <input type="text" class="col-md-8 bg-gray no-border p-2 ml-auto other-ic-format" name="user_ic" id="user_ic" value="<?php echo $user_ic; ?>" placeholder="NRIC Old/ Passport / Police No">
                                
                                <?php } ?>
                                
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Gender</h5>
                            </div>
                            <div class="col-md-8">
                            	<select class="p-2 col-md-3 bg-gray no-border" name="user_gender" id="user_gender">
                                    <option value="male" <?php if($user_gender == "male"){ echo "selected"; } ?> >Male</option>
                                    <option value="female" <?php if($user_gender == "female"){ echo "selected"; } ?> >Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Email</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="text" class="col-md-11 bg-gray no-border p-2" name="user_email" id="user_email" value="<?php echo $user_email; ?>" placeholder="Email">
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Contact Number</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="tel" class="col-md-11 bg-gray no-border p-2 input-tel required customphone" name="user_contact" id="phone" value="<?php echo $user_full_contact; ?>" placeholder="Contact">
                            </div>
                        </div>
                    </div>
                    <div class="event-news-box p-4 mb-3">
                        <p class="txt-orange mb-2">Security Information</p>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Current Password</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="password" class="col-md-11 bg-gray no-border p-2" name="user_password" id="user_password" placeholder="Current Password">
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>New Password</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="password" class="col-md-11 bg-gray no-border p-2" name="user_new_password" id="user_new_password" placeholder="New Password">
                            </div>
                        </div>
                    </div>
                    <button class="font-dagger bg-red txt-white p-3 col-md-3 no-border">SAVE CHANGES</button>
                    
                    </form>
                </div>
                    
            </div>
        </div>
        
    </div>
    
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

    <script src="libs/intlTelInput/js/intlTelInput.js"></script>

<?php include_once "inc/inc-js.php"; ?>

<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>    
    
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

$(document).ready(function(form) {
    
    $('body').on('change', '.ic-format', icFormat);
    $('body').on('keyup', '.new-ic-prefix', prefixIcFormat);
    $('body').on('keyup', '.new-ic-middle', middleIcFormat);
    $('body').on('keyup', '.new-ic-suffix', suffixIcFormat); 
    
    $(".user-upload-btn").on("change", showPreviewProfilePicture);
    
    $.validator.addMethod('customphone', function (value, element) {
        return this.optional(element) || /^[0-9-]*$/.test(value);
    }, "Please enter a valid phone number");
    
    $('#userprofileform').validate({
      rules: {
        user_full_name: 'required',
        user_email: {
          required: true,
          email: true,
        },
        user_ic: {
          required: true,
          number: true,
        },
        user_contact: 'customphone',
        user_password: {
          required: {
                depends: function(element){
                    if ($('#user_new_password').val() != '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
          minlength: 6,    
        },
        user_new_password: {
          required: {
                depends: function(element){
                    if ($('#user_password').val() != '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
          minlength: 6  
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
          number: 'Enter a valid NRIC New or Old/ Passport / Police No'
        },
        user_password: {
          required: 'This field is required', 
          minlength: 'Password must be at least 6 characters long'
        },
        user_new_password: {
          required: 'This field is required', 
          minlength: 'Password must be at least 6 characters long',
          equalTo: 'Confirm password not equal with password'
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
    
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Success", "Your profile and password has been updated successfully.", "success");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 2) {?>
	swal("Success", "Your profile has been updated successfully.", "success");
	<?php } else if(isset($_GET["msg"]) && intval($_GET["msg"]) == 3) {?>
	swal("Warning", "Current password is not corect.", "error");
	<?php } ?>
    
    window.history.replaceState(null, null, window.location.pathname);
    
}); 
    

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

    function generateIcInput(format, ){

        var html = ``;
        if(format == 1){
            html += `
                    <input type="number" name="icprefix" id="icprefix" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-prefix" placeholder="991231"> 
                    <span class="ic-form-hyphen"> - </span>
                    <input type="number" name="icmiddle" id="icmiddle" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-middle" placeholder="14"> 
                    <span class="ic-form-hyphen"> - </span>
                    <input type="number" name="icsuffix" id="icsuffix" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-suffix" placeholder="9999">
            `;
        } else {

            html += `<input type="text" class="col-md-8 bg-gray no-border p-2 ml-auto other-ic-format" name="user_ic" id="user_ic" placeholder="NRIC Old/ Passport / Police No">
            `;
        }

        return html;
    }
    
    
function showPreviewProfilePicture(){
    
    var $input = $(this);
    var inputFiles = this.files;
    if(inputFiles == undefined || inputFiles.length == 0) return;
    var inputFile = inputFiles[0];

    var reader = new FileReader();
    reader.onload = function(event) {

        $input.parent().parent().prev().find(".profileimage").attr("src", event.target.result);
        
        upload_image(event.target.result);

    };
    reader.onerror = function(event) {
        alert("I AM ERROR: " + event.target.error.code);
    };
    reader.readAsDataURL(inputFile);
       
}    

    
function getImageInformation(className){
    
    var imageSrc = $(className).attr("src");
    
    return imageSrc;
    
}
    
    
function upload_image(image64coded){
    
    var user_id = $("#user_id").val();
    var profile_picture = image64coded;
    
    console.log(image64coded);
    
   $.ajax({
        type: "POST",
        url: "submit-profile-picture.php",
        data: {
            user_id:user_id,
            profile_picture:profile_picture
        },
        dataType:'JSON', 
        success: function(result){

            console.log(result);
        } 
    });
}

</script>
    
<style>

    .error {
        color: red;
        padding-left: 5%;
        font-size: 14px;
    }    
    
    .new-ic-prefix {
        width: 27% !important;
        display: inline-block;
    }
    .new-ic-middle {
        width: 12.5% !important;
        display: inline-block;
    }
    .new-ic-suffix {
        width: 22% !important;
        display: inline-block;
    }
    
    .ic-form-hyphen {
        display: inline-block;
    }
    
    .iti-flag {
        background-image: url("libs/intlTelInput/img/flags.png");
        margin-left: 15px !important;
    }
 
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
      .iti-flag {background-image: url("libs/intlTelInput/img/flags@2x.png");}
    }
    
    .intl-tel-input {
        padding-top: 15px;
    }
    
    .flag-container {
        padding-top: inherit !important;
    }
    
    .input-tel {
        text-indent: 100px;
    }
    
    .intl-tel-input {
        width: 100%;
        padding-top: 0px;
    }
    
    .selected-flag {
        width: 80px !important;
        height: 30px !important;
    }
    
    .flag-box {
        width: 70px !important;
    }
    
</style>    
    
</body>
</html>
