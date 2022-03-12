<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <?php
            include 'App_Data/Account.php';
            include 'header.php'; 
            $acc=new Account();
            if (isset($_COOKIE["username"]) && isset($_COOKIE["uid"])) {
                
                if ($acc->verify($_COOKIE["username"]."", $_COOKIE["uid"]."")) {
                    header("location: profile/index.php");
                }
            }
            
        ?>
        <title>Hotel: Home</title>
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
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Hotel Management System</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="#" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Login</a> 
    <a href="#signup" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Sign up</a>
  </div>
</nav>

<!-- Top menu on small screens -->
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span>Company Name</span>
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px" id="showcase">
    <h1 class="w3-jumbo"><b>Hotel Management System</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Login</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
  </div>
  
  <div>
      <form id="login-form" class="w3-container" >
        <div class="w3-section">
          <label><b>Username</b></label>
          <input class="w3-input w3-round-xlarge w3-border w3-margin-bottom" type="text" placeholder="Username" name="username" required>
          <label><b>Password</b></label>
          <input class="w3-input w3-round-xlarge w3-border" type="password" placeholder="Password" name="password" required>
          <button onclick="account.login(this)" class="w3-button w3-block w3-padding-large w3-red w3-round-large w3-section w3-padding" type="button">Login</button>
        </div>
      </form>
  </div>
<!-- Sign up -->
  <div class="w3-container" id="signup" style="margin-top:75px">
    <h1 class="w3-xxxlarge w3-text-red"><b>Sign up</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <form id="signup-form">
      <div class="w3-section">
        <label>Name</label>
        <input placeholder="Name" class="w3-input sign-up-input w3-round-xlarge w3-border" type="text" name="firstname" required="">
      </div>
      <div class="w3-section">
        <label>Surname</label>
        <input placeholder="Surname" class="w3-input sign-up-input w3-round-xlarge w3-border" type="text" name="lastname" required="">
      </div>
      <div class="w3-section">
        <label>Username</label>
        <input placeholder="Username" class="w3-input sign-up-input w3-round-xlarge w3-border" type="text" name="username" required="">
      </div>
      <div class="w3-section">
        <label>Email</label>
        <input placeholder="Email" class="w3-input sign-up-input w3-round-xlarge w3-border" type="text" name="email" required="">
      </div>
        <div class="w3-section">
        <label>Password</label>
        <input placeholder="Password" class="w3-input sign-up-input w3-round-xlarge w3-border" type="password" name="password" required="">
      </div>
        <div class="w3-section">
        <label>Confirm password</label>
        <input placeholder="Confirm password" class="w3-input sign-up-input w3-round-xlarge w3-border" type="password" name="Cpassword" required="">
      </div>
        <button onclick="account.signup(this)" type="button" class="w3-button w3-round-large w3-block w3-padding-large w3-red w3-margin-bottom">Sign up</button>
    </form>  
  </div>
<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

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
