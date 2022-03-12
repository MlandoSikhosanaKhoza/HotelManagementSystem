<?php
    include 'Connection.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Account
 *
 * @author Mlando Sikhosana Khoza
 */
class Account extends Connection{
    //put your code here
    function __construct(){
        
    }
    public function verify($username,$uid){
        $this->setupConnection();
        $account_id=-1;
        $password;
        $username= $this->processData($username);
        $username= strtolower($username);
        $query1=$this->Query("CALL ACCOUNT_QUERY('$username')");
        if ($query1!==NULL) {
            while ($row = mysqli_fetch_assoc($query1)) {
                $account_id=$row["ACCOUNT_ID"];
                $password=$row["PASSWORD"]."";
            }
            $valid_uid= $this->generateID($username, $password, $uid);
            mysqli_close($this->CONN);
            $this->setupConnection();
            $query2= $this->Query("CALL COOKIE_QUERY($account_id,'$valid_uid')");
            if($query2!==NULL){
                
                mysqli_close($this->CONN);
                return TRUE;
            }
        }
        mysqli_close($this->CONN);
        return FALSE;
    }
    public function getUserID($username){
        $this->setupConnection();
        $account_id=-1;
        $username= $this->processData($username);
        $username= strtolower($username);
        $query1=$this->Query("CALL ACCOUNT_QUERY('$username')");
        if ($query1!==NULL) {
            while ($row = mysqli_fetch_assoc($query1)) {
                $account_id=$row["ACCOUNT_ID"];
            }
        }
        $this->closeConnection();
        return $account_id;
    }

    private function generateID($username,$password,$cookie_uid){
        $username= strtolower($username);
        $valid_uid=$username . $password . $cookie_uid;
        $valid_uid=hash("sha256", $valid_uid);
        return $valid_uid;
    }

    public function login($username,$password){
        $username= $this->processData($username);
        $username= strtolower($username);
        $password= hash("sha256", $password)."";
        $pass="";
        $uid="";
        $account_id=-1;
        /*Query 1: Validate the username and password. Get User details*/
        $this->setupConnection();
        $query= $this->Query("CALL LOGIN_QUERY('$username','$password');");
        if ($query!==NULL) {
            $json_str="";
            while ($row = mysqli_fetch_assoc($query)) {
                $account_id=$row["ACCOUNT_ID"];
                $pass=$row["PASSWORD"];
                $json_str .= ',"'.$row["DETAIL_NAME"].'" : "'.$row["DETAIL_VALUE"].'"';
            }
            mysqli_close($this->CONN);
            /*Query 2: Setup Cookie*/
            $this->setupConnection();
            $cookie_uid=uniqid(rand());
            $uid=$this->generateID($username, $pass, $cookie_uid);
            $start_date= date("Y-m-d H:i:s");
            $end_date= date("Y-m-d H:i:s", strtotime("+30 days"));
            $sql="CALL ADD_ACCOUNT_COOKIE('$uid','$start_date','$end_date',$account_id);";
            $cookieSuccessful=$this->executeQuery($sql);
            if ($cookieSuccessful) {
                mysqli_close($this->CONN);
                return '{"isValid": true'.$json_str.',"g_uid":"'. $uid .'","password":"'. $pass .'","username":"'. $username .'","uid":"'. $cookie_uid .'"}';
            }else{
                $myobj->isValid=FALSE;
                $myobj->message=$sql;
                return json_encode($myobj);
            }
        }else{
            mysqli_close($this->CONN);
        }
        $myobj->isValid=FALSE;
        return json_encode($myobj);
    }
    public function signUp($firstname,$lastname,$username,$email,$password,$Cpassword){
        $firstname= $this->processData($firstname);
        $lastname= $this->processData($lastname);
        $username= $this->processData($username);
        $email= $this->processData($email);
        $password= hash("sha256", $password)."";
        $Cpassword= hash("sha256", $Cpassword)."";
        
        $this->setupConnection();
        $insertSuccessful=$this->executeQuery("CALL SIGNUP('$firstname','$lastname','$email','$username','$password')");
        if ($insertSuccessful) {
            $json_obj->isValid=TRUE;
            mysqli_close($this->CONN);
            return json_encode($json_obj);
        }else{
            $json_obj->isValid=FALSE;
            $json_obj->Message=$username;
            mysqli_close($this->CONN);
            return json_encode($json_obj);
        }
    }
    
}
