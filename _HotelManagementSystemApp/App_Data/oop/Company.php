<?php

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
class Company {
    //put your code here
    private $company_id;
    private $company_name;
    function __construct(){
        
    }
    
    public function getCompanyID(){
        return $this->company_id;
    }
    public function setCompanyID($number){
        $this->company_id=$number;
    }
    public function getCompanyName(){
        return $this->company_name;
    }
    public function setCompanyName($name){
        $this->company_name=$name;
    }
}
