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
    
    public function login() 
    {
        $this->model->login();
    }
    
    public function logout()
    {
        $this->model->logout();
    }
}