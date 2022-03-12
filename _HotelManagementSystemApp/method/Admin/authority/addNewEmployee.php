<?php
    include '../../../App_Data/Employee_Admin.php';
    $employee_admin=new Employee_Admin();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $username=$_POST["username"];
    $email=$_POST["email"];
    $password=$_POST["password"];
    $Cpassword=$_POST["Cpassword"];
    $company_id=$_POST["company_id"];
    if (isset($_COOKIE["admin_user"])&&isset($_COOKIE["admin_uid"])) {
        $admin_id=$employee_admin->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    echo $employee_admin->signUpEmployee($firstname, $lastname, $username, $email, $password, $Cpassword, $company_id);
                }else{
                    $myObj->isValid=FALSE;
                    echo json_encode($myObj);
                }
    }else{
        $myObj->isValid=FALSE;
        echo json_encode($myObj);
    }
