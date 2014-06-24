<?php
/**
 * @author Seungchul Lee
 */

class Signup_Model extends Model {

    function __construct() 
    {
        parent::__construct();
    }

    public function signup()
    {
        if(empty($_POST['username']))
        {
            require 'controllers/error.php';
            $controller = new Error();
            $controller->signup_error("Need to have user name");
        }
        else
        {
            echo $_POST['username'] .'<br />';
            echo $_POST['email'] .'<br />';
            echo $_POST['confirmemail'] .'<br />';
            echo $_POST['password'] .'<br />';
        }
    }
}