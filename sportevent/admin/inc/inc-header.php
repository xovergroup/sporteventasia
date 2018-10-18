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
        <?php
        
        $sql_admin = "SELECT * FROM admin WHERE admin_id = ".$_SESSION["admin_id"];        
        $query_admin = $mysqli->query($sql_admin);
        if($row_admin = $query_admin->fetch_assoc()) {

            $admin_name = $row_admin["admin_name"];
            
        }
        
        ?>
        
        <p>Welcome, <?php echo $admin_name; ?></p>
        <!--<i class="fas fa-caret-down"></i>-->
    </button>
    <div class="dropdown-menu dropdown-menu-right">
      <a class="dropdown-item logout" href="logout-admin.php">Logout</a>
    </div>
</div>