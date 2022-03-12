<?php
include '../../../App_Data/Booking_Account.php';
$acc=new Booking_Account();
            $room_num_id=$_POST["room_number"]; 
            $account_id=$acc->getUserID($_COOKIE["username"]); 
            $start_date=$_POST["arrival"];  
            $end_date=$_POST["departure"]; 
            $num_people=$_POST["people"];
            
            $company_id=$_POST["company_id"];
            if (isset($_COOKIE["username"]) && isset($_COOKIE["uid"])) {
                if ($acc->verify($_COOKIE["username"]."", $_COOKIE["uid"]."")) {
                    echo $acc->BookARoom($room_num_id, $account_id, $start_date, $end_date, $num_people);
                }else{
                    $obj->isValid=FALSE;
                    echo json_encode($obj);
                }
            }else{
                $obj->isValid=FALSE;
                    echo json_encode($obj);
            }