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
        if ($this->check_available(array('login', 'email'), array($_POST['username'], $_POST['email']))) 
        {
            $dbname = "users";
            $statement = $this->db->insert($dbname, array('login', 'password', 'email'), 
                array($_POST['username'], md5($_POST['password']), $_POST['email']));
            if(!$statement){
                throw new Exception('Query failed.');
            }

            if ($statement->errorCode()) 
            {
                Session::set('loggedIn', true);
                header('location: ' . URL . 'index/login/' . $_POST['username'] . '/' . $_POST['password']);
            } 
            else 
            {
                echo 'error';
            }
        }
    }

    private function check_available($attrNames, $attrValues) 
    {
        $dbname = "users";
        $statement = $this->db->select(array("id"), $dbname, $attrNames, $attrValues, "or");
        if(!$statement){
            throw new Exception('Query failed.');
        }

        $count = $statement->rowCount();
        if ($count == 0) 
        {
            return true;
        } 
        else 
        {
            // increment fail cnt
            require 'controllers/error.php';
            $controller = new Error();
            $controller->signup_error("This username or email already exists");
            exit;
        }
    }

}
