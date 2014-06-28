<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Router {

    function __construct() {
        $url = explode('/', rtrim(isset($_GET['url']) ? $_GET['url'] : null, '/'));
//        print_r($url);
//        echo '<br />';
        Session::init();
        
        $file = 'controllers/' . $url[0] . '.php';
        if(file_exists($file)) 
        {
            require $file;
        }
        else
        {
            require 'controllers/index.php';
            $controller = new Index();
            $controller->loadModule('index');
            $controller->index($url[0]);
            return false;
        }
        
        $controller = new $url[0];
        $controller->loadModule($url[0]);

        if (isset($url[3]))
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2], $url[3]);
            }
            else
            {
                require 'controllers/error.php';
                $controller = new Error();
                $controller->index();
            }
        }
        else if (isset($url[2])) 
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2]);
            }
            else
            {
                require 'controllers/error.php';
                $controller = new Error();
                $controller->index();
            }
        } 
        elseif (isset($url[1])) 
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}();
            }
            else
            {
                require 'controllers/error.php';
                $controller = new Error();
                $controller->index();
            }
        }
        else
        {
            $controller->index();
        }
    }

}
