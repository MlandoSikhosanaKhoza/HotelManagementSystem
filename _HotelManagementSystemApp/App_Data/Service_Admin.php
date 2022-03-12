<?php
    include 'Admin.php';
    include 'oop/Services.php';
     include 'oop/Service_Checkbox.php';
     include 'oop/Category.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service_Admin
 *
 * @author Mlando Sikhosana Khoza
 */
class Service_Admin extends Admin{
    //put your code here
    public function getServices($company_id){
        $this->setupConnection();
        $list_services=[];
        $query= $this->Query("CALL GET_SERVICES($company_id)");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)){
                
                $abc=new Services();
                $abc->ServiceID=$row["SERVICE_ID"];
                $abc->ServiceName=$row["SERVICE_NAME"];
                if ($row["CATEGORY_ID"]==NULL) {
                    $abc->CategoryName="Uncategorized";
                }else{
                    $abc->CategoryID=$row["CATEGORY_ID"];
                    $abc->CategoryName=$row["CATEGORY_NAME"];
                }
                
                $abc->Description=$row["DESCRIPTION"];
                $abc->Price=$row["PRICE"];
                array_push($list_services, $abc);
            }
        }
        $this->closeConnection();
        return $list_services;
    }
    public function toggleEmployeeServices($service_id,$employee_id){
        $this->setupConnection();
        $obj->isValid=FALSE;
            $isSuccessful=$this->executeQuery("CALL TOGGLE_EMPLOYEE_SERVICE($service_id,$employee_id)");
            if ($isSuccessful) {
                $obj->isValid=TRUE;
            }    
            $this->closeConnection();
            return json_encode($obj);
    }
    public function getEmployeeServices($employee_id){
        $this->setupConnection();
        $list_es=[];
            $result=$this->Query("SELECT * FROM EMPLOYEE_SERVICE ES WHERE ES.EMPLOYEE_ID=".$employee_id);
            if ($result!==NULL) {
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($list_es, $row["SERVICE_ID"]);
                }
            }    
            $this->closeConnection();
            return json_encode($list_es);
    }
    public function getCategories($company_id){
        $this->setupConnection();
        $list_categories=[];
        $query= $this->Query("CALL GET_CATEGORIES($company_id)");
        if ($query!==NULL) {
            while ($row = mysqli_fetch_assoc($query)){
                $obj=new Category();
                $obj->CategoryID=$row["CATEGORY_ID"];
                $obj->CategoryName=$row["CATEGORY_NAME"];
                array_push($list_categories, $obj);
            }
        }
        $this->closeConnection();
        return $list_categories;
    }
    
    public function addCategory($category_name,$company_id){
        $this->setupConnection();
        $category_name= $this->processData($category_name);
        $isSuccessfulQuery= $this->executeQuery("CALL INSERT_CATEGORY('$category_name',$company_id)");
        if ($isSuccessfulQuery) {
            $obj->isValid=TRUE;
            return json_encode($obj);
        }
        $this->closeConnection();
        $obj->isValid=FALSE;
        return json_encode($obj);
    }
    
    public function addService($category_id,$service_name,$description,$price,$company_id){
        $this->setupConnection();
        $service_name= $this->processData($service_name);
        $description= $this->processData($description);
        $isSuccessfulQuery= $this->executeQuery("CALL INSERT_SERVICE($category_id,'$service_name','$description',$price,$company_id)");
        if ($isSuccessfulQuery) {
            $obj->isValid=TRUE;
            return json_encode($obj);
        }
        $this->closeConnection();
        $obj->isValid=FALSE;
        $obj->SQL="CALL INSERT_SERVICE($category_id,'$service_name','$description',$price,$company_id);";
        return json_encode($obj);
    }
}
