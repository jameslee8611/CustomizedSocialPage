<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Setting extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        if(Session::get('loggedIn') == true)
        {
            $this->view->render('setting/index');
        }
        else
        {
            require 'controllers/error.php';
            $controller = new Error();
            $controller->index();
            return false;
        }
    }
    
    public function changePassword()
    {
        echo 'change Password';
    }
}