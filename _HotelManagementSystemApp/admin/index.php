<html>
    <head>
        <?php
            include '../App_Data/Admin.php';
            include 'header.php';
            $acc=new Admin();
            $list_companies=array();
            if (isset($_COOKIE["admin_user"]) && isset($_COOKIE["admin_uid"])) {
                $admin_id=$acc->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    $list_companies=$acc->listCompanies($admin_id);
                }else{
                    header("location: ../adminlogin.php");
                }
            }else{
                header("location: ../adminlogin.php");
            }
            
        ?>
        <title>Administrator Controls</title>
    </head>
    <body>
              <script>
            window.onload=function(){
                var inputs=document.getElementsByTagName("input");
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].autocomplete="off";
                }
            };
        </script>
        <!-- Sidebar/menu -->
<nav class="w3-sidebar w3-animate-left w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>HMS Admin</b></h3>
  </div>
  <div class="w3-bar-block">
      
      <a href="company_create.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Add new company</a>
      <a href="#" onclick="admin.logout();" class="w3-bar-item w3-button w3-hover-white">Logout</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>HMS Admin</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px;min-height: 500px;" id="showcase">
    <h1 class="w3-jumbo"><b>HMS Admin</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Companies</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <?php
        for($i=0; $i < count($list_companies);$i++){
    ?>
    <div class="w3-col l4 m6 s12" style="padding: 8px;">
        <div class="w3-border w3-center w3-round-large" style="height: 300px;padding: 16px;">
            <h3><?php echo $list_companies[$i]->getCompanyName(); ?></h3>
            <a href="company_service.php?company_id=<?php echo $list_companies[$i]->getCompanyID(); ?>" class="w3-btn w3-col s6 w3-border">Services</a>
            <a href="employees.php?company_id=<?php echo $list_companies[$i]->getCompanyID(); ?>" class="w3-btn w3-col s6 w3-border">Employees</a>
            <a href="Bookings.php?company_id=<?php echo $list_companies[$i]->getCompanyID(); ?>" class="w3-btn w3-col s6 w3-border">Bookings</a>
            <a href="room.php?company_id=<?php echo $list_companies[$i]->getCompanyID(); ?>" class="w3-btn w3-col s6 w3-border">Room</a>
            <button onclick="admin.openUpdate(this,<?php echo $list_companies[$i]->getCompanyID(); ?>)" class="w3-btn w3-col w3-margin-top s12 w3-border">Edit</button>
            <button onclick="admin.showCompanyDetails(this,<?php echo $list_companies[$i]->getCompanyID(); ?>)" class="w3-btn w3-col s12 w3-border">Details</button>
        </div>
    </div>
    <?php
        }
    ?>
  </div>
  
  <div>
      
  </div>
</div>


<!-- W3.CSS Container -->
<div class="w3-light-grey w3-col s12 w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

<script>
// Script to open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}
</script>
<section id="edit-modal" class="w3-modal w3-margin-bottom">
            <section class="w3-modal-content">
                <div class="w3-col l3" style="height: 10px;"></div>
                <div class="w3-col l6 w3-white w3-round-large w3-animate-top">
                    <div style="min-height: 5%;">
                        <button class="w3-red w3-right w3-btn w3-margin-top w3-large" onclick="w3.toggleClass('#edit-modal','w3-show')">&times;</button>
                    </div>
                    <h2 id="edit-modal-heading">Edit company</h2>
                    <div id="edit-modal-content" style="padding: 16px;">
                        <form id="company-form" method="POST">
        <div class="w3-section">
        <label>Company name:</label>
        <input placeholder="Company name" class="w3-input company-input w3-round-xlarge w3-border" type="text" name="companyname" required="">
      </div>
        <div class="w3-section">
        <label>Address</label>
        <input placeholder="Address" class="w3-input company-input w3-round-xlarge w3-border" type="text" name="address" required="">
      </div>
      <div class="w3-section">
        <label>City:</label>
        <input placeholder="City" class="w3-input company-input w3-round-xlarge w3-border" type="text" name="city" required="">
      </div>
      <div class="w3-section">
        <label>Postal code:</label>
        <input placeholder="Postal code" class="w3-input company-input w3-round-xlarge w3-border" type="text" name="postalcode" required="">
      </div>
      <div class="w3-section">
        <label>Email:</label>
        <input placeholder="Email" class="w3-input company-input w3-round-xlarge w3-border" type="text" name="email" required="">
      </div>  
        <button onclick="" type="button" class="w3-button w3-round-large w3-block w3-padding-large w3-red w3-margin-bottom">Save</button>
    </form>
                    </div>

                </div>
            </section>
        </section>

<section id="main-modal" class="w3-modal">
            <section class="w3-modal-content">
                <div class="w3-col l3" style="height: 10px;"></div>
                <div class="w3-col l6 w3-white w3-round-large w3-animate-top">
                    <div style="min-height: 5%;">
                        <button class="w3-red w3-right w3-btn w3-margin-top w3-large" onclick="w3.toggleClass('#main-modal','w3-show')">&times;</button>
                    </div>
                    <h2 id="main-modal-heading"></h2>
                    <p id="main-modal-content"></p>

                </div>
            </section>
        </section> 

    </body>
</html>