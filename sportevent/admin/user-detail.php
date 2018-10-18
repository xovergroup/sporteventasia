<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>User Detail</title>
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
                        <h2>User Detail</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                	<p class="text-danger">Basic Information</p>
                    <div class="row mb-3">
                        <div class="col-2">
                            <img src="../img/Facebook_Color.png" class="">
                        </div>
                        <div class="col-md-3">
                            <label id="user-upload-label" class="mt-3"> Upload Profile
                                <input class="user-upload-btn" type='file' />
                            </label> 
                        </div>
                    </div>
                    <div class="content-box-row">
                        <label>User Name</label>
                        <input type="text">
                    </div>
                    <div class="content-box-row">
                        <label>NRIC</label>
                        <input type="text">
                    </div>
                    <div class="content-box-row">
                        <label>Contact</label>
                        <input type="text">
                    </div>
                    <div class="content-box-row">
                        <label>Email</label>
                        <input type="text">
                    </div>
                    <div class="row mb-3">
                    	<a href="" class="btn-red">Edit Profile</a>
                    </div>
                </div>
                
                <div class="content-box">
                	<p class="text-danger">Booking List</p>
                	<div class="table-responsive">
                    	<table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col-md"></th>
                              <th scope="col-md"></th>
                              <th scope="col-md"></th>
                              <th scope="col-md"></th>
                              <th scope="col-md"></th>
                              <th scope="col-md"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">0001</th>
                              <td class="">
                                <p>Group Male x 1</p>
                              	<p>Individual x 1</p>
                                <p>Lorem Merchandise</p>
                                <a href="booking-detail.php" class="small text-danger">View Detail</a>
                              </td>
                              <td><p>Lorem Ipsum Event Name</p></td>
                              <td>
                              	<p>4</p>
                              </td>
                              <td>
                                  <p>Azim Fauzi</p>
                              </td>
                              <td>
                              	<p>RM 49.90</p>
                              	<p class="text-success">Successful</p>
                              </td>
                            </tr>
                            <tr>
                              <th scope="">0002</th>
                              <td class="">
                                <p>Group Male x 1</p>
                              	<p>Individual x 1</p>
                                <p>Lorem Merchandise</p>
                                <a href="booking-detail.php" class="small text-danger">View Detail</a>
                              </td>
                              <td><p>Lorem Ipsum Event Name</p></td>
                              <td>
                              	<p>4</p>
                              </td>
                              <td>
                                  <p>Azim Fauzi</p>
                              </td>
                              <td>
                              	<p>RM 49.90</p>
                              	<p class="text-danger">Fail</p>
                              </td>
                            </tr>
                            
                          </tbody>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>
                
                
                
        <p class="copyright">© Copyright 2018 Sports Events House Sdn. Bhd. (1100784-A)</p>
        
    </div>
    
     <?php include_once "inc/inc-js.php"; ?>
</body>
</html>