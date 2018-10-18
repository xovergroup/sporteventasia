<?php

include "inc/app-top-index.php";

$sql_state = "SELECT * FROM states ORDER BY state_id ASC";
$query_state = $mysqli->query($sql_state);
for($state_i = 0; $query_state_arr = $query_state->fetch_assoc(); $state_i++) {
  $state_id[$state_i] = $query_state_arr["state_id"];
  $state_name[$state_i] = $query_state_arr["state_name"];
}

$sql_tag = "SELECT * FROM tags";
$query_tag = $mysqli->query($sql_tag);
for($tag = 0; $query_tag_arr = $query_tag->fetch_assoc(); $tag++) {
  $tag_id[$tag] = $query_tag_arr["tag_id"];
  $tag_title[$tag] = $query_tag_arr["tag_title"];
}

$search = $_POST["search"];
$state = $_POST["state"];
$tags = $_POST["tag"];

$filter = "";

if($tags != ""){
    $filter .= " AND event_tag_tag = ".$tags;
}
if($state != ""){
    $filter .= " AND state_id = ".$state;
}
if($search != ""){  
    $filter .= " AND event_name LIKE '%".$search."%'";
}
if(isset($_GET["search"])){  
    $filter .= " AND event_name LIKE '%".$_GET["search"]."%'";
}
if(isset($_GET["tag"])){
    $filter .= " AND event_tag_tag = ".$_GET["tag"]."";
} 

$page = '';
if(isset($_GET["page"]))
{
 $page = $_GET["page"];
}
else
{
 $page = 1;
}

$record_per_page = 9;

$start_from = ($page-1)*$record_per_page;

$sql_event = "SELECT * FROM events, states, tags, event_tag where event_state = state_id AND event_id = event_tag_event AND tag_id = event_tag_tag ".$filter." GROUP BY event_id";

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

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Explore </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once "inc/inc-css.php"; ?>
</head>
<body>

