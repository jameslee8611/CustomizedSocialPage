<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Profile extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index($username=null, $action=null)
    {
        if (!$this->model->check_user($username))
        {
            $this->redirect_error();
        }
        
        if (Session::get('loggedIn') == true)
        {
            switch ($action)
            {
                case SETTING:
                    $this->view->render('profile/setting');
                    break;

                default:
                    list($post, $comment) = $this->model->get_post();
                    $this->view->post = $post;
                    $this->view->comment = $comment;
                    $this->view->render('profile/profile');
                    break;
            }
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
    
    private function redirect_error()
    {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        return false;
    }
}