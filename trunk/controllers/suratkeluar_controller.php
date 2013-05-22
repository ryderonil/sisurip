<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suratkeluar_Controller extends Controller {

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->view->kantor = Kantor::getNama();
        $this->view->js = array(
            'suratkeluar/js/default',
            'suratkeluar/js/jquery.tipTip',
            'suratkeluar/js/jquery.tipTip.minified'
        );
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }

    //put your code here

    public function index($halaman=null,$batas=null) {
        if(is_null($halaman)) $halaman=1;
        if(is_null($batas)) $batas=10;
        $this->showAll($halaman,$batas);
    }

    public function showAll($halaman=null,$batas=null) {
        $url = 'suratkeluar/index';        
        if(is_null($halaman)) $halaman=1;
        if(is_null($batas)) $batas=10;        
        $this->view->paging = new Paging($url, $batas, $halaman);
//        $this->view->jmlData = $this->model->countRow('suratkeluar');
        $this->view->jmlData = count($this->model->showAll());
        $posisi = $this->view->paging->cari_posisi();
        $this->view->data = $this->model->showAll($posisi, $batas);
        //var_dump($this->view->data);
        $this->view->render('suratkeluar/suratkeluar');
    }

    public function rekam($id_sm = null, $ids = null) {
        if(!Auth::isAllow(3, Session::get('role'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->input()){
                $this->view->success="Rekam surat keluar berhasil";
            }else{
                $this->view->error="Rekam surat keluar gagal";
            }
        }
        
        if (!is_null($id_sm)) {
//cek id_sm jika panjang=5 maka kode satker
            $length = strlen($id_sm);
            //echo $length . " " . $id_sm;
            if ($length == 6) {
                $this->view->alamat = $id_sm;
                $almt = new Admin_Model();
                $alamat = $almt->getAlamat($id_sm);
                //$this->view->alamat
                foreach ($alamat as $value) {
                    $this->view->alamat .= ' ' . $value['nama_satker'];
                }
                //echo $this->view->alamat;
                if (!is_null($ids)) {
                    $sm = new Suratmasuk_Model();
                    $datasm = $sm->getSuratById($ids);
//                    $datasm = $this->model->select('SELECT id_suratmasuk, no_agenda, no_surat FROM suratmasuk WHERE id_suratmasuk=' . $ids);
                    foreach ($datasm as $value) {
                        $this->view->data[0] = $value['id_suratmasuk'];
                        $this->view->data[1] = $value['no_agenda'];
                        $this->view->data[2] = $value['no_surat'];
                    }
                }
            } else {


                $datasm = $this->model->select('SELECT id_suratmasuk, no_agenda, no_surat FROM suratmasuk WHERE id_suratmasuk=' . $id_sm);
                foreach ($datasm as $value) {
                    $this->view->data[0] = $value['id_suratmasuk'];
                    $this->view->data[1] = $value['no_agenda'];
                    $this->view->data[2] = $value['no_surat'];
                }
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

    public function input() {
        $notif = new Notifikasi();
        $upload = new Upload('upload');
        $time = date('Y-m-d H:i:s');
        $tgl = $_POST['tgl_surat']=='0000-00-00'?date('Y-m-d'):$_POST['tgl_surat'];
        $data = array(
            'rujukan' => $_POST['rujukan'],
            'no_surat' => $_POST['nomor'],
            'tipe' => $_POST['tipe'],
            'tgl_surat' => Tanggal::ubahFormatTanggal($tgl),
            'tujuan' => substr($_POST['tujuan'], 0, 6),
            'perihal' => $_POST['perihal'],
            'sifat' => $_POST['sifat'],
            'jenis' => $_POST['jenis'],
            'lampiran' => $_POST['lampiran'],
            'user' => Session::get('user'),
            'status' => '21',
            'start' => $time
        );

        //var_dump($data);       
        //upload file surat, sementara di temp folder krn belom dapat nomor
        if($this->model->input($data)!=true){
            $this->view->success = "rekam data surat keluar berhasil";
        }else{
            $this->view->error = "rekam data surat keluar tidak berhasil";
        }        
        
        $upload->setDirTo('arsip/temp/');
        $tipe = 'K';
        $satker = substr($_POST['tujuan'], 0, 6);
        $id = 0;
        $sql = "SELECT MAX(id_suratkeluar) as id FROM suratkeluar";
        $did = $this->model->select($sql);
        foreach ($did as $valid) {
            $id = $valid['id'];
        }
        //nama baru akan terdiri dari tipe naskah_nomor surat_asal(asal/tetapi asal terlaku kepanjangan)
        $ubahNama = array($tipe, $id, $satker);
        $upload->setUbahNama($ubahNama);
        $upload->changeFileName($upload->getFileName(), $ubahNama);
        $namafile = $upload->getFileTo();
        $where = ' id_suratkeluar=' . $id;

        $data = array(
            'file' => $namafile
        );        
        $bagianu = Session::get('bagian');
        $upload->uploadFile();
        $this->model->uploadFile($data, $where);
        $dataks = $this->model->select("SELECT id_user FROM user WHERE role=2 AND bagian =".$bagianu." AND active='Y'");
        foreach($dataks as $val){
            $notif->set('id_user',$val['id_user']);
        }
        $notif->set('id_surat',$this->model->lastIdInsert($_POST['tipe']));
        $notif->set('jenis_surat','SK');
        $notif->set('role',2);
        $notif->set('bagian',$bagianu);
        $notif->set('stat_notif',1);        
        $notif->addNotifikasi();        
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'REKAM SK','user '.$user.' rekam surat keluar tujuan '.substr($_POST['tujuan'], 0, 6));
        unset($log);
        return true;
//        $this->view->render('suratkeluar/rekam');
    }

    public function detil($id) {
        $data = $this->model->getSuratById($id, 'detil');
//        foreach ($data as $value) {
            $this->view->id = $this->model->getId();
            $this->view->rujukan = $this->model->getRujukan();
            $this->view->tipe = $this->model->getTipeSurat();
            $this->view->no_surat = $this->model->getNomor();
            $this->view->tgl_surat = $this->model->getTglSurat();
            $this->view->tujuan = $this->model->getAlamat();
            $this->view->perihal = $this->model->getPerihal();
            $this->view->sifat = $this->model->getSifat();
            $this->view->jenis = $this->model->getJenis();
            $this->view->lampiran = $this->model->getJmlLampiran();
            $this->view->file = $this->model->getFile();
            $this->view->status = $this->model->getStatus();
//        }
        
        $lamp = new Lampiran_Model();
        $this->view->datal = $lamp->getLampiranSurat($this->view->id, 'SK');
        
        $this->view->count = count($this->view->datal);

        $this->view->render('suratkeluar/detilsurat');
    }

    public function edit($id_sk = null, $ids = null) {
        if(isset($_POST['submit'])){
        
            if($this->editSurat()){
                $this->view->success="Ubah data surat keluar berhasil";
            }else{
                $this->view->error="Ubah data surat keluar gagal!";
            }
        }
        if (!is_null($id_sk)) {
//cek id_sm jika panjang=5 maka kode satker
            $length = strlen($id_sk);
            //echo $length . " " . $id_sm;
            if ($length == 6) {
                $this->view->alamat = $id_sk;
                $almt = new Admin_Model();
                $alamat = $almt->getAlamat($id_sk);
                //$this->view->alamat
                foreach ($alamat as $value) {
                    $this->view->alamat .= ' ' . $value['nama_satker'];
                }
//                echo $this->view->alamat;
                if (!is_null($ids)) {
                    $this->view->data = $this->model->getSuratById($ids, 'ubah');
                    $this->view->sifat = $this->model->get('sifat_surat');
                    $this->view->jenis = $this->model->get('klasifikasi_surat');
                    $this->view->tipe = $this->model->select('SELECT * FROM tipe_naskah');
                    //var_dump($this->view->jenis);
                    
                }
            } else {


                $this->view->data = $this->model->getSuratById($id_sk, 'ubah');
                $this->view->sifat = $this->model->get('sifat_surat');
                $this->view->jenis = $this->model->get('klasifikasi_surat');
                $this->view->tipe = $this->model->select('SELECT * FROM tipe_naskah');
                //var_dump($this->view->jenis);
            }
        }       
       
            $this->view->id = $this->view->data->getId();
            $this->view->tipe1 = $this->view->data->getTipeSurat();
            $this->view->no_surat = $this->view->data->getNomor();
            $this->view->tgl_surat = str_replace("-", "/", $this->view->data->getTglSurat());
            $this->view->tujuan = $this->view->data->getAlamat();
            $this->view->perihal = $this->view->data->getPerihal();
            $this->view->sifat1 = $this->view->data->getSifat();
            $this->view->jenis1 = $this->view->data->getJenis();
            $this->view->lampiran = $this->view->data->getJmlLampiran();
//            var_dump($this->view->no_surat);
        $this->view->render('suratkeluar/ubah');
    }

    public function editSurat() {
        $temp = explode(' ', $_POST['tujuan']);
        $tujuan = $temp[0];
        $data = array(
            "tipe" => $_POST['tipe'],
            "tgl_surat" => Tanggal::ubahFormatTanggal($_POST['tgl_surat']),
            "no_surat" => $_POST['nomor'],
            "tujuan" => $tujuan,
            "perihal" => $_POST['perihal'],
            "sifat" => $_POST['sifat'],
            "jenis" => $_POST['jenis'],
            "lampiran" => $_POST['lampiran']
        );

        $id = $_POST['id'];
        $where = "id_suratkeluar = '" . $id . "'";
        //var_dump($data);
        //var_dump($where);
        //echo $where;
        $this->model->editSurat($data, $where); //status net
        if($_POST['nomor']!=''){
            $data = array('status'=>22);            
            $this->model->editSurat($data, $where);
        }
        //mgkn bisa pake js untuk pesan berhasil atau gagal, dan dimunculkan di halaman yg sama
        //atau dimunculkan di halaman lihat data surat keluar
//        header('location:' . URL . 'suratkeluar');
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'UBAH SK','user '.$user.' ubah surat keluar tujuan: '.$id.' perihal:'.$_POST['perihal']);
        unset($log);
        return true;
    }

    public function remove($id) {
        $where = ' id_suratkeluar=' . $id;        
        $this->model->remove($where);
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'HAPUS SK','user '.$user.' hapus surat keluar id '.$id);
        unset($log);
        header('location:'.URL.'suratkeluar');
    }
    
    /*
     * seharusnya ada mekanisme cek apakah telah mendapat nomor atau belum
     * alternatif lain, selama belum mendapat nomor masih di temporary
     */
    public function download($id) {
        // membaca informasi file dari tabel berdasarkan id nya        
        $datas = $this->model->getSuratById($id, 'ubah');
//        foreach ($datas as $data) {
            // header yang menunjukkan nama file yang akan didownload
            header("Content-Disposition: attachment; filename=" . $datas->getFile());

            //header("Content-length: " . $data['size']);
            //header("Content-type: " . $data['type']);
            // proses membaca isi file yang akan didownload dari folder 'data'
            $fp = fopen("arsip/temp/" . $datas->getFile(), 'r');
            $content = fread($fp, filesize('arsip/temp/' . $datas->getFile()));
            fclose($fp);

            // menampilkan isi file yang akan didownload
            echo $content;
//        }
        exit;
    }
    
    public function downloadrev($id) {
        // membaca informasi file dari tabel berdasarkan id nya        
        $sql = "SELECT * FROM revisisurat WHERE id_revisi=".$id;
        $datas = $this->model->select($sql);
        var_dump($datas);
        foreach ($datas as $data) {
            
            header("Content-Disposition: attachment; filename=" . $data['file']);
            
            $fp = fopen("arsip/temp/" . $data['file'], 'r');
            $content = fread($fp, filesize('arsip/temp/' . $data['file']));
            fclose($fp);

            // menampilkan isi file yang akan didownload
            echo $content;
        }
        exit;
    }
    
    public function rekamrev($id){
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                if(!Auth::isAllow(3, Session::get('role'))){
                    header('location:'.URL.'home');
                }
            }
        }
        if(isset($_POST['submit'])){
            if($this->uploadrev()){
                $this->view->success = "Rekam revisi berhasil";
            }else{
                $this->view->error = $this->uploadrev();
            }
        }
        
        $this->view->data = $this->model->getSuratById($id, 'detil');
        $this->view->datar = $this->model->getHistoriRevisi($id);
        
        $this->view->render('suratkeluar/revisi');
        
    }
    
    /*
     * rekam revisi
     * upload file revisi
     * tambah notifikasi kasi dan pelaksana
     */
    public function uploadrev(){
        $return = true;
        $notif = new Notifikasi();
        $id = $_POST['id'];
        $catatan = $_POST['catatan'];
        $user = $_POST['user'];
//        var_dump($catatan);       
        
        $time = date('Y-m-d H:i:s');
        $filename ='';
        $datas = $this->model->getSuratById($id, 'detil');
//        foreach ($datas as $val){
            $filename = $datas->getFile();
//        }
        
        //---------------------------------
        $fln = array();
        if(file_exists('arsip/temp/'.$filename)){
            $temp = explode('.', $filename);
//            var_dump($temp);
            $sql = "SELECT file FROM revisisurat WHERE file LIKE '$temp[0]%'";
            $file = $this->model->select($sql);
//            var_dump($file);
            if(count($file>0)){
                if(count($file)==1){
                    $pisah = explode('.', $filename);
                    $nama = $pisah[0];
                    $ext = $pisah[1];
                    var_dump($ext);
                    $filename = $nama.'_1.'.$ext;
//                    var_dump($filename);
//                    break;
                }else{
                    foreach ($file as $val){
                        $temp = explode('.', $val['file']);                        
                        $pisah = explode('_', $temp[0]);
                        if(count($pisah)<=3){
                            $fln[] = 0;
                        }else{
                            $fln[] = $pisah[3];
                        }
//                        $fln[] = explode('_', $temp[0]);
                        
//                        var_dump($fln);
//                        $len = count($temp);
//                        $fln[] = (int) ($len-1); //mengambil array terakhir
                        $num = max($fln);
//                        var_dump($num);                        
                        $filename = $pisah[0].'_'.$pisah[1].'_'.$pisah[2].'_'.($num+1).'.'.$temp[1]; 
//                        var_dump($filename);
                    }
                    
                }
            }
        }
        //-----------------------------------
        
        $data = array(
            'id_surat'=>$id,
            'catatan'=>$catatan,
            'user'=>$user,
            'file'=>$filename, 
            'time'=>$time
        );  
        
        $upload = new Upload('upload');
        
        $upload->setDirTo('arsip/temp/');
        $upload->setFileTo($filename);
        $upload->uploadFile();
        //upload file revisi
//        $upl = $upload->uploadFile(); //upload dengan nama beda jika sudah terdapat file di arsip
//        if(!$upl){
//            $return = "Gagal upload! cek file dan ekstensi, ekstensi harus pdf, doc atau docx";
//        }
        $role = Session::get('role'); 
        /*
         * alurnya klo revisi kasi->pelaksana
         * revisi kk -> kasi dan pelaksana :siiip
         * otak atik dari awak lagi, ternyata butuh field user/creator surat keluar yg berisi pelaksananya siapa
         */
        //var_dump($id);
        $notif->set('id_surat',$id); //cek lagi
        $notif->set('jenis_surat','SK');
        $notif->set('stat_notif',1);  
        $user = $this->model->getUser($id);
        //var_dump($user);
        $notif->set('bagian',$user[2]); 
        if($role==1){
            $dataks = $this->model->select("SELECT id_user FROM user WHERE role=2 AND bagian =".$user[2]." AND active='Y'");
            foreach($dataks as $val){
                $notif->set('id_user',$val['id_user']);
            }
            $notif->set('role',2);
            //tambah notifikasi untuk kasi
            $notif->addNotifikasi();
        }
        $notif->set('id_user', $user[0]);
        $notif->set('role',$user[1]);
        //tambah notifikasi untuk pelaksana
        $notif->addNotifikasi();
        
        //tambah revisi
        $this->model->addRevisi($data);
        
//        $this->showAll();
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'REKAM REVISI','user '.$user.' rekam revisi surat keluar id '.$id.' nama file '.$filename);
        unset($log);
        return $return;
        
    }
    
    public function nomorSurat(){
        $tipe = $_POST['queryString'];
        $bagian = Session::get('bagian');
        //var_dump($bagian);
        $sql = "SELECT kd_bagian FROM r_bagian WHERE id_bagian=".$bagian;
        $datab = $this->model->select($sql);
        foreach ($datab as $val){
            $bagian = $val['kd_bagian'];
        }
        //var_dump($bagian);
        //var_dump($tipe);
        $no = new Nomor();
        $nosurat = $no->generateNumber($tipe, $bagian);
        echo $nosurat;    
        
    }
    
    public function view($id){
        $data = $this->model->getSuratById($id,'detil');
        $this->view->file = $data->getFile();
        $this->view->load('suratkeluar/viewsurat');
    }

}

?>
