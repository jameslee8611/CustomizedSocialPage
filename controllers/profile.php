<?php

/**
 * @author  Seungchul Lee
 * @date    July 16, 2014
 */

class Profile extends Controller {
    
    var $username;

    function __construct() {
        parent::__construct();
        
        if (!Session::get('loggedIn'))
        {
            $this->redirect_error();
        }
    }

    public function index($username=null, $action=null)
    {   
        $this->username = $username;
        
        if (!$this->model->check_user($username))
        {
            $this->redirect_error();
        }
        elseif (Session::get('loggedIn') == true)
        {
            switch ($action)
            {
                case NULL:
                    $result = $this->model->get_status();
                    $this->view->data = $result;
                    $this->view->render('profile/profile');
                    break;
                    
                case STATUS:
                    $this->view->render('profile/status');
                    break;
                
                case IMAGE:
                    $this->view->render('profile/image');
                    break;
                
                case VIDEO:
                    $this->view->render('profile/video');
                    break;

                default:
                    $this->redirect_error();
                    break;
            }
            
            exit;
        }
        else
        {
            if ($action != null)
            {
                $this->redirect_error();
            }
            else
            {
                $this->view->render('profile/profile_public');
            }
        }
    }
    
    public function post($from=null, $type=null)
    {
        ////// set the type //////
        $type = STATUS; // now we only have status type
        
        $this->model->post($from, $type);
        
    }
}