<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Home_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama();
    }
    
    public function index(){
        $this->view->render('home');
    }
}
?>
