<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Profile extends Controller {
    
    var $username;

    function __construct() {
        parent::__construct();
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
                    $this->view->render('profile/profile');
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
    
    public function post($from = null)
    {
        if (Session::get('loggedIn'))
        {
            $this->model->post($from);
        }
        else
        {
            $this->redirect_error();
        }
    }
}