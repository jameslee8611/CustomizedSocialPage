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
        $state = $this->db->prepare("SELECT id FROM users WHERE login = :login");
        $state->execute(array(
            ':login' => $username
        ));
        
        if ($state->rowCount() > 0)
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