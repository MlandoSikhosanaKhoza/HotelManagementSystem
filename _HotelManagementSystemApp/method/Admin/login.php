<?php
    include '../../App_Data/Admin.php';
    $username=$_POST["username"];
    $password=$_POST["password"];
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $admin=new Admin();
    echo $admin->login($username, $password);