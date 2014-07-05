<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../libs/Router.php';
require '../../libs/Controller.php';
require '../../libs/View.php';
require '../../libs/Model.php';

//Library
require '../../libs/Database.php';
require '../../libs/Session.php';

require '../constant.php';
require '../database.php';

$db = new Database();
$query = 
"CREATE TABLE users
(
	id int NOT NULL AUTO_INCREMENT,
	login varchar(25) NOT NULL,
	email varchar(32) NOT NULL,
	password varchar(32) NOT NULL,
	reset varchar(32) default NULL,
	PRIMARY KEY (id)
);";

$statement = $db->prepare($query);
$success = $statement->execute();

if($success)
    echo 'DBs have been successfully created.';
else echo 'DBs failed to be created.';  

?>