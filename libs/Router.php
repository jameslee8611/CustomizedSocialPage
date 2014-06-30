<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Router {

    function __construct() {
        $url = explode('/', rtrim(isset($_GET['url']) ? $_GET['url'] : null, '/'));
        Session::init();
        
        if (empty($url[0]))
        {
            require 'controllers/index.php';   
            $controller = new Index;
            $controller->loadModule('index');
        }
        else
        {
            $file = 'controllers/' . $url[0] . '.php';
            if (file_exists($file)) 
            {
                require $file;
                $controller = new $url[0];
                $controller->loadModule($url[0]);
            }
            else
            {
                $this->usernameURL($url);
            }
        }
        
        if (count($url) > 4)
        {
            $this->redirect_to_error();
        }
        elseif (isset($url[3]))
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2], $url[3]);
            }
            else
            {
                $this->redirect_to_error();
            }
        }
        elseif (isset($url[2])) 
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2]);
            }
            else
            {
                $this->redirect_to_error();
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
                $this->redirect_to_error();
            }
        }
        else
        {
            $controller->index();
        }
    }

    /**
     * If the followed url after main address is not controller, guess that it's the ueser's profile page
     * @param type $url
     */
    private function usernameURL($url)
    {       
        require 'controllers/profile.php';   
        $controller = new Profile();
        $controller->loadModule('profile');
        
        if (count($url) > 2)
        {
            $this->redirect_to_error();
        }
        elseif (isset($url[1]))
        {
            $controller->index($url[0], $url[1]);
        }
        else
        {
            $controller->index($url[0]);
        }
            
        exit;
    }
    
    /**
     * make error page
     */
    private function redirect_to_error()
    {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        
        exit;
    }
}
