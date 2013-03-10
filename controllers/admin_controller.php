<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->view->kantor = Kantor::getNama(); 
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
               
        $this->view->cek = $this->model->cekKantor();
        //echo $this->view->cek;
        if($this->view->cek > 0) {
            $data = $this->model->selectTable('kantor');
            //var_dump($data);
            foreach($data as $value){
                $this->view->id = $value['id'];
                $this->view->ba = $value['ba'];
                $this->view->es1= $value['es1'];
                $this->view->es2= $value['es2'];
                $this->view->satker= $value['satker'];
                $this->view->singkatan= $value['singkatan'];
                $this->view->alamat= $value['alamat'];
                $this->view->telepon= $value['telepon'];
                $this->view->email= $value['email'];
                $this->view->logo= $value['logo'];
            }
        }
        $this->view->render('admin/kantor/index');
    }
    
    public function rekamAlamat(){
        $this->view->render('admin/alamat/index');
    }
    
    public function rekamJenisLampiran(){
        $this->view->lampiran = $this->model->select('SELECT * FROM lampiran');
        $this->view->count = count($this->view->lampiran);
        $this->view->render('admin/lampiran/index');
    }
    
    public function ubahLampiran($id){        
        $this->view->lampiran = $this->model->select('SELECT * FROM lampiran');
        $dataUbah = $this->model->select('SELECT * FROM lampiran WHERE id_lampiran='.$id);
        foreach($dataUbah as $value){
            $this->view->data[0] = $value['id_lampiran'];
            $this->view->data[1] = $value['tipe_naskah'];            
        }
        $this->view->render('admin/lampiran/ubahLampiran');
    }
    
    public function rekamKlasifikasiArsip(){        
        $this->view->klasArsip = $this->model->select('SELECT * FROM klasifikasi_arsip');
        $this->view->count = count($this->view->klasArsip); 
        $this->view->render('admin/klasArsip/index');
    }
    
    public function ubahKlasifikasiArsip($id){        
        $this->view->klasArsip = $this->model->select('SELECT * FROM klasifikasi_arsip');
        $dataUbah = $this->model->select('SELECT * FROM klasifikasi_arsip WHERE id_klasarsip='.$id);
        foreach($dataUbah as $value){
            $this->view->data[0] = $value['id_klasarsip'];
            $this->view->data[1] = $value['kode'];
            $this->view->data[2] = $value['klasifikasi'];
        }
        $this->view->render('admin/klasArsip/ubahKlasArsip');
    }
    
    public function rekamLokasi(){
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->rak = $this->model->select('SELECT * FROM lokasi WHERE tipe=1');
        $this->view->baris = $this->model->select('SELECT * FROM lokasi WHERE tipe=2');
        $this->view->lokasi = $this->model->viewLokasi();
        //$this->view->lokasi = $this->model->select('SELECT * FROM lokasi');
        $this->view->render('admin/lokasi/index');
    }
    
    public function ubahLokasi($id){        
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->rak = $this->model->select('SELECT * FROM lokasi WHERE tipe=1');
        $this->view->baris = $this->model->select('SELECT * FROM lokasi WHERE tipe=2');
        $this->view->lokasi = $this->model->viewLokasi();
        $dataUbah = $this->model->select('SELECT * FROM lokasi WHERE id_lokasi='.$id);
        foreach($dataUbah as $value){
            //jika rak maka langsung, jika baris maka dicari raknya dulu dari parent, jika box maka dua kali 
            //cari parent
            $this->view->data[0] = $value['id_lokasi'];
            $this->view->data[1] = $value['bagian'];
            $this->view->data[2] = $value['parent'];
            $this->view->data[3] = $value['lokasi'];
        }
        $this->view->render('admin/lokasi/ubahLokasi');
    }
    
    public function rekamNomor(){
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->nomor = $this->model->select('SELECT * FROM nomor');
        $this->view->count = count($this->view->nomor);        
        $this->view->render('admin/nomor/index');
    }
    
    public function ubahNomor($id){
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->nomor = $this->model->select('SELECT * FROM nomor');
        $dataUbah = $this->model->select('SELECT * FROM nomor WHERE id_nomor='.$id);
        foreach($dataUbah as $value){
            $this->view->data[0] = $value['id_nomor'];
            $this->view->data[1] = $value['bagian'];
            $this->view->data[2] = $value['kd_nomor'];
        }
        $this->view->render('admin/nomor/ubahNomor');
    }
    
    public function rekamStatusSurat(){        
        $this->view->status = $this->model->select('SELECT * FROM status');
        $this->view->count = count($this->view->status);
        $this->view->render('admin/status/index');
    }
    
    public function ubahStatusSurat($id){        
        $this->view->status = $this->model->select('SELECT * FROM status');
        $dataUbah = $this->model->select('SELECT * FROM status WHERE id_status='.$id);
        foreach($dataUbah as $value){
            $this->view->data[0] = $value['id_status'];
            $this->view->data[1] = $value['tipe_surat'];
            $this->view->data[2] = $value['status'];
        }
        $this->view->render('admin/status/ubahStatus');
    }
    
    public function rekamUser(){
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->user = $this->model->select('SELECT * FROM user');
        $this->view->jabatan = $this->model->select('SELECT * FROM jabatan');
        $this->view->role = $this->model->select('SELECT * FROM role');
        $this->view->count = count($this->view->user);
        $this->view->render('admin/user/index');
    }
    
    public function ubahUser($id){        
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->user = $this->model->select('SELECT * FROM user');
        $this->view->jabatan = $this->model->select('SELECT * FROM jabatan');
        $this->view->role = $this->model->select('SELECT * FROM role');
        $dataUbah = $this->model->select('SELECT * FROM user WHERE id_user='.$id);
        foreach($dataUbah as $value){
            $this->view->data[0] = $value['id_user'];
            $this->view->data[1] = $value['username'];
            $this->view->data[2] = $value['password'];
            $this->view->data[3] = $value['namaPegawai'];
            $this->view->data[4] = $value['NIP'];
            $this->view->data[5] = $value['jabatan'];
            $this->view->data[6] = $value['bagian'];
            $this->view->data[7] = $value['role'];
            $this->view->data[8] = $value['active'];
        }
        $this->view->render('admin/user/ubahUser');
    }
    
    public function inputRekamKantor(){
        $data = array(
            'ba'=>$_POST['ba'],
            'es1'=>$_POST['es1'],
            'es2'=>$_POST['es2'],
            'satker'=>$_POST['satker'],
            'singkatan'=>$_POST['singkatan'],
            'alamat'=>$_POST['alamat'],
            'telepon'=>$_POST['telepon'],
            'email'=>$_POST['email'],
            'logo'=>$_FILES['logo']
        );
        
        $this->model->insert('kantor', $data);
        $this->view->render('admin/kantor/index');
    }
    
    public function updateRekamKantor(){
        $data = array(
            'id'=>$_POST['id'],
            'ba'=>$_POST['ba'],
            'es1'=>$_POST['es1'],
            'es2'=>$_POST['es2'],
            'satker'=>$_POST['satker'],
            'singkatan'=>$_POST['singkatan'],
            'alamat'=>$_POST['alamat'],
            'telepon'=>$_POST['telepon'],
            'email'=>$_POST['email']//,
            //'logo'=>$_FILES['logo']
        );
        //$this->model->delete('kantor',' id='.$data['id']);
        $this->model->update('kantor',$data,' id='.$data['id']);
        $this->rekamKantor();
    }
    
    public function inputRekamNomor(){
        $data = array(
            'bagian'=>$_POST['bagian'],
            'kd_nomor'=>$_POST['nomor']
        );
        $this->model->addPenomoran($data);
        $this->rekamNomor();
    }
    
    public function updateRekamNomor(){
        $data = array(
            'bagian'=>$_POST['bagian'],
            'kd_nomor'=>$_POST['nomor']
        );
        
        $where = ' id_nomor='.$_POST['id'];
        $this->model->updatePenomoran($data,$where);
        $this->rekamNomor();
    }
    
    public function hapusNomor($id){
        $where = ' id_nomor='.$id;
        $this->model->deleteNomor($where);
        $this->rekamNomor();
    }
    
    public function inputRekamKlasArsip(){
        $data = array(
            'kode'=>$_POST['kode'],
            'klasifikasi'=>$_POST['klasifikasi']
        );
        $this->model->addKlasifikasiArsip($data);
        $this->rekamKlasifikasiArsip();
    }
    
    public function updateRekamKlasArsip(){
        $data = array(
            'kode'=>$_POST['kode'],
            'klasifikasi'=>$_POST['klasifikasi']
        );
        
        $where = ' id_klasarsip='.$_POST['id'];
        $this->model->updateKlasifikasiArsip($data,$where);
        $this->rekamKlasifikasiArsip();
    }
    
    public function hapusKlasifikasiArsip($id){
        $where = ' id_klasarsip='.$id;
        $this->model->deleteKlasifikasiArsip($where);
        $this->rekamKlasifikasiArsip();
    }
    
    public function inputRekamLampiran(){
        $data = array(         
            'tipe_naskah'=>$_POST['tipe_naskah']
        );
        $this->model->addLampiran($data);
        $this->rekamJenisLampiran();
    }
    
    public function updateRekamLampiran(){
        $data = array(            
            'tipe_naskah'=>$_POST['tipe_naskah']
        );
        
        $where = ' id_lampiran='.$_POST['id'];
        $this->model->updateLampiran($data,$where);
        $this->rekamJenisLampiran();
    }
    
    public function hapusLampiran($id){
        $where = ' id_lampiran='.$id;
        $this->model->deleteLampiran($where);
        $this->rekamJenisLampiran();
    }
    
    public function inputRekamStatus(){
        $data = array(
            'tipe_surat'=>$_POST['tipe_surat'],
            'status'=>$_POST['status']
        );
        $this->model->addStatusSurat($data);
        $this->rekamStatusSurat();
    }
    
    public function updateRekamStatus(){
        $data = array(            
            'tipe_surat'=>$_POST['tipe_surat'],
            'status'=>$_POST['status']
        );
        
        $where = ' id_status='.$_POST['id'];
        $this->model->updateStatusSurat($data,$where);
        $this->rekamStatusSurat();
    }
    
    public function hapusStatus($id){
        $where = ' id_status='.$id;
        $this->model->deleteStatusSurat($where);
        $this->rekamStatusSurat();
    }
    
    public function inputRekamUser(){
        $data = array(
            'namaPegawai'=>$_POST['namaPegawai'],
            'NIP'=>$_POST['NIP'],
            'username'=>$_POST['username'],
            'password'=>$_POST['password'],
            'bagian'=>$_POST['bagian'],
            'jabatan'=>$_POST['jabatan'],
            'role'=>$_POST['role'],
            'active'=>'Y'
        );
        $this->model->addUser($data);
        $this->rekamUser();
    }
    
    public function updateRekamUser(){
        $data = array(
            'namaPegawai'=>$_POST['namaPegawai'],
            'NIP'=>$_POST['NIP'],
            'username'=>$_POST['username'],
            'password'=>$_POST['password'],
            'bagian'=>$_POST['bagian'],
            'jabatan'=>$_POST['jabatan'],
            'role'=>$_POST['role'],
            'active'=>'Y'
        );
        
        $where = ' id_user='.$_POST['id'];
        $this->model->updateUser($data,$where);
        $this->rekamUser();
    }
    
    public function hapusUser($id){
        $where = ' id_user='.$id;
        $this->model->deleteUser($where);
        $this->rekamUser();
    }
    
    public function setAktifUser($id,$active){
        
        $aktif = ($active=='Y')? 'N':'Y';
        //echo $aktif;
        $this->model->setAktifUser($id,$aktif);
        $this->rekamUser();
    }
    
    public function inputRekamLokasi(){
        $rak = (int)$_POST['rak'];
        $baris = (int)$_POST['baris'];
        $parent=null;
        if($rak==0 && $baris==0){
            $tipe = 1;
        }elseif($rak!=0 && $baris==0){
            $tipe=2;
            $parent=$rak;
        }elseif($rak!=0 && $baris!=0){
            $tipe=3;
            $parent=$baris;
        }
        $data = array(
            'parent'=>$parent,
            'bagian'=>$_POST['bagian'],
            'lokasi'=>$_POST['nama'],
            'tipe'=>$tipe,
            'status'=>'E'
        );
        $this->model->addLokasi($data);
        $this->rekamLokasi();
    }
    
}
?>
