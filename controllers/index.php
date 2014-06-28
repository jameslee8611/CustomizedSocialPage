<?php
/**
 * @author Seungchul Lee
 */

class Index extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    public function index($username=null) 
    {
        if ($username == null)
        {
            if (Session::get('loggedIn') == true)
            {
                $this->view->render('index/main');
            }
            else
            {
                $this->view->render('index/signup');
            }
        }
        elseif ($this->model->check_user($username))
        {
            if (Session::get('loggedIn') == true)
            {
                $this->view->render('index/profile');
            }
            else
            {
                $this->view->render('index/profile_public');
            }
        }
        else
        {
            require 'controllers/error.php';
            $controller = new Error();
            $controller->index();
            return false;
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