<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Bantuan_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->view->kantor = Kantor::getNama(); 
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    //put your code here
    
    public function index(){
        $this->view->render('bantuan/index');
    }
    
    public function show(){
        
        $this->model->show();
    }
}
?>
