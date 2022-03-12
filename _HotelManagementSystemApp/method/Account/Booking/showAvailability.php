<?php
include '../../../App_Data/Booking_Account.php';
            
            $acc=new Booking_Account();
            //$company_id=$_POST["company_id"];
            $room_type_id=$_POST["room_type_id"];
            $start_date=$_POST["arrival"];
            $end_date=$_POST["departure"];
            if (isset($_COOKIE["username"]) && isset($_COOKIE["uid"])) {
                if ($acc->verify($_COOKIE["username"]."", $_COOKIE["uid"]."")) {
                    echo json_encode($acc->getRoomNums($room_type_id, $start_date, $end_date));
                }else{
                    $obj->isValid=FALSE;
                    echo json_encode($obj);
                }
            }else{
                $obj->isValid=FALSE;
                    echo json_encode($obj);
            }