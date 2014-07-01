<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Database extends PDO {

    function __construct() {
        parent::__construct("mysql:host=".Host.";dbname=".DBName, DBUser, DBPassword);
    }

    public function update($dbname, $updateAttrNames, $updateAttrValues, $attrNames, $attrValues) {
        $updateAttrNum = count($updateAttrNames);
        if($updateAttrNum < 1 || $updateAttrNum != count($updateAttrValues))
            return NULL;

        $attrNum = count($attrNames);
        if($attrNum != count($attrValues))
            return NULL;
        
        $query = "update $dbname set"; 

        for ($x = 0; $x < $updateAttrNum; $x++) {
            $query .= " $updateAttrNames[$x] = '$updateAttrValues[$x]'";
            if($x < $updateAttrNum - 1)
                $query .= ", ";
        } 

        if($attrNum > 0){
            $query .= " where ";
            for ($x = 0; $x < $attrNum; $x++) {
                $query .= "$attrNames[$x] = '$attrValues[$x]'";
                if($x < $attrNum - 1){
                    $query .= " and ";
                }
            } 
        }            
        
        $statement = $this->prepare($query);
        $success = $statement->execute();
        if($success)
            return $statement;     
        else return NULL;   
        
    }

    public function insert() {
        echo $query . "<br>";
    }

    public function delete($dbname, $attrNames, $attrValues) {
        $query = "delete from $dbname"; 
        $attrNum = count($attrNames);
        if(($attrNum > 0) && ($attrNum == count($attrValues))){
            $query .= " where ";
            for ($x = 0; $x < $attrNum; $x++) {
                $query .= "$attrNames[$x] = '$attrValues[$x]'";
                if($x < $attrNum - 1){
                    $query .= " and ";
                }
            } 
        }
                
        $statement = $this->prepare($query);
        $success = $statement->execute();
        if($success)
            return $statement;     
        else return NULL;   
    }

    /*
     * Need to handle invalid parameters
     */
    public function select($colNames, $dbname, $attrNames, $attrValues) {
        /*
        $statement = $this->prepare("select id, login, password, email, reset from users where login = :login");
        $statement->execute(array(':login' => "yjw9012"));
        return $statement;
        */
        $query = "select "; 
        $colNum = count($colNames);
        for ($x = 0; $x < $colNum; $x++) {
            $query .= "$colNames[$x]";
            if($x < $colNum - 1){
                $query .= ", ";
            }
        } 
        $query .= " from $dbname";

        $attrNum = count($attrNames);
        if(($attrNum > 0) && ($attrNum == count($attrValues))){
            $query .= " where ";
            for ($x = 0; $x < $attrNum; $x++) {
                $query .= "$attrNames[$x] = '$attrValues[$x]'";
                if($x < $attrNum - 1){
                    $query .= " and ";
                }
            } 
        }        

        $statement = $this->prepare($query);
        $success = $statement->execute();
        if($success)
            return $statement;     
        else return NULL;   
    }

}

?>