<?php
    include '../../App_Data/Admin.php';
    $admin=new Admin();
    $companyname=$_POST["companyname"];
    $username=$_POST["username"];
    $email=$_POST["email"];
    $address=$_POST["address"];
    $city=$_POST["city"];
    $postalcode=$_POST["postalcode"];
    $password=$_POST["password"];
    $Cpassword=$_POST["confirmPassword"];
    if (isset($_COOKIE["admin_user"])&&isset($_COOKIE["admin_uid"])) {
        $admin_id=$admin->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    echo $admin->addNewCompany($companyname, $address, $city, $postalcode, $username, $email, $password, $Cpassword, $admin_id);
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

