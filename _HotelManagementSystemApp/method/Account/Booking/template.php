<?php
include '../App_Data/Booking_Account.php';
            include 'header.php'; 
            $acc=new Booking_Account();
            if (isset($_COOKIE["username"]) && isset($_COOKIE["uid"])) {
                
                if ($acc->verify($_COOKIE["username"]."", $_COOKIE["uid"]."")) {
                    
                }else{
                    $obj->isValid=FALSE;
                    echo json_encode($obj);
                }
            }else{
                $obj->isValid=FALSE;
                    echo json_encode($obj);
            }