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
            if (Session::get('loggedIn'))
            {
                require 'views/header/private.php';
            }
            else
            {
                require 'views/header/public.php';
            }
            // include each css file
            ?><style><?php
                $file = 'public/css/' . $name . '.css';
                if (file_exists($file)) 
                {
                    require $file;
                }
            ?></style><?php
            require 'views/' . $name . '.php';
            require 'views/footer.php';
        }
    }
}