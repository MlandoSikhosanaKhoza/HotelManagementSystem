<?php
    include '../../../App_Data/Admin.php';
    $admin=new Admin();
    $company_id=$_POST["company_id"];
    if (isset($_COOKIE["admin_user"])&&isset($_COOKIE["admin_uid"])) {
        $admin_id=$admin->getAdminID($_COOKIE["admin_user"]."", $_COOKIE["admin_uid"]."");
                if ($admin_id>0) {
                    echo $admin->showCompanyDetails($company_id);
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

