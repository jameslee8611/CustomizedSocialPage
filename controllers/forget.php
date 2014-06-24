<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Forget extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function Index()
    {
        $this->view->render('forget/index');
    }
}