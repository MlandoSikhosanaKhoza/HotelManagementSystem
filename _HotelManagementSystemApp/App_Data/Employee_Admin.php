<?php
include 'Service_Admin.php';
include 'oop/Employee.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Employee_Admin
 *
 * @author Mlando Sikhosana Khoza
 */
class Employee_Admin extends Service_Admin{
    //put your code here
    public function listEmployees($company_id){
        $this->setupConnection();
        $list_employees=[];
        $query= $this->Query("CALL SELECT_EMPLOYEE_FOR_COMPANY($company_id)");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)){
                $obj=new Employee();
                $obj->EmployeeID=$row["EMPLOYEE_ID"];
                $obj->FullName=$row["FULLNAME"];
                array_push($list_employees, $obj);
            }
        }
        $this->closeConnection();
        return $list_employees;
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
        $query= $this->Query("CALL LOGIN_EMPLOYEE_QUERY('$username','$password');");
        if ($query!==NULL) {
            $json_str="";
            while ($row = mysqli_fetch_assoc($query)) {
                $admin_id=$row["EMPLOYEE_ID"];
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
            $sql="CALL ADD_EMPLOYEE_COOKIE('$uid','$start_date','$end_date',$admin_id);";
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
    public function signUpEmployee($firstname,$lastname,$username,$email,$password,$Cpassword,$company_id){
        $firstname= $this->processData($firstname);
        $lastname= $this->processData($lastname);
        $username= $this->processData($username);
        $email= $this->processData($email);
        $password= hash("sha256", $password)."";
        $Cpassword= hash("sha256", $Cpassword)."";
        
        $this->setupConnection();
        $sql="CALL SIGNUP_EMPLOYEE('$firstname','$lastname','$email','$username','$password',$company_id)";
        $insertSuccessful=$this->executeQuery($sql);
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
