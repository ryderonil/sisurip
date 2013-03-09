<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Login_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        $this->view->kantor = Kantor::getNama(); 
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    //put your code here
    
    public function index(){
        $this->view->render('login/index');
    }
    
    public function auth(){
        $this->model->auth();
    }
    
    public function logout(){
        //$this->model->logout();
        //Session::unsetAll();
        Session::createSession();
        Session::destroySession();
        //session_destroy();
        header('location:../login');
        exit();
    }
    
}
?>
