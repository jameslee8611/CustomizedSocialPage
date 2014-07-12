<?php
/**
 * @author  Seungchul Lee
 * @date    July 5, 2014
 */

class Index extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    public function index() 
    {
        if ($this->model->checkReturnUser() || Session::get('loggedIn') == true)
        {
            $this->view->render('index/main');
            exit;
        }
        else
        {
            $this->view->render('index/signup');
            exit;
        }
    }
    
    public function login($login = null, $password = null) 
    {
        if($this->model->login($login, $password) == false)
        {
            $this->view->login_failed = true;
            $this->view->render('index/signup');
            exit;
        }
    }
    
    public function logout()
    {
        $this->model->logout();
    }
}