<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    //put your code here
    
    public function index(){
        //$this->view->render('suratmasuk/index');
        //header('location:'.URL.'suratmasuk/showall');
        $this->showAll();
    }
    
    public function rekamKantor(){
        $this->view->render('admin/kantor/index');
    }
    
    public function rekamAlamat(){
        $this->view->render('admin/alamat/index');
    }
    
    public function rekamJenisLampiran(){
        $this->view->render('admin/lampiran/index');
    }
    
    public function rekamKlasifikasiArsip(){
        $this->view->render('admin/klasArsip/index');
    }
    
    public function rekamLokasi(){
        $this->view->render('admin/lokasi/index');
    }
    
    public function rekamNomor(){
        $this->view->render('admin/nomor/index');
    }
    
    public function rekamStatusSurat(){
        $this->view->render('admin/status/index');
    }
    
}
?>
