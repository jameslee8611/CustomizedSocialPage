<?php

/**
 * View class will redner header and footer in each page.
 * One neccessary part of MVC structure
 * 
 * @author  Seungchul Lee
 * @date    July 1, 2014
 */

class View {

    function __construct() {
        
    }

    public function render($name, $headerIncludes = false) {
        if($headerIncludes == true)
        {
            require 'views/' . $name . '.php';
        }
        else
        {
            require 'views/header.php';
            require 'views/' . $name . '.php';
            require 'views/footer.php';
        }
    }
}