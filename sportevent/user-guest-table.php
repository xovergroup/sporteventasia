<?php 
include "inc/app-top.php";
$user_id = $_SESSION['id'];

    if(($_POST["clickedPage"]) != "")
    {
     $page = $_POST["clickedPage"];
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
    

               for($j = 0; $j < $guest; $j++) {    
$html .= '      <div class="event-news-box p-4 mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <h3>'.$guest_name[$j].'</h3>
                        </div> ';
                   
                        if($guest_ic_status[$j] == 1){
                            $guest_ic_list = $icprefix[$j].'-'.$icmiddle[$j].'-'.$icsuffix[$j];
                        } else{
                            $guest_ic_list = $guest_ic[$j];
                        } 
                   
$html .= '              <div class="col-md-7">
                            <p class="">NRIC: '.$guest_ic_list.'</p>
                            <p class="">Email: '.$guest_email[$j].'</p>
                            <p class="">Contact: '.$guest_contact[$j].'</p>
                            <p class="">Gender: '.$guest_gender[$j].'</p>

                        </div>
                        <div class="col-md-1">
                            <br>
                            <a href="user-guest-detail.php?id='.$guest_id[$j].'" class="txt-orange"><i class="fas fa-pencil-alt"></i></a>
                        </div>
                    </div>
                </div> ';
                }
                
$html .= '       <div class="txt-center">
                    
                    <div class="pagination float-none"> ';
                        
                        if($difference <= 5)
                        {
                         $start_loop = $total_pages - 5;
                        }
                        $end_loop = $start_loop + 5;
                        if($page > 1)
                        {
$html .= '                <a class="go-to-page" data-page="1" >First</a>
                         <a class="go-to-page" data-page="'.($page - 1).'" >&laquo;</a> ';
                        }
                        for($b=$start_loop; $b<=$end_loop; $b++)
                        {   
                            if($b <= 0)
                            {
                                
                            } else{
                                if($page == $b){
$html .= '                          <a class="go-to-page active" data-page="'.$b.'" >'.$b.'</a> ';                                     
                                }else{
$html .= '                          <a class="go-to-page" data-page="'.$b.'" >'.$b.'</a> ';                                    
                                }

                            }
                        }
                        if($page < $end_loop)
                        {
$html .= '                <a class="go-to-page" data-page="'.($page+1).'" >&raquo;</a>
                         <a class="go-to-page" data-page="'.$total_pages.'" >Last</a> ';
                        }
                    
$html .= '            </div> 
                </div>';


echo $html;

?>