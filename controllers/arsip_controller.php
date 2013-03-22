<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Arsip_Controller extends Controller{
    
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
    
    public function rekam($id,$tipesurat=null){
        $data = $this->model->select('SELECT id_suratmasuk, no_surat, asal_surat, perihal
                    FROM suratmasuk WHERE id_suratmasuk='.$id);
        foreach ($data as $value){
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_surat'];
            $this->view->data[2] = $value['asal_surat'];
            $this->view->data[3] = $value['perihal'];
        }
        
        if(!is_null($tipesurat)){
            $this->view->tipe=$tipesurat;
        }
        
        $this->view->rak = $this->model->getRak();
        $this->view->baris = $this->model->getBaris();
        $this->view->box = $this->model->getBox();
        $this->view->render('arsip/rekam');
    }
    
    public function rekamArsip(){
        
        $id_lokasi = $_POST['box'];
        $id_surat = $_POST['id'];
        $tipe_surat = $_POST['tipe'];
        
        $data = array(
            'id_lokasi'=>$id_lokasi,
            'id_surat'=>$id_surat,
            'tipe_surat'=>$tipe_surat
        );
        
        $this->model->rekamArsip($data);
        header('location:'.URL.'suratmasuk/detil/'.$id_surat);
        
    }
}
?>
