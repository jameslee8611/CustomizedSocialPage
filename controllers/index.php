<?php
/**
 * @author Seungchul Lee
 */

class Index extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    public function index() 
    {
        if (Session::get('loggedIn') == true)
        {
            $this->view->render('index/main');
            echo 'hide_login_error()';
        }
        else
        {
            $this->view->render('index/signup');
            if(isset($_SESSION['show_error']))
            {
                Session::get('show_error');
            }
        }
    }
    
    public function login($login = false, $password = false) 
    {
        $this->model->login($login, $password);
    }
    
    public function logout()
    {
        $this->model->logout();
    }
}