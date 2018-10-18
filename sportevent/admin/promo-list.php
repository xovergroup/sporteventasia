<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Promo Code List</title>
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
                        <h2>Promo Code List</h2>
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
                                	<input type="text" placeholder="Search Promo Code" class="form-control input-line-bottom event-name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-gray bg-white btn-block search-event"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="col-md-3">
                            <a href="promo-add.php" class="btn btn-red btn-block">Add Promo Code</a>
                        </div>
                    </div>
                </div>
                
                <div class="content-box">
                	<div class="row mt-2">
                    	<div class="col-md-9">
                        	<h2>PROMO1234 <span style="font-weight:400; font-size:14px;">Quantity: 100 / Used: 23</span></h2>
                            <p class="text-secondary">2018-01-01 to 2018-02-02</p>
                            <p class="text-danger">Discount 20% per group</p>
                        </div>
                        <div class="col-md-3">
                        	<a href="promo-add.php" class="btn btn-red btn-block">Edit Promo Code</a>
                            <button type="button" class="btn btn-red-outline btn-block" data-toggle="modal" data-target="#exampleModal">Add to Event</button>
                        </div>
                    </div>
                    <div class="row">
                    	<span style="font-size:12px;" class="col-12">Event Added</span>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                    </div>
                </div>
                
                <div class="content-box">
                	<div class="row mt-2">
                    	<div class="col-md-9">
                        	<h2>PROMO1234 <span style="font-weight:400; font-size:14px;">Quantity: 100 / Used: 23</span></h2>
                            <p class="text-secondary">2018-01-01 to 2018-02-02</p>
                            <p class="text-danger">Discount 20% per group</p>
                        </div>
                        <div class="col-md-3">
                        	<a href="promo-add.php" class="btn btn-red btn-block">Edit Promo Code</a>
                            <button class="btn btn-red-outline btn-block">Add to Event</button>
                        </div>
                    </div>
                    <div class="row">
                    	<span style="font-size:12px;" class="col-12">Event Added</span>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                        <p class="col-md-auto"><span class="badge badge-light p-3">Lorem Ipsum Event</span></p>
                    </div>
                </div>
                
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
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add PROMO1234 to Event or Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <h3><span aria-hidden="true">&times;</span></h3>
            </button>
          </div>
          <div class="modal-body">
            <div class="">
            	<div class="input-group search-input-group">
                    <input type="text" class="form-control bg-gray"  placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="submit" class="bg-trans border-0">
                            <p><i class="fas fa-search"></i></p>
                        </button>  
                    </span>
                </div>
            </div>
            <p class="small">6 Results</p>
            <div class="">
                <div class="modal-inner">
                    <div class="create-tag-box">
                        <input id="create-tag-1" type="checkbox">
                        <label for="create-tag-1">Lorem Ipsum Event</label>
                        <input id="create-tag-2" type="checkbox">
                        <label for="create-tag-2">Lorem Ipsum Event(ABC Category)</label>
                        <input id="create-tag-3" type="checkbox">
                        <label for="create-tag-3">Lorem Event(ABC Category)</label>
                        <input id="create-tag-4" type="checkbox">
                        <label for="create-tag-4">Lorem Event(ABC Category)</label>
                        <input id="create-tag-5" type="checkbox">
                        <label for="create-tag-5">Lorem Event</label>
                        <input id="create-tag-6" type="checkbox">
                        <label for="create-tag-6">Lorem Event(ABC Category)</label>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger col-12">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
     <?php include_once "inc/inc-js.php"; ?>
</body>
</html>