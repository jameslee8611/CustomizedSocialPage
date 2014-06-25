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
        if ($this->check_existance($_POST['username'], 'login') && $this->check_existance($_POST['email'], 'email')) 
        {
            $state = $this->db->prepare("INSERT INTO users (login, password, email) VALUES(:login, :password, :email)");
            $state->execute(array(
                ':login' => $_POST['username'],
                ':password' => md5($_POST['password']),
                ':email' => $_POST['email'],
            ));

            if ($state->errorCode()) 
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

    private function check_existance($param, $target) 
    {
        $state = $this->db->prepare("SELECT id FROM users WHERE " . $target . " = :" . $target);
        $state->execute(array(
            ':' . $target => $param
        ));

        $count = $state->rowCount();
        if ($count == 0) 
        {
            return true;
        } 
        else 
        {
            // increment fail cnt
            require 'controllers/error.php';
            $controller = new Error();
            $controller->signup_error($param . " already exists");
            exit;
        }
    }

}
