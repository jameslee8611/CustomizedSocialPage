<?php
class Signup_Model extends Model {

    function __construct() 
    {
        parent::__construct();
    }

    public function signup()
    {
        echo $_POST['email'] .'<br />';
        echo 'Test';
    }
}