<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Setting_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function changePassword()
    {
        $statement = $this->db->select( array("id"), "users", array("password"), array(md5($_POST['old_password'])) );
        if($statement->rowCount() < 1)
        {
            return false;
        }
        else
        {
            $statement = $this->db->update("users", 
                            array("password"), 
                            array(md5($_POST['new_password'])), 
                            array("login"), 
                            array(Session::get('username')));
            
            return true;
        }
    }
}