<div id="main-body">

	<?php include_once "inc/header.php"; ?>
    
    
    <div class="explore">
    	<img src="img/explore-banner.jpg">
        <div class="explore-content">
         	<button class="go-to-page" data-page="1" ><i class="fas fa-search"></i></button>
        	<input class="search" data-page="1" type="search" name="event_search" id="event_search" placeholder="Search Events">
        </div>
    </div>
    
    <div class="m-5">
    	<div class="container">
            
        	<div class="explore-left">
            	<div class="filter-inner">
                    <label class="font-dagger">Filters</label>
                    <a href="javascript:window.location.href=window.location.href" class="btn-clean float-right">Reset</a>
                </div>
                <div class="filter-tab">
                    <input id="tab-one" type="checkbox" name="tabs" checked>
                    <label for="tab-one">Tags</label>
                    <div class="filter-tab-content">
                        <div class="create-tag-field filter-inner">
                            <div class="create-tag-box">
                                <?php for($j = 0; $j < $tag; $j++) { ?>
                                <input id="<?php echo $tag_title[$j];?>" name="event_tag[]" class="event-tag" id="event_tag" value="<?php echo $tag_id[$j];?>" <?php if(isset($_POST["event_tag"])){ if(in_array($tag_id[$j], $_POST["event_tag"])){ echo "checked"; } } if(isset($_GET["tag"]) && $_GET["tag"] == $tag_id[$j]){ echo "checked"; } ?> type="checkbox">
                                <label for="<?php echo $tag_title[$j];?>" ><?php echo $tag_title[$j];?></label>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-tab">
                    <input id="tab-two" type="checkbox" name="tabs" checked> 
                    <label for="tab-two">State</label>
                    <div class="filter-tab-content">
                    	<div class="filter-inner">
                            <select name="event_state" id="event_state">
                                <option value="">-choose country-</option>
                                <?php for($i = 0; $i < $state_i; $i++) { ?>
                                <option value="<?php echo $state_id[$i];?>" <?php if($state == $state_id[$i]){ echo "selected"; } ?> ><?php echo $state_name[$i]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>     
                <div class="filter-tab">
                    
                        <button class="go-to-page show" data-page="1">Show Result</button>
                    
                </div>
                
            </div>
            
            <div class="explore-right" id="right-content">
            	<div class="">
                	<div class="">
                        <?php if($_POST["search"] != ""){ ?>
                    	<p class="txt-gray search-key-label"> Search Keyword <span class="txt-orange">"<?php echo $_POST["search"]; ?>"</span></p>
                        <?php } ?>
                    </div>
                    <!--<div class="">
                    	<label>Sort By</label>
                    	<select>
                        	<option>
                            	Newest
                            </option>
                        </select>
                    </div>-->
                </div>
                
                <div class="">
                    <?php for($k = 0; $k < $event; $k++) { ?>
                    <div class="event-box-3">
                        <div class="event-img-box">
                            <a href="event-detail.php?event_id=<?php echo $event_id[$k];?>">
                                <img src="<?php echo $event_thumbnail[$k];?>">
                                <div class="corner-left-wrapper">
                                    <div class="corner-left"></div>
                                </div>
                                <div class="corner-right-wrapper">
                                    <div class="corner-right"></div>
                                </div>
                            </a>
                        </div>
                        <div class="event-content">
                            <p class="text-red"><?php echo $event_date_start[$k];?></p>
                            <h2><?php echo $event_name[$k];?></h2>
                            <p><?php echo $event_location[$k];?>, <?php echo $event_state[$k];?></p>
                            <button class="btn-outline-red"></button>
                        </div>
                    </div> 
                    <?php } ?>
                </div>
                
                <?php 
                $count_show = $record_per_page * ($page-1) + $count_array;
                ?>
                
                <div class="pagination-box">
                	<p>Showing <?php echo $count_show; ?> of <?php echo $total_records; ?> Results</p>
                    
<!--
                    <div class="pagination">
                      <a href="#">&laquo;</a>  
                      <a href="#" class="active">1</a>
                      <a href="#">2</a>
                      <a href="#">3</a>
                      <a href="#">4</a>
                      <a href="#">5</a>
                      <a href="#">6</a>
                      <a href="#">&raquo;</a>
                    </div>
-->
                    <div class="pagination">
                        
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
    
    
    <?php include_once "inc/footer.php"; ?>


</div>

<?php include_once "inc/inc-js.php"; ?>



<script>
    
$( document ).ready(function() {
    $('body').on('click', '.go-to-page', goToPage);
    
    $('.search').keypress(function (e) {     
      if (e.which == 13) {
         goToPage(e);
      }
    });    
    
});
    

function grabAllCheckedEventTag(){
    
    var tags = [];
    $('.event-tag:checkbox:checked').each(function () {
       
        tags.push($(this).val());
       
    });
    
    return tags;
}     

    
function goToPage(e) {
    
    e.preventDefault();   
       
	$("#right-content").empty();
    
    var clickedPage = $(this).attr("data-page");
	
    var search = document.getElementById("event_search").value;
    
    var state = document.getElementById("event_state").value;
    
    var tag = JSON.stringify(grabAllCheckedEventTag());
 
       
    $.ajax({
            type:'POST',
            url:'explore-table.php',
            data:'clickedPage='+clickedPage+'&search='+search+'&state='+state+'&tag='+tag,            
            // beforeSend: function () {
            //     $('.submitBtn').attr("disabled","disabled");
            //     $('.modal-body').css('opacity', '.5');
            // },
            success:function(result){
                //console.log(result);

                $("#right-content").append(result);
            }    
        });

}
</script>
    
    
<style>
    
    .show {
        background-color: gainsboro; /* Green */
        border: none;
        color: black;
        padding: 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 20px 2px;
        cursor: pointer;
        border-radius: 2px;
    }
    
    .show:hover {
        background-color: #e33f2c;
        color: white;
    }
    
</style>    

</body>
</html>
