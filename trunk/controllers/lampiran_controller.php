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
    
    public function rekam($id,$tipe){
        if($tipe=='SM'){
            $data = $this->model->select('SELECT id_suratmasuk, no_surat, asal_surat, perihal
                    FROM suratmasuk WHERE id_suratmasuk='.$id);
        foreach ($data as $value){
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_surat'];
            $this->view->data[2] = $value['asal_surat'];
            $this->view->data[3] = $value['perihal'];
            $this->view->data[4] = 'SM';
        }
        }elseif ($tipe=='SK') {
            $data = $this->model->select('SELECT id_suratkeluar,no_surat, tujuan, perihal
                    FROM suratkeluar WHERE id_suratkeluar='.$id);
            foreach ($data as $value){
            $this->view->data[0] = $value['id_suratkeluar'];
            $this->view->data[1] = $value['no_surat'];
            $this->view->data[2] = $value['tujuan'];
            $this->view->data[3] = $value['perihal'];
            $this->view->data[4] = 'SK';
        }
        }
        //var_dump($this->view->data);
        $this->view->tipe = $this->model->getTypeLampiran();
        $this->view->render('lampiran/lampiran');
    }
    
    /*
     * mgkn tipe surat=>surat masuk, surat keluar dibutuhkan
     * sebagai pembeda
     */
    public function addRekamLampiran(){
        
        $upload = new Upload('upload');
        $upload->setDirTo('arsip/');
        $jns = $_POST['jenis'];
        $tipe = $_POST['tipe'];
        $nomor = $_POST['nomor'];
        $asal = $_POST['asal'];
        //nama baru akan terdiri dari tipe naskah_nomor surat_asal(asal/tetapi asal terlaku kepanjangan)
        $ubahNama = array($tipe,$nomor);
        $upload->setUbahNama($ubahNama);
        $upload->changeFileName($upload->getFileName(), $ubahNama);
        $namafile = $upload->getFileTo();
        //$upload->init('upload');
        $data = array(
            'jns_surat'=>$jns,
            'id_surat'=>$_POST['id'],
            'tipe'=>$tipe,
            'nomor'=>$nomor,
            'tanggal'=>  Tanggal::ubahFormatTanggal($_POST['tanggal']),
            'hal'=>$_POST['hal'],
            'asal'=>$asal,
            'keterangan'=>$_POST['keterangan'],
            'file'=>$namafile//upload belom diurus
        );
        
        $upload->uploadFile();
        //var_dump($data);
        $this->model->addLampiran($data);
        if($jns=='SM'){
            header('location:'.URL.'suratmasuk/detil/'.$data['id_surat']);
        }elseif ($jns=='SK') {
            header('location:'.URL.'suratkeluar/detil/'.$data['id_surat']);
        }
        
    }   
    
    
}
?>
