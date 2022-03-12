<?php
include 'Admin.php';
include 'oop/RoomType.php';
include 'oop/RoomNum.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Room_Admin
 *
 * @author Admin
 */
class Room_Admin extends Admin{
    //put your code here
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
    public function getRoomNums($company_id){
        $this->setupConnection();
        $list_room_types=[];
        $query= $this->Query("CALL SELECT_ROOM_NUMS($company_id);");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $room=new RoomNum();
                $room->RoomNumID=$row["ROOM_NUM_ID"];
                $room->RoomNum=$row["ROOMNUM"];
                $room->RoomTypeID=$row["ROOM_TYPE_ID"];
                $room->RoomName=$row["ROOM_NAME"];
                $room->Price=$row["PRICE"];
                $room->CompanyID=$row["COMPANY_ID"];
                array_push($list_room_types, $room);
            }
        }
        return $list_room_types;
    }
    public function addRoomType($room_name,$price,$company_id){
        $this->setupConnection();
        $isSuccessful= $this->executeQuery("CALL INSERT_ROOM_TYPE('$room_name',$price,$company_id)");
        $obj->isValid=FALSE;
        if ($isSuccessful) {
            $obj->isValid=TRUE;
        }
        $this->closeConnection();
        return json_encode($obj);
    }
    public function addRoomNum($room_num,$room_type_id,$company_id){
        $this->setupConnection();
        $isSuccessful= $this->executeQuery("CALL INSERT_ROOM_NUM($room_num,$room_type_id,$company_id)");
        $obj->isValid=FALSE;
        if ($isSuccessful) {
            $obj->isValid=TRUE;
        }else{
            $obj->SQL="CALL INSERT_ROOM_NUM($room_num,$room_type_id,$company_id)";
        }
        $this->closeConnection();
        return json_encode($obj);
    }
}
