<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <?php
            include '../App_Data/Booking_Account.php';
            include 'header.php'; 
            $acc=new Booking_Account();
            $list_companies=[];
            if (isset($_COOKIE["username"]) && isset($_COOKIE["uid"])) {
                
                if ($acc->verify($_COOKIE["username"]."", $_COOKIE["uid"]."")) {
                    $list_companies=$acc->listCompanies();
                }else{
                    header("location: ../index.php");
                }
            }else{
                    header("location: ../index.php");
            }
            
        ?>
        <script src="../script/jquery-1.8.3.js" type="text/javascript"></script>
        <link href="../css/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="../script/jquery-ui.js" type="text/javascript"></script>
        <title>Hotel: Home</title>
        <style>
            select{
                outline: 0;
            }
        </style>
    </head>
    <body>
        <script>
            window.onload=function(){
                var inputs=document.getElementsByTagName("input");
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].autocomplete="off";
                }
                
                $(function() {
                    $.datepicker.setDefaults({dateFormat: 'yy-mm-dd'});
                    $( "input.date" ).datepicker();
                });
            };
        </script>
        <!-- Sidebar/menu -->
<nav class="w3-sidebar w3-red w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Hotel: Profile</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Home</a> 
      <a href="booking.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Create a booking</a> 
      <a href="service.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Ask for service</a> 
    <a href="#" onclick="account.logout()" class="w3-bar-item w3-button w3-hover-white">Logout</a> 
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
<div class="w3-main w3-row" style="margin-left:340px;margin-right:40px;min-height: 500px;">

  <!-- Header -->
  <div class="w3-container" style="margin-top:80px;" id="showcase">
    <h1 class="w3-jumbo"><b>Hotel: Profile</b></h1>
    <h1 class="w3-xxxlarge w3-text-red"><b>Booking</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
    <button class="w3-btn w3-border w3-hide w3-round-xlarge w3-hover-red w3-border-red">Submit booking</button>
  </div>
  <div class="w3-row">
      <form id="booking-form" class="w3-col s12 w3-container" style="min-height: 450px;">
       <div class="w3-section">
        <label>Company</label>
        <select onchange="booking.hotelChanged(this)" id="company" placeholder="Service name" class="w3-input w3-round-xlarge w3-border" type="text" name="company_id" required="">
                <option value="">Please select a hotel</option>
                <!--For loop goes here...-->
                <?php 
                for($index=0;$index<count($list_companies);$index++){
                    ?><option value="<?php echo $list_companies[$index]->getCompanyID(); ?>"><?php echo $list_companies[$index]->getCompanyName(); ?></option><?php
                } ?>
            </select>
      </div>   
       <div class="w3-section depe-com w3-disabled">
        <label>Number of people:</label>
        <select placeholder="" class="w3-input w3-round-xlarge w3-border" type="text" name="people" required="">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
      </div> 
      <div id="arr-con" class="w3-section depe-com w3-disabled">
        <label>Arrival</label>
        <input onchange="booking.checkDates()" id="arr-val" readonly placeholder="Arrival" class="w3-input date booking-input w3-round-xlarge w3-border" type="text" name="arrival" required="">
      </div>
      <div id="dep-con" class="w3-section depe-com w3-disabled">
        <label>Departure</label>
        <input onchange="booking.checkDates()" id="dep-val" readonly placeholder="Departure" class="w3-input date booking-input w3-round-xlarge w3-border" type="text" name="departure" required="">
      </div>
          <div  id="room-con" class="w3-section depe-com w3-disabled">
        <label>Room type</label>
        <select onchange="booking.changeRoomType()" id="roomtype" class="w3-input w3-round-xlarge w3-border" type="text" name="roomtype" required="">
                <option value="">Please select an room type</option>
                <!--For loop goes here...-->
            </select>
      </div>
          <div id="ava-con" class="w3-disabled">
              <button onclick="booking.searchAvailability();" type="button" class="w3-hover-white w3-btn w3-round-large w3-block w3-padding-large w3-dark-gray w3-margin-bottom">Search Availability</button>
          </div>
          <div id="num-con" class="w3-section w3-hide">
        <label>Room number:</label>
        <select id="room_num" placeholder="Service name" class="w3-input w3-round-xlarge w3-border" type="text" name="room_number" required="">
                <option value="">Please select a room number</option>
                <!--For loop goes here...-->
            </select>
        <button onclick="booking.bookARoom()" type="button" class="w3-hover-white w3-btn w3-round-large w3-margin-top w3-block w3-padding-large w3-red w3-margin-bottom">Submit booking</button>
      </div>
          
          
  </form>
      <!--Room booking-->
      <div class="w3-col w3-hide l4 m6 m12 room-booking" style="padding: 16px;">
          <div class="w3-border w3-round-xlarge" style="min-height: 450px;padding: 10px;">
              <h3 class="w3-center">Hotel name</h3>
              <table class="w3-table">
                  <tr>
                      <td>Arrival:</td>
                      <td>11-12-2019</td>
                  </tr>
                  <tr>
                      <td>Departure:</td>
                      <td>11-12-2019</td>
                  </tr>
                  <tr>
                      <td>Room type:</td>
                      <td>Deluxe plus</td>
                  </tr>
                  <tr>
                      <td>Room number:</td>
                      <td>102</td>
                  </tr>
              </table>
                <button class="w3-btn w3-col s12 w3-border w3-round-xlarge">Remove</button>
          </div>
      </div>
      
  </div>
  
  </div>

  
  

<!-- End page content -->
</div>

<!-- W3.CSS Container -->
<div class="w3-light-grey w3-row w3-container w3-padding-32" style="margin-top:75px;padding-right:58px"><p class="w3-right">Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-opacity">w3.css</a></p></div>

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
