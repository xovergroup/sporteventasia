<?php 

include_once "inc/app-top.php";
include_once "classes/CRUD.php";

$crud = new CRUD($mysqli);


if(isset($_GET["event_id"]) && !empty($_GET["event_id"])){
    $event_id = $crud->sanitizeInt($_GET["event_id"]);
    
    $crud->sql = "SELECT * FROM events WHERE event_id = ".$event_id;
    $the_event = $crud->selectOne();
    
} else {
    header("Location: create-event-page-1.php");
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>Create Event 2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php include_once "inc/inc-css.php"; ?>

</head>
<body>


<div>

<?php include_once "inc/inc-sidebar.php"; ?>

<div class="main-body">
    <div class="main-background">
        <img src="img/org-background.jpg">
        <div class="main-header">
        	<div class="container-custom">
            	<?php include_once "inc/inc-header.php"; ?>
                <img src="">
                <div class="main-title">
                    <h2>Create Event</h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-content">
    	<div class="container-custom">
        
    		<div class="content-box">
            	<div class="create-step-box">
                	<div class="circular-num-gray">1</div>
                	<h5>General Information</h5>
                </div>
                <div class="create-step-box">
                	<div class="circular-num-red">2</div>
                	<h5 style="color:#e04e3d;">Race Kit & Other Information</h5>
                </div>
                <div class="create-step-box">
                	<div class="circular-num">3</div>
                	<h5>Category Types & Registration Form</h5>
                </div>
            </div>
            
            
            <input type="hidden" id="event-id" value="<?php echo $event_id; ?>">
            <div class="content-box">
            	<div class="content-box-header">
                	<label>Race Kit Information</label>
                	<input type="hidden" class="db-racekit" value="<?php echo html_entity_decode($the_event->event_racekit);?>">
                </div>
            	<div class="content-box-row">
                    
                	<div id="editor" class="editor-racekit"></div>
                </div>
            </div>
            
            <div class="content-box">
            	<div class="content-box-header">
                	<label>Other Information</label>
                	<input type="hidden" class="db-other-info" value="<?php echo html_entity_decode($the_event->event_other_information);?>">
                </div>
            	<div class="content-box-row">
                	<div id="editor2" class="editor-otherInfo"></div>
                </div>
            </div>
            
            
            
            <div class="content-box">
            	<div class="">
                	<button class="btn-dgray save-racekit-otherinfo">Save</button>
                    <a href="create-event-page-1.php?event_id=<?php echo $event_id; ?>" class="btn-gray">Back</a>
                    <a href="create-event-page-3.php?event_id=<?php echo $event_id; ?>" class="btn-red float-right">Next</a>
                    <a href="../event-detail.php?event_id=<?php echo $event_id; ?>" class="btn-green float-right">Preview</a>
                </div>
            </div>
            <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
            
        </div>
    </div>
</div>

    
</div>


<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript">
    
var toolbarOptions = [['bold', 'italic', 'underline'], ['link', 'image']];
var raceKitEditor = new Quill('.editor-racekit', {
	theme: 'snow',
	modules: {
		toolbar: toolbarOptions
	}
});

var toolbarOptions = [['bold', 'italic', 'underline'], ['link', 'image']];
var otherInfoEditor = new Quill('.editor-otherInfo', {
	theme: 'snow',
	modules: {
		toolbar: toolbarOptions
	}
});

</script>

<script type="text/javascript" src="js/organizer-app.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/organizer-custom.js<?php echo '?'.mt_rand(); ?>"></script>







</body>
</html>
