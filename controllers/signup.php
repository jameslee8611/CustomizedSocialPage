<?php
/**
 * @author Seungchul Lee
 */

class Signup extends Controller {

    function __construct() 
    {
        parent::__construct();
    }
    
    public function index()
    {
        $this->model->signup();
    }
}
