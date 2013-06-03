<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_Controller extends Controller {

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->view->kantor = Kantor::getNama();
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
        $this->view->js = array(
            'admin/js/default',
            'suratkeluar/js/jquery.tipTip',
            'suratkeluar/js/jquery.tipTip.minified'
        );
    }

    //put your code here

    public function index() {
        //$this->view->render('suratmasuk/index');
        header('location:' . URL . 'suratmasuk');
        //$this->showAll();
    }

    public function rekamKantor() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['input_submit'])){
            if($this->inputRekamKantor()){
                $this->view->success = "Rekam data berhasil";
            }else{
                $this->view->error = "Rekam data gagal!";
            }
        }elseif (isset($_POST['update_submit'])){
            if($this->updateRekamKantor()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }

        $this->view->cek = $this->model->cekKantor();
        //echo $this->view->cek;
        if ($this->view->cek > 0) {
            $data = $this->model->selectTable('kantor');
            //var_dump($data);
            foreach ($data as $value) {
                $this->view->id = $value['id'];
                //$this->view->ba = $value['ba'];
                //$this->view->es1= $value['es1'];
                $this->view->es2 = $value['es2'];
                $this->view->satker = $value['satker'];
                $this->view->singkatan = $value['singkatan'];
                $this->view->alamat = $value['alamat'];
                $this->view->telepon = $value['telepon'];
                $this->view->email = $value['email'];
                $this->view->faksimile = $value['faksimile'];
                $this->view->website = $value['website'];
                $this->view->sms = $value['sms'];
                $this->view->logo = $value['logo'];
            }
        }
        $this->view->kanwil = $this->model->select("SELECT * FROM t_kanwil");
        if ($this->view->cek > 0) {
            $this->view->kppn = $this->model->select("SELECT * FROM t_kppn WHERE kdkanwil=" . $this->view->es2);
        } else {
            $this->view->kppn = $this->model->select("SELECT * FROM t_kppn");
        }

        $this->view->render('admin/kantor/index');
    }

    public function rekamAlamat($satker = null) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(3, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        if(isset($_POST['submit'])){
            if($this->inputRekamAlamat()){
                $this->view->success = "Rekam alamat berhasil";
            }else{
                $this->view->error = "Rekam alamat gagal! alamat satker ini telah ada.";
            }
        }
        if (!is_null($satker)) {
            $this->view->satker = $satker;
            $nm = $this->model->select('SELECT nmsatker FROM t_satker WHERE kdsatker=' . $satker);
            foreach ($nm as $value){
                $this->view->nm_satker = $value['nmsatker'];
            }
        }
        $this->view->data = $this->model->getAlamat();
        $this->view->render('admin/alamat/index');
    }
    
    public function ubahAlamat($kd, $satker = null){
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->updateRekamAlamat()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah alamat gagal! alamat satker ini telah ada.";
            }
        }
        $alamat = $this->model->getAlamat($kd);
        foreach($alamat as $value){
            $this->view->id = $value['id_alamat'];
            $this->view->kode_satker = $value['kode_satker'];
            $this->view->nama_satker = $value['nama_satker'];
            $this->view->jabatan = $value['jabatan'];
            $this->view->alamat = $value['alamat'];
            $this->view->telepon = $value['telepon'];
            $this->view->email = $value['email'];
        }
        //var_dump($this->view->id);
        if (!is_null($satker)) {
            $this->view->satker = $satker;
            $nm = $this->model->select('SELECT nmsatker FROM t_satker WHERE kdsatker=' . $satker);
            foreach ($nm as $value){
                $this->view->nm_satker = $value['nmsatker'];
            }
        }
        $this->view->data = $this->model->getAlamat();
        $this->view->render('admin/alamat/ubahAlamat');
    }

    public function rekamJenisLampiran() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->inputRekamLampiran()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->lampiran = $this->model->select('SELECT * FROM tipe_naskah');
        $this->view->count = count($this->view->lampiran);
        $this->view->render('admin/lampiran/index');
    }

    public function ubahLampiran($id) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->updateRekamLampiran()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->lampiran = $this->model->select('SELECT * FROM tipe_naskah');
        $dataUbah = $this->model->getDataAdminById($id,'lampiran');
        foreach ($dataUbah as $value) {
            $this->view->data[0] = $value['id_tipe'];
            $this->view->data[1] = $value['tipe_naskah'];
            $this->view->data[2] = $value['kode_naskah'];
        }
        $this->view->render('admin/lampiran/ubahLampiran');
    }

    public function rekamKlasifikasiArsip() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->inputRekamKlasArsip()){
                $this->view->success = "Rekam data klasifikasi arsip berhasil";
            }else{
                $this->view->error = "Rekam data klasifikasi arsip data gagal!";
            }
        }
        $this->view->klasArsip = $this->model->select('SELECT * FROM klasifikasi_arsip');
        $this->view->count = count($this->view->klasArsip);
        $this->view->render('admin/klasArsip/index');
    }

    public function ubahKlasifikasiArsip($id) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->updateRekamKlasArsip()){
                $this->view->success = "Ubah data klasifikasi arsip berhasil";
            }else{
                $this->view->error = "Ubah data klasifikasi arsip gagal!";
            }
        }
        $this->view->klasArsip = $this->model->select('SELECT * FROM klasifikasi_arsip');
        //di bawah ini bisa pake getKlasifikasiById
