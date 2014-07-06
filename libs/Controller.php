<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller {

    function __construct() {
        $this->view = new View();
    }

    public function loadModule($name) {
        $path = 'models/'. $name . '_model.php';
        
        if (file_exists($path))
        {
            require 'models/'. $name . '_model.php';
            $modelName = $name . '_Model';
            $this->model = new $modelName;
        }
        
        if($name == 'index')
        {
            require 'models/helpers/rememberMe.php';
        }
    }
}