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
        $arsip = new Arsip_Model();
        $this->view->arsip = @$arsip->getJmlArsipBagian();
//        var_dump($arsip);
        $this->view->render('home');
    }
    
    public function metro(){
        $this->view->load('metro');
    }
    
    function __destruct() {
        ;
    }
}
?>