//        $dataUbah = $this->model->select('SELECT * FROM klasifikasi_arsip WHERE id_klasarsip=' . $id);
        $dataUbah = $this->model->getKlasifikasiById($id);
        foreach ($dataUbah as $value) {
            $this->view->data[0] = $value['id_klasarsip'];
            $this->view->data[1] = $value['kode'];
            $this->view->data[2] = $value['klasifikasi'];
        }
        $this->view->render('admin/klasArsip/ubahKlasArsip');
    }

    public function rekamLokasi() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->inputRekamLokasi()){
                $this->view->success = "rekam data berhasil";
            }else{
                $this->view->error = "rekam data gagal!";
            }
        }
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->rak = $this->model->select('SELECT * FROM lokasi WHERE tipe=1');
        $this->view->baris = $this->model->select('SELECT * FROM lokasi WHERE tipe=2');
        $this->view->lokasi = $this->model->viewLokasi();
        //$this->view->lokasi = $this->model->select('SELECT * FROM lokasi');
        $this->view->render('admin/lokasi/index');
    }

    public function ubahLokasi($id) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->updateRekamLokasi()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->rak = $this->model->select('SELECT * FROM lokasi WHERE tipe=1');
        $this->view->baris = $this->model->select('SELECT * FROM lokasi WHERE tipe=2');
        $this->view->lokasi = $this->model->viewLokasi();
//        $dataUbah = $this->model->select('SELECT * FROM lokasi WHERE id_lokasi=' . $id);
        $dataUbah = $this->model->getLokasibyId($id);
        foreach ($dataUbah as $value) {
            //jika rak maka langsung, jika baris maka dicari raknya dulu dari parent, jika box maka dua kali 
            //cari parent
            $this->view->data[0] = $value['id_lokasi'];
            $this->view->data[1] = $value['bagian'];
            $parent = $value['parent'];
            $tipe = (int) $value['tipe'];
            if ($tipe == 2) {
                //$prak = $this->model->select('SELECT * FROM lokasi WHERE id_lokasi='.$parent);
                //foreach ($prak as $value1){
                $this->view->data[2] = $value['parent'];
                $this->view->data[3] = null;
                //}
            }if ($tipe == 3) {
                $pbar = $this->model->select('SELECT * FROM lokasi WHERE id_lokasi=' . $parent);
                foreach ($pbar as $value1) {
                    $this->view->data[2] = $value1['parent'];
                    $this->view->data[3] = $value['parent'];
                }
            }
            $this->view->data[4] = $value['lokasi'];
        }

        //var_dump($this->view->data);
        $this->view->render('admin/lokasi/ubahLokasi');
    }

    public function rekamNomor() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->inputRekamNomor()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->nomor = $this->model->select('SELECT * FROM nomor');
        $this->view->count = count($this->view->nomor);
        $this->view->render('admin/nomor/index');
    }

    public function ubahNomor($id) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->updateRekamNomor()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->nomor = $this->model->select('SELECT * FROM nomor');
