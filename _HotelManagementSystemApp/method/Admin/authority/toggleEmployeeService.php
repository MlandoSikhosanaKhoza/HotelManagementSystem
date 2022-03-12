<?php
    include '../../../App_Data/Service_Admin.php';
    $admin=new Service_Admin();
    $employee_id=$_POST["employee_id"];
    $service_id=$_POST["service_id"];
    if (isset($_COOKIE["admin_user"])&&isset($_COOKIE["admin_uid"])) {
        $admin_id=$admin->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    echo $admin->toggleEmployeeServices($service_id,$employee_id);
                }else{
                    $myObj->isValid=FALSE;
                    echo json_encode($myObj);
                }
    }else{
        $myObj->isValid=FALSE;
        echo json_encode($myObj);
    }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

