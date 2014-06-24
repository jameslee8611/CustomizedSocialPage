<?php
class Signup extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    public function signup()
    {
        $this->model->signup();
    }
}
