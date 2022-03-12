<html>
    <head>
        <?php
            include '../App_Data/Room_Admin.php';
            include 'header.php';
            $acc=new Room_Admin();
            if (isset($_COOKIE["admin_user"]) && isset($_COOKIE["admin_uid"]) && isset($_GET["company_id"])) {
                $admin_id=$acc->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    $companyname=$acc->showCompanyName($_GET["company_id"]."");
                    
                }else{
                    header("location: ../adminlogin.php");
                }
            }else{
                header("location: ../adminlogin.php");
            }
            
        ?>
        <title>Add new company</title>
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
      <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a>
      <a href="room.php?company_id=<?php echo $_GET["company_id"]; ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Back to Rooms</a>
      <a href="room_num.php?company_id=<?php echo $_GET["company_id"]; ?>" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Add new room</a>
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
<div class="w3-main" style="margin-left:340px;margin-right:40px;min-height: 400px;">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>HMS Admin</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Rooms</b></h1>
    <h2>Add room type</h2>
    <h3><?php echo $companyname; ?></h3>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <form id="room-form" method="POST">
        <input type="hidden" value="<?php echo $_GET["company_id"]; ?>" name="company_id"/>
        <div class="w3-section">
            <label>Room name:</label>
            <input placeholder="Room name" class="w3-input w3-round-xlarge w3-border" type="text" name="roomname" required="">
        </div>
        <div class="w3-section">
            <label>Price:</label>
            <input placeholder="Room price" class="w3-input w3-round-xlarge w3-border" type="number" name="roomprice" required="">
        </div>
        <button type="button" onclick="admin.room.addRoomType(this);" class="w3-button w3-round-large w3-block w3-padding-large w3-red w3-margin-bottom">Add room type</button>
    </form>
    
    
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