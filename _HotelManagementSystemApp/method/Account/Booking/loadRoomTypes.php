<?php
include '../../../App_Data/Booking_Account.php';
            
            $acc=new Booking_Account();
            $company_id=$_POST["company_id"];
            if (isset($_COOKIE["username"]) && isset($_COOKIE["uid"])) {
                if ($acc->verify($_COOKIE["username"]."", $_COOKIE["uid"]."")) {
                    echo $acc->printJSONRoomTypes($company_id);
                }else{
                    $obj->isValid=FALSE;
                    echo json_encode($obj);
                }
            }else{
                $obj->isValid=FALSE;
                    echo json_encode($obj);
            }