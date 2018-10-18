<?php 
include "inc/app-top.php";
$user_id = $_SESSION['id'];

$_SESSION['page'] = "guest";

$guest_id = $_GET["id"];

    $sql_guest = "SELECT * FROM guest WHERE guest_id ='$guest_id'";        
    $query_guest = $mysqli->query($sql_guest);
    while($row_guest = $query_guest->fetch_assoc()) {
        
        $guest_name = $row_guest["guest_name"];
        $guest_email = $row_guest["guest_email"];
        $guest_ic = $row_guest["guest_ic"];
        $guest_ic_status = $row_guest["guest_ic_status"];
        $guest_gender = $row_guest["guest_gender"];
        $guest_contact = $row_guest["guest_contact"];
        $guest_country = $row_guest["guest_country"];
    }

$icprefix = substr($guest_ic,0,6);
$icmiddle = substr($guest_ic,6,2);
$icsuffix = substr($guest_ic,8,4);


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Guest</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    <link rel="stylesheet" href="libs/intlTelInput/css/intlTelInput.css">
    
    <div class="pt-5">
    	<div class="container">
        	<div class="row pt-5">
            
                <?php include_once "inc/side-nav.php"; ?>
                
                <div class="col-lg-9 ml-auto mb-5">
                	<div class="row no-gutters mb-3">
                		<h2 class="col">Edit Guest</h2>
               		</div>
                    
                    <form id="guestform" method="post" action="submit-guest-detail.php">
                        
                    <div class="event-news-box p-4 mb-3">
                         <div class="row mb-3">
                        	<div class="col-md-4">
                                <input type="text" name="guest_id" id="guest_id" value="<?php echo $guest_id; ?>" hidden>
                            	<h5>Name</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="text" class="col-md-11 bg-gray no-border p-2" placeholder="Name" name="guest_name" id="guest_name" value="<?php echo $guest_name; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>NRIC/Passport</h5>
                            </div>
                            <div class="col-md-8">        
                                
                                <select class="p-2 col-md-3 bg-gray no-border ic-format" name="guest_ic_status" id="guest_ic_status">
                                    <option value="1" <?php if($guest_ic_status == 1){ echo "selected"; } ?> >NRIC New</option>
                                    <option value="2" <?php if($guest_ic_status == 2){ echo "selected"; } ?> >NRIC Old</option>
                                    <option value="3" <?php if($guest_ic_status == 3){ echo "selected"; } ?> >Passport</option>
                                    <option value="4" <?php if($guest_ic_status == 4){ echo "selected"; } ?> >Police No</option>
                                </select>
                                
                                <span class="extra-space-ic-form"> </span>
                                                    
                                <?php if($guest_ic_status == 1){ ?>
                    
                                <input type="number" name="icprefix" id="icprefix" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-prefix" placeholder="991231" value="<?php echo $icprefix; ?>"> 
                                <span class="ic-form-hyphen"> - </span>
                                <input type="number" name="icmiddle" id="icmiddle" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-middle" placeholder="14" value="<?php echo $icmiddle; ?>"> 
                                <span class="ic-form-hyphen"> - </span>
                                <input type="number" name="icsuffix" id="icsuffix" class="col-md-8 bg-gray no-border p-2 ml-auto new-ic-format new-ic-suffix" placeholder="9999" value="<?php echo $icsuffix; ?>">
                                
                                <?php } else{ ?>
                                
                                <input type="text" class="col-md-8 bg-gray no-border p-2 ml-auto other-ic-format" name="guest_ic" id="guest_ic" value="<?php echo $guest_ic; ?>" placeholder="NRIC Old/ Passport / Police No">
                                
                                <?php } ?>
                             
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Gender</h5>
                            </div>
                            <div class="col-md-8">
                            	<select class="p-2 col-md-3 bg-gray no-border" name="guest_gender" id="guest_gender">
                                    <option value="Male" <?php if($guest_gender == "male"){ echo "selected"; } ?> >Male</option>
                                    <option value="Female" <?php if($guest_gender == "female"){ echo "selected"; } ?> >Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Email</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="text" class="col-md-11 bg-gray no-border p-2" placeholder="Email" name="guest_email" id="guest_email" value="<?php echo $guest_email; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                        	<div class="col-md-4">
                            	<h5>Contact Number</h5>
                            </div>
                            <div class="col-md-8">
                            	<input type="tel" class="col-md-11 bg-gray no-border p-2 input-tel" placeholder="Contact" name="guest_contact" id="phone" value="<?php echo $guest_contact; ?>">
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
      // hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: true,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
       preferredCountries: ['my'],
      // separateDialCode: true,
      nationalMode: false,
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
        
    $('#guestform').validate({
      rules: {
        guest_name: 'required',
        guest_email: {
          required: true,
          email: true,
        },
        guest_contact: {
          required: true,
        },
      },
      messages: {
        guest_name: 'This field is required',
        guest_email: {
          required: 'This field is required',
          email: 'Enter a valid email'
        },
        guest_contact: {
          required: 'This field is required',
        },
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
    
    
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Success", "Guest has been update successfully.", "success");
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

            html += `<input type="text" class="col-md-8 bg-gray no-border p-2 ml-auto other-ic-format" name="guest_ic" id="guest_ic" placeholder="NRIC Old/ Passport / Police No">
            `;
        }

        return html;
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
