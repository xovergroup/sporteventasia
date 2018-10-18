<div class="main-header-box-left">
    <button class="btn-menu"><i class="fas fa-bars"></i></button>
    <button class="btn-menu-mobile"><i class="fas fa-bars"></i></button>
</div>
<div class="main-header-box-center">
    <input type="text" placeholder="Search..">
    <button><i class="fas fa-search"></i></button>
</div>
<div class="main-header-box-right dropdown">
	<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
        <img src="img/Facebook_Color.png">
        
        <?php
        
        $sql_organizer = "SELECT * FROM organizers WHERE organizer_id = ".$_SESSION["organizer_id"];        
        $query_organizer = $mysqli->query($sql_organizer);
        while($row_organizer = $query_organizer->fetch_assoc()) {

            $organizer_name = $row_organizer["organizer_name"];
            
        }
        
        ?>
        
        <p>Welcome, <?php echo $organizer_name; ?></p>
        <!--<i class="fas fa-caret-down"></i>-->
    </button>
    <div class="dropdown-menu dropdown-menu-right">
      <a class="dropdown-item" href="profile.php">Edit Profile</a>
      <a class="dropdown-item logout" href="logout-organizer.php">Logout</a>
    </div>
</div>