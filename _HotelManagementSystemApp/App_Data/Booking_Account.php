<?php
    include 'Account.php';
    include 'oop/Company.php';
    include 'oop/RoomType.php';
    include 'oop/RoomNum.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Booking_Account
 *
 * @author Admin
 */
class Booking_Account extends Account {
    //put your code here
    public function listCompanies(){
        $this->setupConnection();
        $company_list=array();
        $selected_company;
        $query= $this->Query("CALL SELECT_COMPANY_ALL()");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $selected_company=new Company();
                $selected_company->setCompanyID($row["COMPANY_ID"]);
                $selected_company->setCompanyName($row["COMPANYNAME"]);
                array_push($company_list, $selected_company);
            }
        }
        $this->closeConnection();
        return $company_list;
    }
    public function printJSONRoomTypes($company_id){
        return json_encode($this->getRoomTypes($company_id));
    }

    public function getRoomTypes($company_id){
        $this->setupConnection();
        $list_room_types=[];
        $query= $this->Query("CALL SELECT_ROOM_TYPES($company_id);");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $room=new RoomType();
                $room->RoomTypeID=$row["ROOM_TYPE_ID"];
                $room->RoomName=$row["ROOM_NAME"];
                $room->Price=$row["PRICE"];
                $room->CompanyID=$row["COMPANY_ID"];
                array_push($list_room_types, $room);
            }
        }
        return $list_room_types;
    }
    public function getRoomNums($room_type_id,$start_date,$end_date){
        $this->setupConnection();
        $start_date= $this->processData($start_date);
        $end_date= $this->processData($end_date);
        $list_room_num=[];
        $query= $this->Query("CALL SHOW_AVAILABLE_ROOMS($room_type_id,'$start_date 13:00:00','$end_date 13:00:00');");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $room=new RoomNum();
                $room->RoomNumID=$row["ROOM_NUM_ID"];
                $room->RoomNum=$row["ROOMNUM"];
                $room->RoomTypeID=$row["ROOM_TYPE_ID"];
                array_push($list_room_num, $room);
            }
        }
        return $list_room_num;
    }
    public function BookARoom($room_num_id,$account_id,$start_date,$end_date,$num_people){
        $this->setupConnection();
        $json_format["isValid"]=FALSE;
        $query= $this->executeQuery("CALL BOOK_A_ROOM($room_num_id,$account_id,'$start_date 12:00:00','$end_date 12:00:00',$num_people)");
        if ($query) {
            $json_format["isValid"]=TRUE;
        }else{
            $json_format["SQL"]="CALL BOOK_A_ROOM($room_num_id,$account_id,'$start_date 12:00:00','$end_date 12:00:00',$num_people);";
        }
        $this->closeConnection();
        return json_encode($json_format);
    }
    public function showCompanyDetails($company_id){
        $this->setupConnection();
        $json_format=[];
        $json_format["isValid"]=true;
        $query= $this->Query("CALL GET_COMPANY_DETAILS($company_id);");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $json_format[$row["DETAIL_NAME"]]=$row["DETAIL_VALUE"];
            }
        }
        $this->closeConnection();
        return json_encode($json_format);
    }
    public function getBookingsHTML($account_id){
        $this->setupConnection();
        $query= $this->Query("CALL SELECT_MY_BOOKINGS($account_id);");
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
