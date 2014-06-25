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
        $this->view->render('index/index');
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