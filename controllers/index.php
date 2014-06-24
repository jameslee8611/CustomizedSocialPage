<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Index extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    public function index() 
    {
        $this->view->render('index/index');
    }
    
    public function login() 
    {
        $this->model->login();
    }
    
    public function logout()
    {
        $this->model->logout();
    }
    
    public function signup()
    {
        $this->model->signup();
    }
}