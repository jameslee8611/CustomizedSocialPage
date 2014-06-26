<?php
/**
 * @author Seungchul Lee
 */

class Forget extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function Index()
    {
        if (Session::get('loggedIn'))
        {
            $this->forget_render(ERROR);
        }
        else
        {
            $this->forget_render();
        }
    }
    
    public function success()
    {
        $this->forget_render(SUCCESS);
    }
    
    public function fail()
    {
        $this->forget_render(FAIL);
    }
    
    public function askPassword()
    {
        $this->model->askPassword();
    }
    
    private function forget_render($page_setting = INIT)
    {
        $this->view->page_setting = $page_setting;
        $this->view->render('forget/index');
    }
}