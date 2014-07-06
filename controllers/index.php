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
            if(isset($_SESSION['loginFailed'])){
                $this->view->login_failed = Session::get('loginFailed');
                unset($_SESSION['loginFailed']);
            }
            $this->view->render('index/signup');
            exit;
        }
    }
    
    public function login($login = null, $password = null) 
    {
        $this->model->login($login, $password);
    }
    
    public function logout()
    {
        $this->model->logout();
    }
}