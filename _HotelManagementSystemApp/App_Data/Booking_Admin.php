<?php
include 'Admin.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Booking_Admin
 *
 * @author Admin
 */
class Booking_Admin extends Admin{
    //put your code here
    public function getBookingsHTML($company_id){
        $this->setupConnection();
        $query= $this->Query("CALL SELECT_COMPANY_BOOKINGS($company_id);");
        $html="";
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $html .="<div class=\"w3-border w3-margin-bottom w3-center w3-round-large\">"
                        ."<h6>From ".$row["START_DATE"]." - To ".$row["EXPIRY_DATE"]."</h6>"
                        ."<h4>".$row["DETAIL_VALUE"]."</h4>"
                        ."<h4>Room: ".$row["ROOMNUM"]."</h4>"
                        ."<h5>Price per night: <span class=\"w3-tag\">R".$row["UNIT_PRICE"]."<span></h5>"
                        ."<h5>Total Price: <span class=\"w3-tag\">R".$row["TOTAL_PRICE"]."<span></h5>"
                        ."</div>";
            }
        }
        $this->closeConnection();
        return $html;
    }
}
