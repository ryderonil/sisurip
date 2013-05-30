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
        
        if(!Auth::isAllow(3, Session::get('role'))){
            header('location:'.URL.'home');
        }
        
        if(isset($_POST['submit'])){
            if($this->addRekamLampiran()){
                $this->view->success="Rekam lampiran berhasil";
            }else{
                $this->view->error = "Rekam lampiran surat gagal!";
            }
                
        }
            
        if($tipe=='SM'){
            $sm = new Suratmasuk_Model();
            $data = $sm->getSuratById($id);
//            $data = $this->model->select('SELECT id_suratmasuk, no_surat, asal_surat, perihal
//                    FROM suratmasuk WHERE id_suratmasuk='.$id);
//        foreach ($data as $value){
            $this->view->data[0] = $sm->getId();
            $this->view->data[1] = $sm->getNomor();
            $this->view->data[2] = $sm->getAlamat();
            $this->view->data[3] = $sm->getPerihal();
            $this->view->data[4] = 'SM';
//        }
        }elseif ($tipe=='SK') {
            $sk = new Suratkeluar_Model();
            $data = $sk->getSuratById($id, 'ubah');
//            $data = $this->model->select('SELECT id_suratkeluar,no_surat, tujuan, perihal
//                    FROM suratkeluar WHERE id_suratkeluar='.$id);
//            foreach ($data as $value){
            $this->view->data[0] = $data->getId();
            $this->view->data[1] = $data->getNomor();
            $this->view->data[2] = $data->getAlamat();
            $this->view->data[3] = $data->getPerihal();
            $this->view->data[4] = 'SK';
//        }
        }
