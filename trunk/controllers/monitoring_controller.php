<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Monitoring_Controller extends Controller {

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama();
        $this->view->js = array(
            'suratmasuk/js/default'
        );
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    
    public function index(){
        $this->view->render('monitoring/report');
    }
    
    public function kinerja(){
        $this->view->render('monitoring/report');
    }
    
    public function ikhtisar(){
        $this->view->render('monitoring/ikhtisar');
    }

    public function kinerjaSuratMasuk(){
        $kinerja = new KinerjaPegawai();
        
    }
    
    public function kinerjaSuratKeluar(){
        
    }
}
?>
