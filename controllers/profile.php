<?php

/**
 * @author  Seungchul Lee
 * @date    July 16, 2014
 */

class Profile extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($username=null, $action=null)
    {   
        Data::setUsername($username);
        
        if (!$this->model->check_user($username))
        {
            $this->redirect_error();
        }
        elseif (Session::get('loggedIn') == true)
        {
            switch ($action)
            {
                case NULL:
                    $result = $this->model->get_status($username);
                    $this->view->username = $username;
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
    
    /**
     * Ajax-call
     * @param type $username
     * @param type $from
     * @param string $type
     */
    public function post_ajax($username, $from=null, $type=null)
    {
        ////// set the type //////
        $type = STATUS; // now we only have status type
        
        $result = $this->model->post($username, $from, $type);
        print_r($result);
    }
}