<?php 
    if (Session::get('loggedIn') == true)
    {
        include_once 'main.php';
    }
    else
    {
        include_once 'signup.php'; 
    }
?>