//        $dataUbah = $this->model->select('SELECT * FROM nomor WHERE id_nomor=' . $id);
        $dataUbah = $this->model->getNomorById($id);
        foreach ($dataUbah as $value) {
            $this->view->data[0] = $value['id_nomor'];
            $this->view->data[1] = $value['bagian'];
            $this->view->data[2] = $value['kd_nomor'];
        }
        $this->view->render('admin/nomor/ubahNomor');
    }

    public function rekamStatusSurat() {
        $this->view->status = $this->model->select('SELECT * FROM status');
        $this->view->count = count($this->view->status);
        $this->view->render('admin/status/index');
    }

    public function ubahStatusSurat($id) {
        $this->view->status = $this->model->select('SELECT * FROM status');
        $dataUbah = $this->model->select('SELECT * FROM status WHERE id_status=' . $id);
        foreach ($dataUbah as $value) {
            $this->view->data[0] = $value['id_status'];
            $this->view->data[1] = $value['tipe_surat'];
            $this->view->data[2] = $value['status'];
        }
        $this->view->render('admin/status/ubahStatus');
    }

    public function rekamUser() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        $user = new User();
        if(isset($_POST['submit'])){
            $cekuser = $user->cekUserExist($_POST['username'], $_POST['NIP']);
//            var_dump($cekuser);
            if($cekuser){
                $this->view->error = "nama user telah dipakai, atau pegawai ini telah memiliki akun!";
            }
            elseif($this->inputRekamUser()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->user = $this->model->select('SELECT * FROM user');
        $this->view->jabatan = $this->model->select('SELECT * FROM jabatan');
        $this->view->role = $this->model->select('SELECT * FROM role');
        $this->view->count = count($this->view->user);
        $this->view->render('admin/user/index');
    }
    
    public function cekUser(){
        $data = array();
        if(isset($_POST['user'])){
            $data = $this->model->select("SELECT * FROM user WHERE username = '".$_POST['user']."'");
        }elseif (isset($_POST['nip'])) {
            $data = $this->model->select("SELECT * FROM user WHERE NIP = '".$_POST['nip']."'");
        }
        
        $count = count($data);
        echo json_encode(array(
            'hasil'=>$count
        ));
    }

    public function ubahUser($id) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        $user = new User();
//        $dataUbah = $user->getUser($id);
        if(isset($_POST['submit'])){
//            if($user->cekUserExist($_POST['username'], $_POST['NIP'])){
//                $this->view->error = "nama user telah dipakai, atau pegawai ini telah memiliki akun!";
//            }
            $update = $this->updateRekamUser();
            if($update){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->user = $this->model->select('SELECT * FROM user');
        $this->view->jabatan = $this->model->select('SELECT * FROM jabatan');
        $this->view->role = $this->model->select('SELECT * FROM role');
        $dataUbah = $this->model->select('SELECT * FROM user WHERE id_user=' . $id);
        //belum disesuaikan dengan objek user
        foreach ($dataUbah as $value) {
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

    public function rekamPjs($user){
        if(Auth::isAllow(3, Session::get('role'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->inputRekamPjs()){
                $this->view->success = "Ubah data berhasil";
            }else{
                $this->view->error = "Ubah data gagal!";
            }
        }
        $this->view->user = $user;
//        $this->view->bagian = $this->model->getBagianLain($user);
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->role = $this->model->getRole();
        $this->view->pjs = $this->model->getPjs();
        $dnama = $this->model->select("SELECT namaPegawai, NIP FROM user WHERE username='".$user."'");
        $this->view->nama = '';
        foreach ($dnama as $val){
            $this->view->nama .= $val['namaPegawai'].'/'.$val['NIP'];
        }
        $this->view->render('admin/user/pjs');
    }
    
    public function inputRekamPjs(){
        $bagian = $_POST['bagian'];
        $jabatan = $_POST['jabatan'];
        $user = $_POST['id'];
        /*$this->view->user = $user;         
        $this->view->bagian = $this->model->getBagianLain($user);           
        $this->view->role = $this->model->getRole();        
        if($this->model->cekPejabatLama($bagian, $jabatan)){
            $this->view->warning = "Pejabat lama masih aktif, nonaktifkan terlebih dahulu!";         
        }else{*/
        $data = array(
            'user'=>$user,
            'bagian'=>$bagian,
            'jabatan'=>$jabatan
        );

        if($this->model->rekamPjs($data)){
            echo json_encode(array('status'=>'success',  
                'message'=>'<div id=success>Rekam pejabat sementara berhasil!</div>'));
        }else{
            echo json_encode(array('status'=>'error',  
                'message'=>'<div id=error>Rekam pejabat sementara berhasil!</div>'));
        }
           /* $this->view->success = "Input data pejabat sementara berhasil!";     
        }
        $this->view->pjs = $this->model->getPjs();
        //var_dump($this->view->pjs);
        $dnama = $this->model->select("SELECT namaPegawai, NIP FROM user WHERE username='".$user."'");
        $this->view->nama = '';
        foreach ($dnama as $val){
            $this->view->nama .= $val['namaPegawai'].'/'.$val['NIP'];
        }
        $this->view->render('admin/user/pjs');*/
            
    
    }
    
    public function hapuspjs($id){
        $where = ' id_pjs='.$id;
        $duser = $this->model->select("SELECT user FROM pjs WHERE id_pjs=".$id);
        $user = '';
        foreach ($duser as $val){
            $user = $val['user'];
        }
        //harusnya dilempar ke model
        $this->model->delete('pjs',$where);
        $this->view->success = "Hapus data pejabat sementara berhasil!";
        
        $this->view->user = $user;         
        $this->view->bagian = $this->model->getBagianLain($user);           
        $this->view->role = $this->model->getRole();
        $this->view->pjs = $this->model->getPjs();
        $dnama = $this->model->select("SELECT namaPegawai, NIP FROM user WHERE username='".$user."'");
        $this->view->nama = '';
        foreach ($dnama as $val){
            $this->view->nama .= $val['namaPegawai'].'/'.$val['NIP'];
        }
        $this->view->render('admin/user/pjs');
        //header('location:'.URL.'admin/rekamUser');
    }


    public function inputRekamKantor() {
        $data = array(
            //'ba'=>$_POST['ba'],
            //'es1'=>$_POST['es1'],
            'es2' => $_POST['es2'],
            'satker' => $_POST['satker'],
            'singkatan' => $_POST['singkatan'],
            'alamat' => $_POST['alamat'],
            'telepon' => $_POST['telepon'],
            'email' => $_POST['email'],
            'faksimile' => $_POST['faksimile'],
            'website' => $_POST['website'],
            'sms' => $_POST['sms'],
            'logo' => $_FILES['logo']
        );

        $this->model->insert('kantor', $data);
        return true;
//        $this->view->render('admin/kantor/index');
    }

    public function updateRekamKantor() {
        $data = array(
            'id' => $_POST['id'],
            //'ba'=>$_POST['ba'],
            //'es1'=>$_POST['es1'],
            'es2' => $_POST['es2'],
            'satker' => $_POST['satker'],
            'singkatan' => $_POST['singkatan'],
            'alamat' => $_POST['alamat'],
            'telepon' => $_POST['telepon'],
            'email' => $_POST['email'],
            'faksimile' => $_POST['faksimile'],
            'website' => $_POST['website'],
            'sms' => $_POST['sms']
                //'logo'=>$_FILES['logo']
        );
        //$this->model->delete('kantor',' id='.$data['id']);
        $this->model->update('kantor', $data, ' id=' . $data['id']);
//        $this->rekamKantor();
        return true;
    }

    public function inputRekamNomor() {
        $data = array(
            'bagian' => $_POST['bagian'],
            'kd_nomor' => $_POST['nomor']
        );
        if($this->model->addPenomoran($data)){
            echo json_encode(array(
                'status'=>'success',
                'message'=>'<div id=success>Rekam nomor berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                'status'=>'error',
                'message'=>'<div id=error>Rekam nomor gagal!</div>'
            ));
        }
//        $this->rekamNomor();
//        return true;
    }

    public function updateRekamNomor() {
        $data = array(
            'bagian' => $_POST['bagian'],
            'kd_nomor' => $_POST['nomor']
        );

        $where = ' id_nomor=' . $_POST['id'];
        if($this->model->updatePenomoran($data, $where)){
            echo json_encode(array(
                'status'=>'success',
                'message'=>'<div id=success>Ubah nomor berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                'status'=>'error',
                'message'=>'<div id=error>Ubah nomor gagal!</div>'
            ));
        }
//        $this->rekamNomor();
//        return true;
    }

    public function hapusNomor($id) {
        
        $this->model->deleteNomor($id);
        $this->rekamNomor();
    }

    public function inputRekamKlasArsip() {
        $data = array(
            'kode' => $_POST['kode'],
            'klasifikasi' => $_POST['klasifikasi']
        );
        if($this->model->addKlasifikasiArsip($data)){
            echo json_encode(array(
                "status"=>"success",
                "message"=>"<div id=success>Rekam data klasifikasi kode $_POST[kode] berhasil</div>"
                ));
        }else{
            echo "<div id=error>Rekam data klasifikasi kode $_POST[kode] gagal</div>";
        }
//        $this->rekamKlasifikasiArsip();
//        return true;
    }

    public function updateRekamKlasArsip() {
        $data = array(
            'kode' => $_POST['kode'],
            'klasifikasi' => $_POST['klasifikasi']
        );

        $where = ' id_klasarsip=' . $_POST['id'];
        if($this->model->updateKlasifikasiArsip($data, $where)){
            echo "<div id=success>Ubah data klasifikasi kode $_POST[kode] berhasil</div>";
        }else{
            echo "<div id=error>Ubah data klasifikasi kode $_POST[kode] gagal</div>";
        }
//        $this->rekamKlasifikasiArsip();
//        return true;
    }

    public function hapusKlasifikasiArsip($id) {
        
        $this->model->deleteKlasifikasiArsip($id);
        $this->rekamKlasifikasiArsip();
    }

    public function inputRekamLampiran() {
        $data = array(
            'tipe_naskah' => $_POST['tipe_naskah'],
            'kode_naskah' => $_POST['kode_naskah']
        );
        if($this->model->addLampiran($data)){
            echo json_encode(array(
                    'status' => 'success',
                    'message' => '<div id=success>Rekam tipe naskah dinas '.$_POST['tipe_naskah'].' berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                    'status' => 'error',
                    'message' => '<div id=success>Rekam tipe naskah dinas '.$_POST['tipe_naskah'].' gagal</div>'
            ));
        }
//        $this->rekamJenisLampiran();
//        return true;
    }

    public function updateRekamLampiran() {
        $data = array(
            'tipe_naskah' => $_POST['tipe_naskah'],
            'kode_naskah' => $_POST['kode_naskah']
        );
        $where = ' id_tipe=' . $_POST['id'];
        if($this->model->updateLampiran($data, $where)){
            echo json_encode(array(
                    'status' => 'success',
                    'message' => '<div id=success>Ubah tipe naskah dinas '.$_POST['tipe_naskah'].' berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                    'status' => 'error',
                    'message' => '<div id=error>Ubah tipe naskah dinas '.$_POST['tipe_naskah'].' gagal</div>'
            ));
        }
//        $this->rekamJenisLampiran();
//        return true;
    }
    
    /*
     * ubah status lampiran menjadi aktif dan tidak aktif
     * 
     */
    public function hapusLampiran($id) {
        $where = ' id_tipe =' . $id;
        $this->model->deleteLampiran($where);
        $this->rekamJenisLampiran();
    }

    public function inputRekamStatus() {
        $data = array(
            'tipe_surat' => $_POST['tipe_surat'],
            'status' => $_POST['status']
        );
        $this->model->addStatusSurat($data);
        $this->rekamStatusSurat();
    }

    public function updateRekamStatus() {
        $data = array(
            'tipe_surat' => $_POST['tipe_surat'],
            'status' => $_POST['status']
        );

        $where = ' id_status=' . $_POST['id'];
        $this->model->updateStatusSurat($data, $where);
        $this->rekamStatusSurat();
    }

    public function hapusStatus($id) {
        $where = ' id_status=' . $id;
        $this->model->deleteStatusSurat($where);
        $this->rekamStatusSurat();
    }

    public function inputRekamUser() {
        $user = new User();
        $user->set('namaPegawai', $_POST['namaPegawai']);
        $user->set('NIP', $_POST['NIP']);
        $user->set('nama_user', $_POST['username']);
        $user->set('password', Hash::create('md5', $_POST['password'], HASH_SALT_KEY));
        $user->set('bagian', $_POST['bagian']);
        $user->set('jabatan', $_POST['jabatan']);
        $user->set('role', $_POST['role']);
        $user->set('active', 'Y');
        /*$data = array(
            'namaPegawai' => $_POST['namaPegawai'],
            'NIP' => $_POST['NIP'],
            'username' => $_POST['username'],
            'password' => Hash::create('md5', $_POST['password'], HASH_SALT_KEY),
            'bagian' => $_POST['bagian'],
            'jabatan' => $_POST['jabatan'],
            'role' => $_POST['role'],
            'active' => 'Y'
        );*/
        if($user->addUser()){
            echo json_encode(array(
                'status'=>'success',
                'message'=>'<div id=success>Rekam pengguna atas nama '.$_POST['namaPegawai'].' berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                'status'=>'error',
                'message'=>'<div id=error>Rekam pengguna atas nama '.$_POST['namaPegawai'].' gagal</div>'
            ));
        }
//        $this->model->addUser($data);
//        $this->rekamUser();
//        return true;
    }

    public function updateRekamUser() {
        $user = new User();
        $user->set('id_user', $_POST['id']);
        $user->set('namaPegawai', $_POST['namaPegawai']);
        $user->set('NIP', $_POST['NIP']);
        $user->set('nama_user', $_POST['username']);
        $user->set('password', Hash::create('md5', $_POST['password'], HASH_SALT_KEY));
        $user->set('bagian', $_POST['bagian']);
        $user->set('jabatan', $_POST['jabatan']);
        $user->set('role', $_POST['role']);
        $user->set('active', 'Y');
        /*$data = array(
            'namaPegawai' => $_POST['namaPegawai'],
            'NIP' => $_POST['NIP'],
            'username' => $_POST['username'],
            'password' => Hash::create('md5', $_POST['password'], HASH_SALT_KEY),
            'bagian' => $_POST['bagian'],
            'jabatan' => $_POST['jabatan'],
            'role' => $_POST['role'],
            'active' => 'Y'
        );*/

//        $where = ' id_user=' . $_POST['id'];
        
//        $this->model->updateUser($data, $where);
//        $this->rekamUser();
        if($user->editUser()){
            echo json_encode(array(
                'status'=>'success',
                'message'=>'<div id=success>Ubah data pengguna atas nama '.$_POST['namaPegawai'].' berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                'status'=>'error',
                'message'=>'<div id=error>Ubah data pengguna atas nama '.$_POST['namaPegawai'].' gagal</div>'
            ));
        }
    }

    public function hapusUser($id) {
        $user = new User();
        $user->set('id_user', $id);
        $user->hapusUser();
//        $where = ' id_user=' . $id;
//        $this->model->deleteUser($where);
        $this->rekamUser();
    }

    public function setAktifUser($id, $active) { //belum ada cek apakah ada pjs
        $user = new User();
        $user->set('id_user', $id);
        $aktif = ($active == 'Y') ? 'N' : 'Y';
        $jabatan = 0;
        $bagian = 0;
        $datau = $this->model->select("SELECT jabatan, bagian FROM user WHERE id_user=".$id);
        foreach ($datau as $val){
            $jabatan = $val['jabatan'];
            $bagian = $val['bagian'];
        }
        if($aktif=='Y'){ //cari bagian dulu
            if($this->model->cekPjs($bagian,$jabatan)){
                $this->rekamUser();
                return false;
            }
        }
        $user->set('active', $aktif);
        $user->setAktifUser();
        //echo $aktif;
//        $this->model->setAktifUser($id, $aktif);
        $this->rekamUser(); 
    }

    public function inputRekamLokasi() {
        $rak = (int) $_POST['rak'];
        $baris = (int) $_POST['baris'];
        $parent = null;
        if ($rak == 0 && $baris == 0) {
            $tipe = 1;
        } elseif ($rak != 0 && $baris == 0) {
            $tipe = 2;
            $parent = $rak;
        } elseif ($rak != 0 && $baris != 0) {
            $tipe = 3;
            $parent = $baris;
        }
        $data = array(
            'parent' => $parent,
            'bagian' => $_POST['bagian'],
            'lokasi' => $_POST['nama'],
            'tipe' => $tipe,
            'status' => 'E'
        );
//        var_dump($data);
        if($this->model->addLokasi($data)){
            echo json_encode(array(
                'status'=>'success',
                'message'=>'<div id=success>Rekam lokasi berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                'status'=>'error',
                'message'=>'<div id=error>Rekam lokasi gagal!</div>'
            ));
        }
//        $this->rekamLokasi();
//        return true;
    }

    public function updateRekamLokasi() {
        $id = $_POST['id'];
        $rak = (int) $_POST['rak'];
        $baris = (int) $_POST['baris'];
        $parent = null;
        if ($rak == 0 && $baris == 0) {
            $tipe = 1;
        } elseif ($rak != 0 && $baris == 0) {
            $tipe = 2;
            $parent = $rak;
        } elseif ($rak != 0 && $baris != 0) {
            $tipe = 3;
            $parent = $baris;
        }
        $data = array(
            'parent' => $parent,
            'bagian' => $_POST['bagian'],
            'lokasi' => $_POST['nama'],
            'tipe' => $tipe,
            'status' => 'E'
        );
        $where = ' id_lokasi=' . $id;
        if($this->model->updateLokasi($data, $where)){
            echo json_encode(array(
                'status'=>'success',
                'message'=> '<div id=success>Rekam lokasi berhasil</div>'
            ));
        }else{
            echo json_encode(array(
                'status'=>'error',
                'message'=> '<div id=success>Rekam lokasi gagal!</div>'
            ));
        }
//        $this->rekamLokasi();
//        return true;
    }

    public function ubahStatusLokasi($id, $status) {
        $status = ($status == 'E') ? 'F' : 'E';
        //echo $aktif;
        $this->model->setStatusLokasi($id, $status);
        $this->rekamLokasi();
//        return true;
    }
    
    public function inputRekamAlamat(){
        $data = array(
            'kode_satker'=>$_POST['kode_satker'],
            'nama_satker'=>$_POST['nama_satker'],
            'jabatan'=>$_POST['jabatan'],
            'alamat'=>$_POST['alamat'],
            'telepon'=>$_POST['telepon'],
            'email'=>$_POST['email']
        );
        
        if($this->model->existAlamat($_POST['kode_satker'])){
            echo "<div id=error>alamat dengan kode $_POST[kode_satker] telah ada di database!</div>";
            return false;
        }
        //var_dump($data);
        if($this->model->addAlamatSurat($data)){
            echo "<div id=success>Rekam data alamat kode alamat $_POST[kode_satker] berhasil</div>";
        }else{
            echo "<div id=error>Rekam data alamat kode alamat $_POST[kode_satker] gagal!</div>";
        }
//        $this->rekamAlamat();
    }
    
    public function updateRekamAlamat(){
        $data = array(
            'kode_satker'=>$_POST['kode_satker'],
            'nama_satker'=>$_POST['nama_satker'],
            'jabatan'=>$_POST['jabatan'],
            'alamat'=>$_POST['alamat'],
            'telepon'=>$_POST['telepon'],
            'email'=>$_POST['email']
        );
        
        /*if($this->model->existAlamat($_POST['kode_satker'])){
            return false;
        }*/
        
        $where = ' id_alamat='.$_POST['id'];
        if($this->model->updateAlamatSurat($data, $where)){
            echo "<div id=success>Ubah data alamat kode alamat $_POST[kode_satker] berhasil</div>";
        }else{
            echo "<div id=error>Ubah data alamat kode alamat $_POST[kode_satker] gagal!</div>";
        }
//        $this->rekamAlamat();
//        return true;
        
    }
    
    public function calendar($date){
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        
        $this->view->curDate = $date;
        $this->view->tgl = date('Y-m-d',$date);
        $this->view->ket = $this->model->cekLibur($this->view->tgl);
        $this->view->event = $this->model->getLibur();
//        var_dump($this->view->ket);
        $this->view->render('admin/libur/rekamLibur');
    }
    
    public function rekamLibur(){
        $tgl = $_POST['tgl'];
//        echo $tgl;
        /*$temp = str_replace("-", "",$tgl);
        $date = substr($temp, -2);
        $month = substr($temp, 4,2);
        $year = substr($temp, 0,4);*/
        $ket = $_POST['ket'];        
        $temp = explode(" ", $tgl);
        $date = $temp[0];
        $year = $temp[2];
        $month = Tanggal::bulan_num($temp[1]);
        if($ket==''){
            $thisday = mktime(0 ,0 ,0, $month, $date, $year);
            header('location:'.URL.'admin/calendar/'.$thisday);
            return false;
        }
        $tgl = $year.'-'.$month.'-'.$date;
//        echo $tgl;
        $data = array('tgl'=>$tgl,'keterangan'=>$ket);
        if($this->model->rekamLibur($data)){
            $thisday = mktime(0 ,0 ,0, $month, $date, $year);
            header('location:'.URL.'admin/calendar/'.$thisday);
        }
    }
    
    public function updateLibur(){
        $tgl = $_POST['tgl'];
        $ket = $_POST['ket'];
        $temp = explode(" ", $tgl);
        $date = $temp[0];
        $year = $temp[2];
        $month = Tanggal::bulan_num($temp[1]);
        $tgl = $year.'-'.$month.'-'.$date;
        $data = array('tgl'=>$tgl,'keterangan'=>$ket);
        if($this->model->updateLibur($data)){
            $thisday = mktime(0 ,0 ,0, date('m'), date('d'), date('Y'));
            header('location:'.URL.'admin/calendar/'.$thisday);
        }        
    }

    public function hapusLibur(){
        $tgl = $_POST['queryString'];
        $temp = explode(" ", $tgl);
        $date = $temp[0];
        $year = $temp[2];
        $month = Tanggal::bulan_num($temp[1]);
        $tgl = $year.'-'.$month.'-'.$date;
        if($this->model->deleteLibur($tgl)){
            echo 'Hapus data libur berhasil';
        }else{
            echo 'Hapus data libur gagal';
        }
    }
    
    public function cekLibur(){
        $tgl = date('Y-m-d',$_POST['queryString']);
        echo Tanggal::tgl_indo($tgl);
    }


    public function backuprestore(){
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        
        $this->view->render('admin/restore/restore');
    }
    
    public function backup(){
        $db = new Backuprestore();
        
        $db->connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        $db->backupDatabase('sisurip');        
        
        echo "<div id=success>Backup data berhasil dilakukan</div>";
    }
    
    public function restore(){
        $db = new Backuprestore();
        $db->connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        if (isset($_POST['submitRestoreDB'])) {
            if (!empty($_FILES['file']['name'])) {
                if ($db->getlast($_FILES['file']['name']) == 'sql') {
                    echo $db->getlast($_FILES['file']['name']);
                    $tempFile = $_FILES['file']['tmp_name'];
                    $targetFile = 'public/temp/' . $_FILES['file']['name'];
                    move_uploaded_file($tempFile, $targetFile);
                    $db->restoreDatabaseSql($targetFile);
                } elseif ($db->getlast($_FILES['file']['name']) == 'zip') {
                    $tempFile = $_FILES['file']['tmp_name'];
                    $targetFile = 'public/temp/' . $_FILES['file']['name'];
                    move_uploaded_file($tempFile, $targetFile);
                    $db->restoreDatabaseZip($targetFile);
                } else {
                    echo "Invalid Database File Type";
                }
            }
        }
        
        $this->view->message = "<div id=success>restore data telah berhasil dilakukan, ".$_SESSION['ttlQuery']." query dieksekusi pada ".date('Y-m-d H:i:s', $_SESSION['timeQuery'])."</div>"; 
    
        $this->view->render('admin/restore/restore');
    }
    
    public function displaylog(){
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        $log = new Log();
        $this->view->data = $log->getLog('libs/log.csv');        
        
        $this->view->render('admin/log');
    }
    
    public function setAktiveUser(){
        $q = $_POST['queryString'];
        $post = explode("-", $q);
        $user = new User();
        $user->set('id_user', $post[0]);
        $aktif = ($post[1] == 'Y') ? 'N' : 'Y';
        $jabatan = 0;
        $bagian = 0;
        $datau = $this->model->select("SELECT jabatan, bagian FROM user WHERE id_user=".$post[0]);
        foreach ($datau as $val){
            $jabatan = $val['jabatan'];
            $bagian = $val['bagian'];
        }
        if($aktif=='Y'){ //cari bagian dulu
            if($this->model->cekPjs($bagian,$jabatan)){
//                $this->rekamUser();
                echo "<div id=warning>Pejabat Sementara masih aktif, hapus dahulu data pejabat sementara!</div>";
                return false;
            }
        }
        $user->set('active', $aktif);
        $user->setAktifUser();
        echo "<div id=success>Set Aktif Pengguna berhasil.</div>";
        //echo $aktif;
//        $this->model->setAktifUser($id, $aktif);
//        $this->rekamUser();
    }
    
    public function cekPejabat(){
        $bagian = $_POST['bagian'];
        $jabatan = $_POST['jabatan'];
        $sql = "SELECT * FROM user WHERE bagian=".$bagian." AND role=".$jabatan." AND active='Y'";
        $data = $this->model->select($sql);
        
        $return = count($data);
        
        echo json_encode(array('hasil'=>$return));
        
    }
    
    public function cekExistPjs(){
        $bagian = $_POST['bagian'];
        $jabatan = $_POST['jabatan'];
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $sql = "SELECT * FROM pjs WHERE user='".$id."' AND bagian=".$bagian." AND jabatan=".$jabatan;
        }else{
            $sql = "SELECT * FROM pjs WHERE bagian=".$bagian." AND jabatan=".$jabatan;
        }
        
        $data = $this->model->select($sql);
        
        $return = count($data);
        
        echo json_encode(array('pjs'=>$return));
        
    }
    
    public function userHome($username) {
        $user = new User();
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        $this->view->user = $this->model->select('SELECT * FROM user');
        $this->view->jabatan = $this->model->select('SELECT * FROM jabatan');
        $this->view->role = $this->model->select('SELECT * FROM role');
        $dataUbah = $this->model->select("SELECT * FROM user WHERE username='" . $username."'");
        $this->view->count = count($this->view->user);
        //belum disesuaikan dengan objek user
        foreach ($dataUbah as $value) {
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
        $this->view->render('admin/user/userhome');
    }
            
    
}

?>