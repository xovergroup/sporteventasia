<?php 

include_once "inc/app-top.php"; 
include_once "../organizer/classes/CRUD.php"; 

$crud = new CRUD($mysqli);
$events = new CRUD($mysqli);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Merchandise List</title>
<?php include_once "inc/inc-css.php"; ?>
</head>

<body>

 <?php include_once "inc/inc-sidebar.php"; ?>

    <div class="main-body">
        <div class="main-background">
            <img src="../organizer/img/org-background.jpg">
            <div class="main-header">
                <div class="container-custom">
                    <?php include_once "inc/inc-header.php"; ?>
                    <img src="">
                    <div class="main-title">
                        <h2>Merchandise List</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="row">
                        
                        <div class="col-md">
                        	<div class="input-group">
                        		<div class="input-group">
                                	<input type="text" placeholder="Search Merchandise" class="form-control input-line-bottom event-name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-gray bg-white btn-block search-event"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="col-md-3">
                            <a href="merchandise-add.php" class="btn btn-red btn-block">Add Merchandise</a>
                        </div>
                    </div>
                </div>
                
                <?php 
                    $crud->sql = "SELECT * FROM `merchandises` ORDER BY `merchandises`.`merchandise_id` DESC LIMIT 10";
                    $crud->selectAll();
                    if($crud->total > 0){
                        while($row = $crud->result->fetch_object()){
                ?>
                <div class="content-box each-merchandise" data-merchandise="<?php echo $row->merchandise_id; ?>">
                	<div class="row mt-2">
                    	<div class="col-md-3">
                        	<img src="../img/merchandise.jpg">
                        </div>
                    	<div class="col-md-6">
                        	<h2><?php echo $row->merchandise_name; ?></h2>
                            <p class="text-secondary"><?php echo $row->merchandise_desc; ?></p>
                            <p class="text-danger font-weight-bold">RM<?php echo $row->merchandise_price; ?></p>
                        </div>
                        <div class="col-md-3">
                        	<a href="merchandise-edit.php?merchandise_id=<?php echo $row->merchandise_id; ?>" class="btn btn-red btn-block">Edit Merchandise</a>
                            <button type="button" class="btn btn-red-outline btn-block display-merchandise-modal" data-toggle="modal" data-target="#addToEvent">Add to Event</button>
                        </div>
                    </div>
                    <div class="row mt-3 merchandise-event-list">
                    	<span style="font-size:12px;" class="col-12">Event Added</span>
                        <?php 
                            $events->sql = "SELECT `events`.`event_id`, `events`.`event_name` FROM `merchandise_designate`, `events` WHERE `merchandise_designate`.`event_id` = `events`.`event_id` AND `merchandise_designate`.`merchandise_id` = ".$row->merchandise_id;
                            $events->selectAll();
                            if($events->total > 0){
                                while($event = $events->result->fetch_object()){
                        ?>
                        <p class="col-md-auto each-event"><span class="badge badge-light p-3 selected-event-for-merchandise" data-event="<?php echo $event->event_id; ?>"><?php echo $event->event_name; ?></span></p>
                        <?php } $events->result->close(); } ?>
                        
                    </div>
                </div>
                <?php } $crud->result->close(); } ?>
                
                
                
                <div class="mb-5">
                    <nav aria-label="Page navigation example">
                      <ul class="pagination  justify-content-center">
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>

                
                
                <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
        
        
    	</div>
    </div>
</div>

<div class="modal fade" id="addToEvent" tabindex="-1" role="dialog" aria-labelledby="addToEventLabel" aria-hidden="true" data-modal-merchandise="0">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToEventLabel">Add Lorem Merchandise to Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <h3><span aria-hidden="true">&times;</span></h3>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="input-group search-input-group">
                        <input type="text" class="form-control bg-gray search-event-input"  placeholder="Search" >
                        <span class="input-group-addon">
                            <button type="submit" class="bg-trans border-0">
                            <p><i class="fas fa-search"></i></p>
                            </button>  
                        </span>
                    </div>
                </div>
                <p class="small total-search-event"></p>
                <div class="">
                    <div class="modal-inner">
                        <div class="create-tag-box tag-box-event">
                        <!--
                        <input id="create-tag-1" type="checkbox">
                        <label for="create-tag-1">Lorem Ipsum Event</label>
                        <input id="create-tag-2" type="checkbox">
                        <label for="create-tag-2">Lorem Ipsum Event</label>
                        <input id="create-tag-3" type="checkbox">
                        <label for="create-tag-3">Lorem Event</label>
                        <input id="create-tag-4" type="checkbox">
                        <label for="create-tag-4">Lorem Event</label>
                        <input id="create-tag-5" type="checkbox">
                        <label for="create-tag-5">Lorem Event</label>
                        <input id="create-tag-6" type="checkbox">
                        <label for="create-tag-6">Lorem Event</label>
                        -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger col-12 save-event-merchandise" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
    
     <?php include_once "inc/inc-js.php"; ?>
     <script type="text/javascript" src="js/js-merchandise-list.js<?php echo '?'.mt_rand(); ?>"></script>
     <script type="text/javascript" src="js/js-local-storage.js<?php echo '?'.mt_rand(); ?>"></script>
</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>