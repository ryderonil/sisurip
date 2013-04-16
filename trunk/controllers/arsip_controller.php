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
        if(isset($_POST['submit'])){
            if($this->rekamArsip()){
                $this->view->success="Rekam arsip berhasil";
            }else{
                $this->view->error = "Rekam arsip gagal!";
            }
        }
             
        if(!is_null($tipesurat)){
            $this->view->tipe=$tipesurat;
            
            if($tipesurat=='SM'){
                $data = $this->model->getSurat($id,'SM');
//                $data = $this->model->select('SELECT id_suratmasuk, no_surat, asal_surat, perihal
//                    FROM suratmasuk WHERE id_suratmasuk='.$id);
                foreach ($data as $value){
                    $this->view->data[0] = $value['id_suratmasuk'];
                    $this->view->data[1] = $value['no_surat'];
                    $this->view->data[2] = $value['asal_surat'];
                    $this->view->data[3] = $value['perihal'];
                }
            }elseif (($tipesurat=='SK')) {
                $data = $this->model->getSurat($id,'SK');
//                $data=$this->model->select('SELECT id_suratkeluar,no_surat,tujuan, perihal
//                    FROM suratkeluar WHERE id_suratkeluar='.$id);
                foreach ($data as $value){
                    $this->view->data[0] = $value['id_suratkeluar'];
                    $this->view->data[1] = $value['no_surat'];
                    $this->view->data[2] = $value['tujuan'];
                    $this->view->data[3] = $value['perihal'];
                }
            }
        }
        
        $dataa = $this->model->getArsip($id, $tipesurat);
//        var_dump($dataa);
        $this->view->cek = count($dataa);
        if($this->view->cek>0){
//            ini yang susah ternyata
            foreach ($dataa  as $val){
                $this->view->ar['rak'] = $val['rak'];
                $this->view->ar['baris'] = $val['baris'];
                $this->view->ar['box'] = $val['box'];
            }
            
            $this->view->rak = $this->model->getRak();
            $this->view->baris = $this->model->getBaris($this->view->ar['rak']);
            $this->view->box = $this->model->getBox($this->view->ar['baris']);
            
        }else{
//            if($this->view->data[1]==''){
            if($this->model->emptyNomor($this->view->data[1])){
                $this->view->warning = 'surat belum mendapat nomor surat, tidak dapat diarsipkan';
            }

            $this->view->rak = $this->model->getRak();
            $this->view->baris = $this->model->getBaris();
            $this->view->box = $this->model->getBox();
        }
        
        
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
        
        if($this->model->rekamArsip($data)){
            $this->view->success = "Data arsip telah berhasil disimpan";
        
            if($tipe_surat=='SM'){
                $time = date('Y-m-d H:i:s');
                $datastat = array('stat'=>'15', 'end'=>$time);
                $where = 'id_suratmasuk='.$id_surat;
                $this->model->update('suratmasuk',$datastat,$where); //update status -> arsip
//                header('location:'.URL.'suratmasuk/detil/'.$id_surat);
            }elseif($tipe_surat=='SK'){
                $time = date('Y-m-d H:i:s');
                $datastat = array('status'=>'23', 'end'=>$time);
                $where = 'id_suratkeluar='.$id_surat;
                $this->model->update('suratkeluar',$datastat,$where); //update status -> arsip
//                header('location:'.URL.'suratkeluar/detil/'.$id_surat);
            }
        }
        
        return true;
        
//        pesan berhasilnya mana
//        $this->view->rak = $this->model->getRak();
//        $this->view->baris = $this->model->getBaris();
//        $this->view->box = $this->model->getBox();
//        $this->view->render('arsip/rekam');
        
        
    }
}
?>
