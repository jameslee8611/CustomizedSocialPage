<?php
/**
 * 
 */

class Index_Model extends Model {

    function __construct() 
    {
        parent::__construct();
    }

    public function login($login, $password)
    {
        if(empty($login) && empty($_POST['login']))
        {
            header('location: '.URL);
            exit;
        }
        elseif(!empty($_POST['login']))
        {
            $login = $_POST['login'];
            $password = $_POST['password'];
        }

        $dbname = "users";
        $statement = $this->db->select(array("id"), $dbname, array("login", "password"), array($login, MD5($password)));
        if(!$statement){
            throw new Exception('Query failed.');
        }
               
        $count = $statement->rowCount();
        if($count > 0)
        {
            Session::set('loggedIn', true);
            Session::set('username', $login);
            header('location: '.URL);
        }
        else
        {
            Session::set('loginFailed', true);
            header('location: '.URL);
            #header('location: ../forget');
        }
    }
    
    public function logout()
    {
        Session::destroy();
        header('location: '.URL);
        exit;
    }
}