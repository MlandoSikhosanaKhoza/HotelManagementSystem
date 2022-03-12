<?php
    include '../../App_Data/Account.php';
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $username=$_POST["username"];
    $email=$_POST["email"];
    $password=$_POST["password"];
    $Cpassword=$_POST["Cpassword"];
    $acc=new Account();
    $str=$acc->signUp($firstname, $lastname, $username, $email, $password, $Cpassword);
    echo $str;

