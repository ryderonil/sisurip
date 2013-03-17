<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suratkeluar_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->view->kantor = Kantor::getNama();
        $this->view->js = array(
          'suratkeluar/js/default'  
        );
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    //put your code here
    
    public function index(){
        $this->view->render('suratkeluar/index');
    }
    
    public function rekam($id_sm=null){
        if(!is_null($id_sm)){
            $datasm = $this->model->select('SELECT id_suratmasuk, no_agenda, no_surat FROM suratmasuk WHERE id_suratmasuk='.$id_sm);
            foreach ($datasm as $value){
                $this->view->data[0] = $value['id_suratmasuk'];
                $this->view->data[1] = $value['no_agenda'];
                $this->view->data[2] = $value['no_surat'];
            }           
        }
        $this->view->sifat = $this->model->select('SELECT * FROM sifat_surat');
        $this->view->klas = $this->model->select('SELECT * FROM klasifikasi_surat');
        $this->view->tipe = $this->model->select('SELECT * FROM tipe_naskah');
        
        $this->view->datas[0] = '--PILIH SIFAT SURAT--';
        $this->view->datak[0] = '--PILIH KLASIFIKASI SURAT--'; 
        
        //var_dump($this->view->data);
        
        $this->view->render('suratkeluar/rekam');
    }
    
    
    
    
}
?>