//        var_dump($this->view->data);
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
        /*if($jns=='SM'){
            header('location:'.URL.'suratmasuk/detil/'.$data['id_surat']);
        }elseif ($jns=='SK') {
            header('location:'.URL.'suratkeluar/detil/'.$data['id_surat']);
        }*/
        return true;
        
    }
    
    public function ubah($id){
        if(!Auth::isAllow(3, Session::get('role'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->ubahLampiran()){
                $this->view->success="Ubah lampiran berhasil";
            }else{
                $this->view->error = "Ubah lampiran surat gagal!";
            }
                
        }
        
        $lamp = new Lampiran_Model();
        $data = $this->model->getLampiran($id);
        foreach($data as $val){
            $lamp->set('id_lamp',$val['id_lamp']);
            $lamp->set('jns_surat', $val['jns_surat']);
            $lamp->set('id_surat', $val['id_surat']);
            $lamp->set('tipe', $val['tipe']);
            $lamp->set('nomor', $val['nomor']);
            $lamp->set('tanggal', $val['tanggal']);
            $lamp->set('asal', $val['asal']);
            $lamp->set('hal', $val['hal']);
            $lamp->set('keterangan', $val['keterangan']);
            $lamp->set('file', $val['file']);
            
        }
        
        if($lamp->get('jns_surat')=='SM'){
            $sm = new Suratmasuk_Model();
            $datas = $sm->getSuratById($lamp->get('id_surat'));
//            foreach ($datas as $value){
                $this->view->data[0] = $datas->getId();
                $this->view->data[1] = $datas->getNomor();
                $this->view->data[2] = $datas->getAlamat();
                $this->view->data[3] = $datas->getPerihal();
                $this->view->data[4] = 'SK';
//            }
        }else{
            $sk = new Suratkeluar_Model();
            $datas = $sk->getSuratById($lamp->get('id_surat'), 'ubah');
//            foreach ($data as $value){
                $this->view->data[0] = $datas->getId();
                $this->view->data[1] = $datas->getNomor();
                $this->view->data[2] = $datas->getAlamat();
                $this->view->data[3] = $datas->getPerihal();
                $this->view->data[4] = 'SK';
//            }
        }
        
//        $datas = $this->model->select($sql);
        //var_dump($this->view->data);
        $this->view->lamp = $lamp;
        $this->view->tipe = $this->model->getTypeLampiran();
        $this->view->render('lampiran/ubah');
    }
    
    public function ubahLampiran(){        
        $id_lamp = $_POST['id'];
        $id_surat = $_POST['id_surat'];
        $tgl = $_POST['tanggal'];
        $jns = $_POST['jenis'];
        $tipe = $_POST['tipe'];
        $nomor = $_POST['nomor'];
        $asal = $_POST['asal'];
        $hal = $_POST['hal'];
        $ket = $_POST['keterangan'];
        //nama baru akan terdiri dari tipe naskah_nomor surat_asal(asal/tetapi asal terlaku kepanjangan)
        if($_FILES['upload']['name']!=''){
            $upload = new Upload('upload');
            $upload->setDirTo('arsip/');
            $ubahNama = array($tipe,$nomor);
            $upload->setUbahNama($ubahNama);
            $upload->changeFileName($upload->getFileName(), $ubahNama);
            $namafile = $upload->getFileTo();
        }else{
            $filex = $_POST['file'];
            $file = explode("_", $filex);
            $j = count($file);
            $ext = explode('.',$file[$j-1]);
            var_dump($ext);
            var_dump($file);
//            $namafile = explode("_", $file);
//            var_dump($namafile);
            $file[0] = $tipe;
            $namafile = '';
            for($i=0;$i<$j-1;$i++){
                $namafile .= '_'.$file[$i];
                echo $file[$i].'</br>';
            }
            $namafile = trim($namafile, "_").'_'.$ext[0].'.'.$ext[1];
            var_dump($namafile);
//            $namafile = implode("_", $namafile);
            rename('arsip/'.$filex, 'arsip/'.$namafile);
        }
        
        //$upload->init('upload');
        $lamp = new Lampiran_Model();
        $lamp->set('id_lamp',$id_lamp);
        $lamp->set('jns_surat', $jns);
        $lamp->set('id_surat', $id_surat);
        $lamp->set('tipe', $tipe);
        $lamp->set('nomor', $nomor);
        $lamp->set('tanggal', $tgl);
        $lamp->set('asal', $asal);
        $lamp->set('hal', $hal);
        $lamp->set('keterangan', $ket);
        $lamp->set('file', $namafile);
        
        /*$data = array(
            'jns_surat'=>$jns,
            'id_surat'=>$_POST['id'],
            'tipe'=>$tipe,
            'nomor'=>$nomor,
            'tanggal'=>  Tanggal::ubahFormatTanggal($_POST['tanggal']),
            'hal'=>$_POST['hal'],
            'asal'=>$asal,
            'keterangan'=>$_POST['keterangan'],
            'file'=>$namafile//upload belom diurus
        );*/
        if($_FILES['upload']['name']!=''){
            $upload->uploadFile();
        }        
        //var_dump($data);
        $lamp->editLampiran();
        /*if($jns=='SM'){
            header('location:'.URL.'suratmasuk/detil/'.$data['id_surat']);
        }elseif ($jns=='SK') {
            header('location:'.URL.'suratkeluar/detil/'.$data['id_surat']);
        }*/
        return true;
        
    }
    
    public function hapus($id){
        $sql = "SELECT file FROM lampiran WHERE id_lamp=".$id;
        $data = $this->model->select($sql);
        $file='';
        foreach ($data as $val){
            $file = $val['file'];
        }
        $this->model->set('id_lamp', $id);
        $hapus = $this->model->deleteLampiran();
        if($hapus){
            unlink('arsip/'.$file);
            echo "Data lampiran berhasil dihapus";
        }else{
            echo "Data lampiran gagal dihapus!";
        }
    }


    public function view($id){
        $data = $this->model->getLampiran($id);
        foreach($data as $val){
            $this->view->file = $val['file'];
        }
        $this->view->load('lampiran/viewlampiran');
    }
    
    
}
?>
