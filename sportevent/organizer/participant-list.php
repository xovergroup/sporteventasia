<?php 

include_once "inc/app-top.php";
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Participants</title>
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
                        <h2>Participants</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="container-custom">

                <div class="content-box">
                    <div class="row mt-1">
                        <div class="col-md-3">
                            <select class="custom-select" id="inputGroupSelect01">
                            	<option selected>Lorem Ipsum Event</option>
                                <option>Dolor Sit Amet Event</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                        	<div class="input-group mb-1">
                        		<div class="input-group">
                                	<input type="text" placeholder="Search participants name" class="form-control input-line-bottom">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button class="btn-gray"><i class="fas fa-search"></i></button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn-red">EXPORT</button>
                        </div>
                    </div>
                </div>


                <div class="content-box">
                	<div class="table-responsive">
                    	<table class="table table-striped">
                          <thead>
                            <tr>
                              <th scope="col-md">No</th>
                              <th scope="col-md">Participant Info</th>
                              <th scope="col-md">Event</th>
                              <th scope="col-md">Booking Info</th>
                              <th scope="col-md">Emergency Person</th>
                              <th scope="col-md">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th scope="row">1</th>
                              <td class="">
                              	<b>Azmir Abdul Wahab</b>
                                <p>NRIC/Passport:123456789</p>
                              	<p>Email: 123123@gmail.com</p>
                                <p>Contact: 12345678</p>
                                <p>Gender:Male</p>
                              	<p>T-shirt: Large</p>
                              </td>
                              <td><p>Lorem Ipsum Event Name</p></td>
                              <td>
                              	<p>Group Male</p>
                              	<p>Booking No: 000001</p>
                                <a href="" class="text-danger small">View Booking Detail</a>
                              </td>
                              <td>
                                  <p>Azim Fauzi <span class="small">(Father)</span></p>
                                  <p>01234567</p>
                                  <p>azim@gmail.com</p>
                              </td>
                              <td><a href="" class="text-danger font-weight-bold">EDIT</a></td>
                            </tr>
                            <tr>
                              <th scope="row">2</th>
                              <td>
                              	<b>Azmir Abdul Wahab</b>
                                <p>NRIC/Passport:123456789</p>
                              	<p>Email: 123123@gmail.com</p>
                                <p>Contact: 12345678</bp
                                ><p>Gender:Male</p>
                              	<p>T-shirt: Large</p>
                              </td>
                              <td><p>Lorem Ipsum Event Name</p></td>
                              <td>
                              	<p>Group Male</p>
                              	<p>Booking No: 000001</p>
                                <a href="" class="text-danger small">View Booking Detail</a>
                              </td>
                              <td>
                                  <p>Azim Fauzi <span class="small">(Father)</span></p>
                                  <p>01234567</p>
                                  <p>azim@gmail.com</p>
                              </td>
                              <td><a href="" class="text-danger font-weight-bold">EDIT</a></td>
                            </tr>
                            <tr>
                              <th scope="row">3</th>
                              <td>
                              	<b>Azmir Abdul Wahab</b>
                                <p>NRIC/Passport:123456789</p>
                              	<p>Email: 123123@gmail.com</p>
                                <p>Contact: 12345678</bp
                                ><p>Gender:Male</p>
                              	<p>T-shirt: Large</p>
                              </td>
                              <td><p>Lorem Ipsum Event Name</p></td>
                              <td>
                              	<p>Group Male</p>
                              	<p>Booking No: 000001</p>
                                <a href="" class="text-danger small">View Booking Detail</a>
                              </td>
                              <td>
                                  <p>Azim Fauzi <span class="small">(Father)</span></p>
                                  <p>01234567</p>
                                  <p>azim@gmail.com</p>
                              </td>
                              <td><a href="" class="text-danger font-weight-bold">EDIT</a></td>
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
        </div>
    </div>

</div>


<?php include_once "inc/inc-js.php"; ?>
<script type="text/javascript" src="js/organizer-app.js<?php echo '?'.mt_rand(); ?>"></script>
<script type="text/javascript" src="js/organizer-custom.js<?php echo '?'.mt_rand(); ?>"></script>

</body>
</html>
<?php include_once "inc/app-bottom.php"; ?>