<div class="col-lg-3">
    <div class="event-news-box p-2">
        <ul>
            <a href="user-profile.php" class="font-dagger m-2 <?php if($_SESSION['page'] == "profile"){ echo "txt-orange"; } ?>"><li>Edit Profile</li></a>
            <a href="user-booking.php" class="font-dagger m-2 <?php if($_SESSION['page'] == "booking"){ echo "txt-orange"; } ?>"><li>My Booking</li></a>
            <a href="user-guest.php" class="font-dagger m-2 <?php if($_SESSION['page'] == "guest"){ echo "txt-orange"; } ?>"><li>My Guests</li></a>
            <a href="signout.php" class="font-dagger m-2"><li>Sign Out</li></a>
        </ul>
    </div>
</div>