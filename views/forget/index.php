<?php
    switch ($this->page_setting)
    {
        case INIT:
            include_once 'main.php';
            break;
            
        case SUCCESS:
            include_once 'success.php';
            break;
        
        case FAIL:
            include_once 'fail.php';
            break;
        
        case ERROR:
            include_once 'error.php';
            break;
    }
?>

