<?php

include "inc/app-top.php";

$search = $_POST["search"];
$state = $_POST["state"];

$jsontags = json_decode(stripslashes($_POST['tag']));
//
$tags = "(".implode(", ",$jsontags).")";

$filter = "";

if($search != ""){  
    $filter .= " AND event_name LIKE '%".$search."%'";
}
if($state != ""){
    $filter .= " AND state_id = ".$state;
}
if($tags != "()"){
    $filter .= " AND event_tag_tag IN ".$tags."";
} 

if(($_POST["clickedPage"]) != 0)
{
 $page = $_POST["clickedPage"];
}
else
{
 $page = 1;
}

$sql_event = "SELECT * FROM events, states, tags, event_tag where event_state = state_id AND event_id = event_tag_event AND tag_id = event_tag_tag ".$filter." GROUP BY event_id";

$record_per_page = 9;

$start_from = ($page - 1)*$record_per_page;

$sql_event2 = $sql_event." LIMIT ".$start_from.", ".$record_per_page;
$query_event2 = $mysqli->query($sql_event2);
$count_array = mysqli_num_rows($query_event2);
for($event = 0; $query_event_arr = $query_event2->fetch_assoc(); $event++) {
  $event_id[$event] = $query_event_arr["event_id"];
  $event_name[$event] = $query_event_arr["event_name"];
  $event_location[$event] = $query_event_arr["event_location"];
  $event_state[$event] = $query_event_arr["state_name"];
  $event_date_start[$event] = $query_event_arr["event_date_start"];
  $event_thumbnail[$event] = $query_event_arr["event_thumbnail"];
}

$query_event = $mysqli->query($sql_event);
$total_records = mysqli_num_rows($query_event);

$total_pages = ceil($total_records/$record_per_page);

$start_loop = $page;
$difference = $total_pages - $page;


$html = '      <div class="">
                	<div class=""> ';
                        if($search != ""){
$html .= '              <p class="txt-gray search-key-label"> Search Keyword <span class="txt-orange">"'.$search.'"</span></p> ';
                        }
$html .= '          </div>
                    <!--<div class="">
                    	<label>Sort By</label>
                    	<select>
                        	<option>
                            	Newest
                            </option>
                        </select>
                    </div>-->
                </div>
                
                <div class=""> ';
                for($k = 0; $k < $event; $k++){
$html .= '           <div class="event-box-3">
                        <div class="event-img-box">
                            <a href="event-detail.php?event_id='.$event_id[$k].'">
                                <img src="'.$event_thumbnail[$k].'">
                                <div class="corner-left-wrapper">
                                    <div class="corner-left"></div>
                                </div>
                                <div class="corner-right-wrapper">
                                    <div class="corner-right"></div>
                                </div>
                            </a>
                        </div>
                        <div class="event-content">
                            <p class="text-red">'.$event_date_start[$k].'</p>
                            <h2>'.$event_name[$k].'</h2>
                            <p>'.$event_location[$k].', '.$event_state[$k].'</p>
                            <button class="btn-outline-red"></button>
                        </div>
                    </div> ';
                }
$html .= '       </div> ';

                        $count_show = $record_per_page * ($page-1) + $count_array;
                
$html .= '       <div class="pagination-box">
                	<p>Showing '.$count_show.' of '.$total_records.' Results</p>
                    
                    <div class="pagination"> ';
                        
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