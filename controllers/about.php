<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class About extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('about/index');
    }
    
    public function other() {
        require 'models/about_model.php';
        $model = new About_Model();
        $model->view->test = $model->test();
    }
    
    public function otherWithArg($arg = false) {
        echo 'We are inside otherWithArg at help<br />';
        echo 'Optional: ' . $arg .'<br />';
        $this->view->render('about/index');
    }
}
