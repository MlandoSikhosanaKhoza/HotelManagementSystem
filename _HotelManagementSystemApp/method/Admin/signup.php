<?php
    include '../../App_Data/Admin.php';
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $username=$_POST["username"];
    $email=$_POST["email"];
    $password=$_POST["password"];
    $Cpassword=$_POST["Cpassword"];
    $admin=new Admin();
    $str=$admin->signUp($firstname, $lastname, $username, $email, $password, $Cpassword);
    echo $str;

