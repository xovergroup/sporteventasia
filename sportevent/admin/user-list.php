<?php 

include_once "inc/app-top.php";

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User List</title>
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
                        <h2>User List</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="row">
                        <div class="col-md">
                            <select class="custom-select search-by" id="inputGroupSelect01">
                            	<option value="1" selected>Name</option>
                                <!--<option value="2">Organizer</option>-->
                            </select>
                        </div>
                        <div class="col-md-4">
                        	<div class="input-group">
                        		<div class="input-group">
                                	<input type="text" placeholder="Search organizer name" class="form-control input-line-bottom event-name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-gray bg-white btn-block search-event"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="col-md">
                            <button class="btn btn-red btn-block search-event">EXPORT</button>
                        </div>
                    </div>
                </div>
                
                <div class="content-box">
                	<div class="table-responsive">
                    	<table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col-md">No</th>
                              <th scope="col-md">Username</th>
                              <th scope="col-md">NRIC/Passport</th>
                              <th scope="col-md">Gender</th>
                              <th scope="col-md">Email</th>
                              <th scope="col-md">Contact</th>
                              <th scope="col-md">Booking</th>
                              <th scope="col-md">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">1</th>
                              <td class=""><p>Kelvin Tan Wei Kok</p></td>
                              <td><p>12345678890</p></td>
                              <td><p>Male</p></td>
                              <td><p>abcdefg@gmail.com</p></td>
                              <td><p>012345789</p></td>
                              <td><p>2</p></td>
                              <td><button type="button" class="bg-trans border-0 text-danger font-weight-bold" data-toggle="dropdown">...</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="user-detail.php">View Detail</a>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">2</th>
                              <td class=""><p>Kelvin Tan Wei Kok</p></td>
                              <td><p>12345678890</p></td>
                              <td><p>Male</p></td>
                              <td><p>abcdefg@gmail.com</p></td>
                              <td><p>012345789</p></td>
                              <td><p>2</p></td>
                              <td><button type="button" class="bg-trans border-0 text-danger font-weight-bold" data-toggle="dropdown">...</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="user-detail.php">View Detail</a>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">3</th>
                              <td class=""><p>Kelvin Tan Wei Kok</p></td>
                              <td><p>12345678890</p></td>
                              <td><p>Male</p></td>
                              <td><p>abcdefg@gmail.com</p></td>
                              <td><p>012345789</p></td>
                              <td><p>2</p></td>
                              <td><button type="button" class="bg-trans border-0 text-danger font-weight-bold" data-toggle="dropdown">...</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a class="dropdown-item" href="user-detail.php">View Detail</a>
                                  <a class="dropdown-item text-danger" href="#">Delete</a>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
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
    
     <?php include_once "inc/inc-js.php"; ?>
</body>
</html>