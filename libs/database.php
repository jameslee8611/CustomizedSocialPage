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

    public function update() {
        $query = "select "; 

        for ($x=0; $x<count($colNames); $x++) {
            if($x < count($colNames) - 1)
                $query .= $colNames[$x] . ", ";
            else $query .= $colNames[$x] . " ";
        } 

        $statement = $db->prepare("select id from some_table where name = :name");
        $statement->execute(array(':name' => "Jimbo"));
        $row = $statement->fetch();
    }

    public function insert() {

    }

    public function delete() {

    }

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
        //echo $query . "<br>";
        
        $statement = $this->prepare($query);
        $statement->execute();
        return $statement;        
    }

}

?>