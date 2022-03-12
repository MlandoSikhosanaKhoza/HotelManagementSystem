<?php
    include '../../../App_Data/Service_Admin.php';
    $admin=new Service_Admin();
    $category_id=$_POST["category_id"];
    if($category_id==""){
        $category_id="NULL";
    }
    $service_name=$_POST["servicename"];
    $description=$_POST["description"];
    $price=$_POST["price"];
    $company_id=$_POST["company_id"];
    if (isset($_COOKIE["admin_user"])&&isset($_COOKIE["admin_uid"])) {
        $admin_id=$admin->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    echo $admin->addService($category_id, $service_name, $description, $price, $company_id);
                }else{
                    $myObj->isValid=FALSE;
                    $myObj->admin=$admin_id;
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

