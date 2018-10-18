<?php

include "inc/app-top.php";

$search = $_POST["search"];
$state = $_POST["state"];

$jsontags = json_decode(stripslashes($_POST['tag']));

//$tags = implode(" ",$jsontags);

$filter = "";

if($search != ""){  
    $filter .= " AND event_name = ".$search;
}
if($state != ""){
    $filter .= " AND state_id = ".$state;
}
if($_POST["tag"] != ""){
    $filter .= " AND state_id = ".$tags;
} 

$page = '';
if($_POST["clickedPage"] != 0)
{
 $page = $_GET["clickedPage"];
}
else
{
 $page = 1;
}

$sql_event = "SELECT * FROM events, states, tags, event_tag where event_state = state_id AND event_id = event_tag_event AND tag_id = event_tag_tag ".$filter;

$record_per_page = 9;

$start_from = ($page-1)*$record_per_page;

$sql_event2 = $sql_event." LIMIT ".$start_from.", ".$record_per_page;
$query_event2 = $mysqli->query($sql_event2);
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


html = '<p>'.$jsontags.'<p>';

echo $html;

?>