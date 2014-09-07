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
        $this->view->username = $username;
        $this->view->profile_pic = $this->model->get_profile_url($username);
        
        if (!$this->model->check_user($username))
        {
            $this->redirect_error();
        }
        elseif (Session::get('loggedIn') == true)
        {
            switch ($action)
            {
                case NULL:
                    $result = $this->model->get_wall($username);
                    $this->view->data = $result;
                    $this->view->render('profile/profile');
                    break;
                    
                case STATUS:
                    $result = $this->model->get_status($username);
                    $this->view->data = $result;
                    $this->view->render('profile/status');
                    break;
                
                case IMAGE:
                    $result = $this->model->get_image($username);
                    $this->view->data = $result;
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
    public function post_ajax($username=null, $type=null)
    {   
        if (!isset($username) || empty($username) || !isset($type) || empty($type))
        {
            echo "Invalid access!";
            exit;
        }
        
        $result = $this->model->post_ajax($username, $type);
        print_r($result);
    }
    
    public function delete_ajax($username, $wall_Id, $type)
    {
        if(Session::get('loggedIn') && $username == Session::get('username'))
        {
            echo $this->model->delete_ajax($wall_Id, $type);
        }
        else
        {
            $this->redirect_error();
        }
    }

    public function picture_ajax($username)
    {
        if(Session::get('loggedIn') && $username == Session::get('username'))
        {
            echo $this->model->profile_image($username);
        }
        else
        {
            $this->redirect_error();
        }
    }
    
    public function upload_image_ajax($username)
    {
        if(Session::get('loggedIn') && $username == Session::get('username'))
        {
            echo $this->model->upload_image($username);
        }
        else
        {
            $this->redirect_error();
        }
    }

    public function get_status_ajax()
    {
        if(Session::get('loggedIn'))
        {
            //echo $this->model->get_status_ajax($type);
            print_r($this->model->get_status_ajax());
        }
        else
        {
            $this->redirect_error();
        }
    }
    
    public function get_image_ajax()
    {
        if(Session::get('loggedIn'))
        {
            //echo $this->model->get_status_ajax($type);
            print_r($this->model->get_image_ajax());
        }
        else
        {
            $this->redirect_error();
        }
    }
    
    public function loadmore($lastId, $username = null)
    {
        $result = $this->model->get_wall($username, $lastId);
        echo json_encode($result, true);
    }
    
    public function loadmore_status($lastId, $username = null)
    {
        $result = $this->model->get_status($username, $lastId);
        echo json_encode($result, true);
    }
}