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

}