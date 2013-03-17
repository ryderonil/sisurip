<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Lampiran_Controller extends Controller{
    
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
    
    public function rekam($id){
        $data = $this->model->select('SELECT id_suratmasuk, no_surat, asal_surat, perihal
                    FROM suratmasuk WHERE id_suratmasuk='.$id);
        foreach ($data as $value){
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_surat'];
            $this->view->data[2] = $value['asal_surat'];
            $this->view->data[3] = $value['perihal'];
        }
        $this->view->tipe = $this->model->getTypeLampiran();
        $this->view->render('lampiran/lampiran');
    }
    
    public function addRekamLampiran(){
        $data = array(
            'id_surat'=>$_POST['id'],
            'tipe'=>$_POST['tipe'],
            'nomor'=>$_POST['nomor'],
            'tanggal'=>  Tanggal::ubahFormatTanggal($_POST['tanggal']),
            'hal'=>$_POST['hal'],
            'asal'=>$_POST['asal'],
            'keterangan'=>$_POST['keterangan'] //upload belom diurus
        );
        
        $this->model->addLampiran($data);
        header('location:'.URL.'suratmasuk/'.$data['id_surat']);
    }
    
}
?>
