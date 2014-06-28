<?php 
/**
 * @author Seungchul Lee
 * @Date   June 27, 2014
 */
    if (Session::get('loggedIn') == true)
    {
        include_once 'main.php';
    }
    else
    {
        include_once 'signup.php'; 
    }
?>