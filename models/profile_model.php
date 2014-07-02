<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Profile_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    public function check_user($username)
    {
        $dbname = "users";
        $statement = $this->db->select(array("id"), $dbname, array("login"), array($username));
        if(!$statement){
            throw new Exception('Query failed.');
        }
        
        if ($statement->rowCount() > 0)
        {
            return true;
        }
        
        return false;
    }

    public function get_post()
    {
        return array(
            "test", "test comment"
            );
    }
}