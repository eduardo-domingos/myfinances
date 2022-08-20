<?php

namespace App\Controllers;

use \App\Libraries\Controller;

class Pages extends Controller
{
 
    /**
     * Carrega View Home
     * @return void
     */
    public function index(): void
    {
        $this->view('pages/home');
    }
    
    /**
     * Carrega a View Sobre
     * @return void
     */
    public function about(): void
    {
        $this->view('pages/about');
    }
    
}
