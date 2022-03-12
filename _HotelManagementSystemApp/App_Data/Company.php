<?php
include 'Connection.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author Admin
 */
class Company extends Connection{
    //put your code here
    
    public function verify($username,$uid){
        $this->setupConnection();
        $admin_id=-1;
        $password;
        $username= $this->processData($username);
        $username= strtolower($username);
        $query1=$this->Query("CALL SELECT_USER_COMPANY_QUERY('$username')");
        if ($query1!==NULL) {
            while ($row = mysqli_fetch_assoc($query1)) {
                $admin_id=$row["COMPANY_ID"];
                $password=$row["PASSWORD"]."";
            }
            $valid_uid= $this->generateID($username, $password, $uid);
            mysqli_close($this->CONN);
            $this->setupConnection();
            $query2= $this->Query("CALL COMPANY_COOKIE_QUERY($admin_id,'$valid_uid')");
            if($query2!==NULL){
                
                mysqli_close($this->CONN);
                return TRUE;
            }
        }
        mysqli_close($this->CONN);
        return FALSE;
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
        $admin_id=-1;
        /*Query 1: Validate the username and password. Get User details*/
        $this->setupConnection();
        $query= $this->Query("CALL COMPANY_QUERY('$username','$password');");
        if ($query!==NULL) {
            $json_str="";
            while ($row = mysqli_fetch_assoc($query)) {
                $admin_id=$row["COMPANY_ID"];
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
            $sql="CALL ADD_COMPANY_COOKIE('$uid','$start_date','$end_date',$admin_id);";
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
    public function signUp($companyname,$address,$city,$postalcode,$username,$email,$password,$Cpassword,$admin_id){
        $companyname= $this->processData($companyname);
        $city= $this->processData($city);
        $postalcode= $this->processData($postalcode);
        $address= $this->processData($address);
        $username= $this->processData($username);
        $email= $this->processData($email);
        $password= hash("sha256", $password)."";
        $Cpassword= hash("sha256", $Cpassword)."";
        $this->setupConnection();
        $insertSuccessful=$this->executeQuery("CALL SIGNUP_COMPANY('$companyname','$address','$city','$postalcode','$email','$username','$password',$admin_id)");
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
