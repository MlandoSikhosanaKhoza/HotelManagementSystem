<?php
    include 'Connection.php';
    include 'oop/Company.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Mlando Sikhosana Khoza
 */
class Admin extends Connection{
    //put your code here
    //put your code here
    function __construct(){
        
    }
    public function verify($username,$uid){
        $this->setupConnection();
        $admin_id=-1;
        $password;
        $username= $this->processData($username);
        $username= strtolower($username);
        $query1=$this->Query("CALL SELECT_USER_ADMIN_QUERY('$username')");
        if ($query1!==NULL) {
            while ($row = mysqli_fetch_assoc($query1)) {
                $admin_id=$row["ADMIN_ID"];
                $password=$row["PASSWORD"]."";
            }
            $valid_uid= $this->generateID($username, $password, $uid);
            mysqli_close($this->CONN);
            $this->setupConnection();
            $query2= $this->Query("CALL ADMIN_COOKIE_QUERY($admin_id,'$valid_uid')");
            if($query2!==NULL){
                
                mysqli_close($this->CONN);
                return TRUE;
            }
        }
        mysqli_close($this->CONN);
        return FALSE;
    }
    public function getAdminID($username,$uid){
        $this->setupConnection();
        $admin_id=-1;
        $password;
        $username= $this->processData($username);
        $username= strtolower($username);
        $query1=$this->Query("CALL SELECT_USER_ADMIN_QUERY('$username')");
        if ($query1!==NULL) {
            while ($row = mysqli_fetch_assoc($query1)) {
                $admin_id=$row["ADMIN_ID"];
                $password=$row["PASSWORD"]."";
            }
            $valid_uid= $this->generateID($username, $password, $uid);
            mysqli_close($this->CONN);
            $this->setupConnection();
            $query2= $this->Query("CALL ADMIN_COOKIE_QUERY($admin_id,'$valid_uid')");
            if($query2!==NULL){
                mysqli_close($this->CONN);
                return $admin_id;
            }
        }
        mysqli_close($this->CONN);
        return $admin_id;
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
        $query= $this->Query("CALL ADMIN_QUERY('$username','$password');");
        if ($query!==NULL) {
            $json_str="";
            while ($row = mysqli_fetch_assoc($query)) {
                $admin_id=$row["ADMIN_ID"];
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
            $sql="CALL ADD_ADMIN_COOKIE('$uid','$start_date','$end_date',$admin_id);";
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
        $insertSuccessful=$this->executeQuery("CALL SIGNUP_ADMIN('$firstname','$lastname','$email','$username','$password')");
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
    public function addNewCompany($companyname,$address,$city,$postalcode,$username,$email,$password,$Cpassword,$admin_id){
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
    public function showCompanyName($company_id){
        $this->setupConnection();
        $companyname="";
        $query= $this->Query("CALL GET_COMPANY_DETAIL($company_id,'companyname')");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $companyname=$row["DETAIL_VALUE"];
            }
        }
        $this->closeConnection();
        return $companyname;
    }

    public function listCompanies($admin_id){
        $this->setupConnection();
        $company_list=array();
        $selected_company;
        $query= $this->Query("CALL SELECT_COMPANY_LIST($admin_id)");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $selected_company=new Company();
                $selected_company->setCompanyID($row["COMPANY_ID"]);
                $selected_company->setCompanyName($row["COMPANYNAME"]);
                array_push($company_list, $selected_company);
            }
        }
        $this->closeConnection();
        return $company_list;
    }
    
    public function showCompanyDetails($company_id){
        $this->setupConnection();
        $json_format=[];
        $json_format["isValid"]=true;
        $query= $this->Query("CALL GET_COMPANY_DETAILS($company_id);");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)) {
                $json_format[$row["DETAIL_NAME"]]=$row["DETAIL_VALUE"];
            }
        }
        $this->closeConnection();
        return json_encode($json_format);
    }
}
