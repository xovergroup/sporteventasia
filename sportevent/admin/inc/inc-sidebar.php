	<div class="sidebar">
    <h5 class="text-center">ADMIN PORTAL</h5>
    <!--<img src="img/logo.png">-->
    <li>
        <a class="btn-create" href="#"><i class="fas fa-plus"></i>  Create Event</a>
        <ul class="">
            <li><a class="" href="#"><i class="fas fa-home"></i>  Dashboard</a></li>
            <li><a class="" href="#"><i class="far fa-calendar-alt"></i>  Manage Events</a></li>
            <li><a class="" href="merchandise-list.php"><i class="fas fa-shopping-cart"></i>  Merchandise</a></li>
            <li><a class="" href="user-list.php"><i class="fas fa-users"></i>  Users</a></li>
            <li><a class="" href="organizer-list.php"><i class="fas fa-user-tie"></i>  Organizers</a></li>
            <li><a class="" href="#"><i class="fas fa-user"></i>  Participants</a></li>
            <li><a class="" href="promo-list.php"><i class="fas fa-ticket-alt"></i>  Promo Code</a></li>
            <li>
                <a href="#" class="dropdown-btn"><i class="fas fa-inbox"></i>  Inbox <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-container">
                <a href="#">> Website Enquiry</a>
                <a href="#">> Organizer Enquiry</a>
                <a href="#">> Participants Enquiry</a>
            </div>
            </li>
            
            <li><a class="" href="#"><i class="fas fa-list-ul"></i> System Log Activities</a></li>
        </ul>
    </li>
</div>

<script>
/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>