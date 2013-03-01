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
    
    public function edit($id){
        $this->view->data = $this->model->edit($id);
        $this->view->render('suratmasuk/ubah');
    }
    
    public function remove($id){
        $this->model->remove($id);
        
    }
    
    public function editSurat(){
        $this->model->editSurat();
    }
    
    public function input(){
        $this->model->input();
    }
    
    public function rekam(){
        $this->view->render('suratmasuk/rekam');
    }
    
    public function getSuratMasukById($id){
        $this->view->dataSurat = $this->model->getSuratMasukById($id);
        $this->view->render(suratmasuk/detilsurat);
    }
}

?>
