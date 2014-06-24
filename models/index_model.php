<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Index_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function login()
    {
        $state = $this->db->prepare("SELECT id FROM users WHERE login = :login AND password = MD5(:password)");
        $state->execute(array(
            ':login' => $_POST['login'],
            ':password' => $_POST['password']
        ));
        
        $count = $state->rowCount();
        if($count > 0)
        {
            //login
            Session::set('loggedIn', true);
            header('location: '.URL);
        }
        else
        {
            //show error
            header('location: ../forget');
        }
    }
    
    public function logout()
    {
        Session::destroy();
        header('location: '.URL);
        exit;
    }
    
    public function signup()
    {
        echo 'sing up page <br />';
    }
}