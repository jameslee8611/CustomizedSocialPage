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
        
        $state = $this->db->prepare("SELECT id FROM users WHERE login = :login AND password = MD5(:password)");
        $state->execute(array(
            ':login' => $login,
            ':password' => $password
        ));
        
        $count = $state->rowCount();
        if($count > 0)
        {
            Session::set('loggedIn', true);
            Session::set('username', $login);
            header('location: '.URL);
        }
        else
        {
            header('location: ../forget');
        }
    }
    
    public function logout()
    {
        Session::destroy();
        header('location: '.URL);
        exit;
    }
}