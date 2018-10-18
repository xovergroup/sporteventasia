<div class="header">
    <div class="container">
        <div class="header-left">
            <a href="index.php"><img src="img/logo-orange.png"></a>
        </div>
        <div class="mobile-menu"><a class="btn-menu"><li class=""><i class="fas fa-bars"></i></li></a></div>
        <div class="header-right">
            <!--<a class="btn-menu"><li class="header-oblique"><i class="fas fa-bars"></i></li></a>-->
            <?php if(isset($_SESSION["id"])){ ?>
            <a href="user-profile.php" class="header-oblique bg-red login-button"><li><i class="fas fa-user-circle"></i>  &nbsp My Account</li></a>    
            <?php } else { ?>
            <a href="login.php" class="header-oblique bg-red login-button"><li><i class="fas fa-user-circle"></i>  &nbsp Register / Login</li></a> 
            <?php } ?>          
            <a href="organizer/login-organizer.php"><li class="header-oblique"><i class="fas fa-user-tie"></i>  &nbsp For Organizer</li></a>
            <a href="explore.php"><li class="header-oblique"><i class="fas fa-search"></i>  &nbsp Explore</li></a>
        </div>
    </div>
</div>

<div class="full-menu">
    <div class="wrap">
        <button id="close-menu"><li class=""><i class="fas fa-times"></i></li></button>
        <ul class="menu-principal">
            <li><a href="#" class="login-button" onclick="document.getElementById('id01').style.display='block'"><i class="fas fa-user-circle"></i>  &nbsp Register / Login</a></li>
            <li class=""><a href=""><i class="fas fa-user-tie"></i>  &nbsp For Organizer</a></li>
            <li class="explore.php"><a href=""><i class="fas fa-search"></i>  &nbsp Explore</a></li>
        </ul>
    </div>
</div>