<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Connection{
    private $DB_HOST='localhost';
    private $DB_USER='root';
    private $DB_PASSWORD='mlando';
    private $DB_NAME='finaltesting1';
    protected $CONN;
    protected function getConnection() {
        $conn= mysqli_connect($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD, $this->DB_NAME);
        return $conn;
    }
    protected function setupConnection() {
        $this->CONN= mysqli_connect($this->DB_HOST, $this->DB_USER, $this->DB_PASSWORD, $this->DB_NAME);
    }
    protected function processData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = str_replace("'", "''", $data);
        return $data;
    }
    protected function Query($sql){
        $result = mysqli_query($this->CONN, $sql);

        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
        return NULL;
    }
    protected function closeConnection(){
        mysqli_close($this->CONN);
    }

    protected function executeQuery($sql){
        return mysqli_query($this->CONN, $sql);
    }
}