<?php 
include "inc/app-top.php";
$user_id = $_SESSION['id'];

$_SESSION['page'] = "guest";


    $page = '';
    if(isset($_GET["page"]))
    {
     $page = $_GET["page"];
    }
    else
    {
     $page = 1;
    }

    $record_per_page = 3;

    $start_from = ($page-1)*$record_per_page;

    $sql_all = "SELECT * FROM guest WHERE guest_user_id ='$user_id'";
    $query_all = $mysqli->query($sql_all);
    $total_records = mysqli_num_rows($query_all);

    $total_pages = ceil($total_records/$record_per_page);

    $start_loop = $page;
    $difference = $total_pages - $page;

    $sql_guest = $sql_all." LIMIT ".$start_from.", ".$record_per_page;       
    $query_guest = $mysqli->query($sql_guest);
    for($guest = 0; $query_guest_arr = $query_guest->fetch_assoc(); $guest++) {
        
        $guest_id[$guest] = $query_guest_arr["guest_id"];
        $guest_name[$guest] = $query_guest_arr["guest_name"];
        $guest_ic_status[$guest] = $query_guest_arr["guest_ic_status"];
        $guest_ic[$guest] = $query_guest_arr["guest_ic"];
        $guest_gender[$guest] = $query_guest_arr["guest_gender"];
        $guest_email[$guest] = $query_guest_arr["guest_email"];
        $guest_contact[$guest] = $query_guest_arr["guest_contact"];
        $guest_country[$guest] = $query_guest_arr["guest_country"];
        
        $icprefix[$guest] = substr($query_guest_arr["guest_ic"],0,6);
        $icmiddle[$guest] = substr($query_guest_arr["guest_ic"],6,2);
        $icsuffix[$guest] = substr($query_guest_arr["guest_ic"],8,4);
        
    }
    



?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Guest List</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    <div class="pt-5">
    	<div class="container">
        	<div class="row pt-5">
            
                <?php include_once "inc/side-nav.php"; ?>
                
                <div class="col-lg-9 ml-auto mb-5">
                	<div class="row no-gutters mb-3">
                		<h2 class="col">My Guest List</h2>
                    	<a href="user-guest-add.php" class="font-dagger bg-red txt-white p-3 col-md-3 txt-center float-right">ADD NEW GUEST</a>
               		</div>
                    
                    <div id="guest-content">
                    
                        <?php for($j = 0; $j < $guest; $j++) { ?> 

                        <div class="event-news-box p-4 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <h3><?php echo $guest_name[$j]; ?></h3>
                                </div>
                                
                                <?php 
                                    if($guest_ic_status[$j] == 1){
                                        $guest_ic_list = $icprefix[$j].'-'.$icmiddle[$j].'-'.$icsuffix[$j];
                                    } else{
                                        $guest_ic_list = $guest_ic[$j];
                                    }                                      
                                ?>
                                
                                <div class="col-md-7">
                                    <p class="">NRIC: <?php echo $guest_ic_list; ?></p>
                                    <p class="">Email: <?php echo $guest_email[$j]; ?></p>
                                    <p class="">Contact: <?php echo $guest_contact[$j]; ?></p>
                                    <p class="">Gender: <?php echo $guest_gender[$j]; ?></p>
<!--                                    <p class="">Country: <?php echo $guest_country[$j]; ?></p>-->
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    <a href="user-guest-detail.php?id=<?echo $guest_id[$j];?>" class="txt-orange"><i class="fas fa-pencil-alt"></i></a>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

                        <div class="txt-center">

                            <div class="pagination float-none">

                            <?php
                            if($difference <= 5)
                            {
                             $start_loop = $total_pages - 5;
                            }
                            $end_loop = $start_loop + 5;
                            if($page > 1)
                            {
                             echo '<a class="go-to-page" data-page="1" >First</a>';
                             echo '<a class="go-to-page" data-page="'.($page - 1).'" >&laquo;</a>';
                            }
                            for($b=$start_loop; $b<=$end_loop; $b++)
                            {
                                if($b <= 0)
                                {

                                } else{
                                    if($page == $b){
                                        echo '<a class="go-to-page active" data-page="'.$b.'" >'.$b.'</a>';
                                    }else{
                                        echo '<a class="go-to-page" data-page="'.$b.'" >'.$b.'</a>';
                                    }

                                }
                            }
                            if($page < $end_loop)
                            {
                             echo '<a class="go-to-page" data-page="'.($page+1).'" >&raquo;</a>';
                             echo '<a class="go-to-page" data-page="'.$total_pages.'" >Last</a>';
                            }
                            ?>

                        </div>
                        
                    </div>
                </div>        
                             
                </div>
            </div>
        </div>
        
    </div>
    
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

<?php include_once "inc/inc-js.php"; ?>

<script type="text/javascript" src="js/custom.js<?php echo '?'.mt_rand(); ?>"></script>

<script>
    
$( document ).ready(function() {
    $('body').on('click', '.go-to-page', goToPage);
       
    <?php if(isset($_GET["msg"]) && intval($_GET["msg"]) == 1) {?>
	swal("Success", "Guest has been update successfully.", "success");
	<?php } ?>
    
    window.history.replaceState(null, null, window.location.pathname);
    
});
    
    
function goToPage(e) {
    
    e.preventDefault();   
       
	$("#guest-content").empty();
    
    var clickedPage = $(this).attr("data-page");
       
    $.ajax({
            type:'POST',
            url:'user-guest-table.php',
            data:'clickedPage='+clickedPage,            
            // beforeSend: function () {
            //     $('.submitBtn').attr("disabled","disabled");
            //     $('.modal-body').css('opacity', '.5');
            // },
            success:function(result){
                //console.log(result);

                $("#guest-content").append(result);
            }    
        });

}
</script>
    
</body>
</html>
