<?php
/**
 * @author  Seungchul
 * @date    July 2, 2014
 */

class Setting extends Controller {

    function __construct() {
        parent::__construct();
        
        if(Session::get('loggedIn') == null)
        {
            $this->view->render('error/index');
            exit;
        }
    }

    public function index()
    {
        $this->view->render('setting/index');
    }
    
    public function changePassword()
    {
        $this->view->render('setting/changePassword');
    }
    
    public function askChange()
    {
        if ($this->model->changePassword() == false)
        {
            $this->view->error_msg_trigger = true;
            $this->view->render('setting/changePassword');
            exit;
        }
        else
        {
            $this->view->render('setting/success/changePasswordSuccess');
            exit;
        }
    }
    
    public function withdraw()
    {
        $this->view->render('setting/withdraw');
    }
    
    public function askWithdraw()
    {
        $this->model->withdraw();
        $this->view->render('setting/success/withdrawdSuccess');
    }
}