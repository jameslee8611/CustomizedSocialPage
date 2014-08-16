<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Developer extends Controller
{

    function __construct() 
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->render('about/developer');
    }
}