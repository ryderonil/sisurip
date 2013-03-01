<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of suratMasuk
 *
 * @author aisyah
 */
class Suratmasuk_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    //put your code here
    
    public function index(){
        $this->view->render('suratmasuk/index');
    }
    
    public function showAll(){
        
        $this->view->listSurat = $this->model->showAll();
        
        $this->view->render('suratmasuk/suratmasuk');
    }
    
    public function edit(){
        $this->model->edit();
    }
    
    public function remove(){
        $this->model->remove();
    }
    
    public function input(){
        $this->model->input();
    }
}

?>
