<?php
/**
 * @author Seungchul
 * @date   July 5, 2014
 */

class Index_Model extends Model {

    function __construct() 
    {
        parent::__construct();
    }
    
    public function checkReturnUser()
    {
        $key = pack("H*", MYKEY);
        $rememberMe = new RememberMe($key);

        if ($data = $rememberMe->auth()) 
        {
            $rememberMe->remember($data['user']);
            Session::set('loggedIn', true);
            Session::set('username', $data['user']);
            $query_whereId = $this->db->select(array("Id"), "users", array("login"), array($data['user']));
            $row =$query_whereId->fetchAll();
            $whereId = $row[0]['Id'];
            Session::set('userId', $whereId);
            Session::set('profile_pic', null);
            return true;
        } 
        else
        {
            return false;
        }
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

        $statement = $this->db->select(array("id"), "users", array("login", "password"), array($login, MD5($password)));
        
        if(!$statement){
            throw new Exception('Query failed.');
        }
        
        if($statement->rowCount() > 0)
        {
            $row = $statement->fetchAll();
            $whereId = $row[0]['id'];
            Session::set('loggedIn', true);
            Session::set('username', $login);
            Session::set('userId', $whereId);
            Session::set('profile_pic', null);
            
            if (!empty($_POST['keep_loggedIn']) || isset($_POST['keep_loggedIn']))
            {
                $key = pack("H*", MYKEY); 
                $rememberMe = new RememberMe($key);
                $rememberMe->remember($login);
            }
            
            #$this->view->login_failed = false;
            header('location: '.URL);
        }
        else
        {
            #header('location: '.URL);
            return false;
        }
    }
    
    public function logout()
    {
        $this->db->update("users", 
                        array("remember_info"), 
                        array(null), 
                        array("login"), 
                        array(Session::get('username')));
        
        Cookie::remove('auto');
        
        Session::destroy();
        header('location: '.URL);
        exit;
    }
}