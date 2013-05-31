<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of suratMasuk
 *
 * @author aisyah
 */
class Suratmasuk_Controller extends Controller {

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama();
        $this->view->js = array(
            'suratmasuk/js/default',
            'suratkeluar/js/jquery.tipTip',
            'suratkeluar/js/jquery.tipTip.minified'
        );
    }
    
    public function index($halaman=null, $batas=null) {
        if(is_null($halaman)) $halaman=1;
        if(is_null($batas)) $batas=10; 
        $this->showAll($halaman, $batas);
    }

    public function showAll($halaman=null, $batas=null) {
        $url = 'suratmasuk/index';        
        if(is_null($halaman)) $halaman=1;
        if(is_null($batas)) $batas=10;        
        $this->view->paging = new Paging($url, $batas, $halaman);
//        $this->view->jmlData = $this->model->countRow('suratmasuk');
        $this->view->jmlData = count($this->model->showAll());
        $posisi = $this->view->paging->cari_posisi();
        $listSurat = $this->model->showAll($posisi, $batas);        
        $this->view->listSurat = $listSurat;
        $this->view->render('suratmasuk/suratmasuk');
    }

    public function edit($id_sm = null, $ids = null) {
        if(!Auth::isAllow(2, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->editSurat()){
            
                $this->view->success="Ubah data suratmasuk berhasil";
            }else{
                $this->view->error ="Ubah data suratmasuk gagal!";
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
                    $this->view->data = $this->model->getSuratById($ids);
                    $this->view->sifat = $this->model->get('sifat_surat');
                    $this->view->jenis = $this->model->get('klasifikasi_surat');
                    //var_dump($this->view->jenis);
                }
            } else {


                $this->view->data = $this->model->getSuratById($id_sm);
                $this->view->sifat=$this->model->get('sifat_surat');
                $this->view->jenis=$this->model->get('klasifikasi_surat');
                //var_dump($this->view->jenis);
            }
        }
        /** **/
        //$this->view->data = $this->model->getSuratMasukById($ids);
        $this->view->render('suratmasuk/ubah');
    }

    public function hapus($id) {        
        $this->model->setId($id);
        $this->model->remove();
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'DELETE SM','user '.$user.' menghapus surat masuk no agenda'.$this->model->getNomorAgenda($id));
        unset($log);
        header('location:'.URL.'suratmasuk');
    }

    public function editSurat() {
        /*
         * $this->model->setId($_POST['id']);
         * $this->model->setTglTerima($_POST['tgl_terima']);
         * $this->model->setTglSurat($_POST['tgl_surat']);
         * $this->model->setNomor($_POST['no_surat']);
         * $this->model->setAlamat($_POST['asal_surat']);
         * $this->model->setPerihal($_POST['perihal']);
         * $this->model->setStatusSurat($_POST['status']);
         * $this->model->setSifat($_POST['sifat']);
         * $this->model->setJenis($_POST['jenis']);
         * $this->model->setJmlLampiran($_POST['lampiran']);
         */
        $data = array(
            "tgl_terima"=>$_POST['tgl_terima'],
            "tgl_surat"=>  Tanggal::ubahFormatTanggal($_POST['tgl_surat']),
            "no_surat"=>$_POST['no_surat'],
            "asal_surat"=>$_POST['asal_surat'],
            "perihal"=>$_POST['perihal'],
            "status"=>$_POST['status'],
            "sifat"=>$_POST['sifat'],
            "jenis"=>$_POST['jenis'],
            "lampiran"=>$_POST['lampiran']
        );
        $id = $_POST['id_suratmasuk'];
        $where = "id_suratmasuk = '".$id."'";
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'UBAH SM','user '.$user.' ubah surat masuk no agenda '.$this->model->getNomorAgenda($id));
        unset($log);
        if($this->model->editSurat($data,$where)){
            echo "<div id=success>Ubah data surat dengan nomor agenda $_POST[no_agenda] berhasil.</div>";
        }else{
            echo "<div id=error>Ubah data surat dengan nomor agenda $_POST[no_agenda] gagal!</div>";
        }
        
    }

    public function input() {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        $tglagenda = date('Y-m-d');
        $asal = trim($_POST['asal_surat']);
        $asal = explode(' ', $asal);
        $start = date('Y-m-d h:m:s');
        /*$this->model->setAgenda($_POST['no_agenda']);
        $this->model->setTglTerima($tglagenda);
        $this->model->setTglSurat(Tanggal::ubahFormatTanggal($_POST['tgl_surat']));
        $this->model->setNomor($_POST['no_surat']);
        $this->model->setAlamat($asal[0]);
        $this->model->setPerihal($_POST['perihal']);
        $this->model->setSifat($_POST['sifat']);
        $this->model->setJenis($_POST['jenis']);
        $this->model->setStatusSurat($_POST['status']);
        $this->model->setJmlLampiran($_POST['lampiran']);
        $this->model->setStatus('11');
        $this->model->setStart($start);*/
        $data = array(
            "no_agenda"=>$_POST['no_agenda'],
            "tgl_terima"=> $tglagenda,
            "tgl_surat"=>  Tanggal::ubahFormatTanggal($_POST['tgl_surat']),
            "no_surat"=>$_POST['no_surat'],
            "asal_surat"=>$asal[0],
            "perihal"=>$_POST['perihal'],            
            "status"=>$_POST['status'],
            "sifat"=>$_POST['sifat'],
            "jenis"=>$_POST['jenis'],
            "lampiran"=>$_POST['lampiran'],
            "stat"=>'11',
            "start"=>$start
        );
        if( $this->model->input($data)){
            $notif = new Notifikasi();
            $datakk = $this->model->select("SELECT id_user FROM user WHERE role=1 AND bagian =1 AND active='Y'");
            foreach($datakk as $val){
                $notif->set('id_user',$val['id_user']);
            }
            $notif->set('id_surat',$this->model->lastIdInsert());
            $notif->set('jenis_surat','SM');
            $notif->set('role',1);
            $notif->set('bagian',1);
            $notif->set('stat_notif',1);
            //$data1 =array(
                //'id_surat'=>$id_surat,
                //'jenis_surat'=>$jenis_surat,
                //'id_user'=>$kk,
                //'stat_notif'=>$stat_notif
            //);
            //var_dump($data1);
            $notif->addNotifikasi();
            @Session::createSession();
            $user = Session::get('user');
            $log = new Log();
            $log->addLog($user,'REKAM SM','user '.$user.' rekam surat masuk agenda '.$_POST['no_agenda']);
            unset($log);
//            die($this->msg(1,"rekam data berhasil"));
            echo "<div id=success>rekam data berhasil</div>";
//            $this->view->agenda = $this->nomor->generateNumber('SM');
//            $this->view->success = 'rekam data berhasil';
//            $this->view->render('suratmasuk/rekam');
        }else{
            echo "<div id=error>rekam data gagal</div>";
//            die($this->msg(1,"rekam data tidak berhasil"));
//            $this->view->agenda = $this->nomor->generateNumber('SM');
//            $this->view->error = 'rekam data tidak berhasil';
//            $this->view->render('suratmasuk/rekam');
        }
        
        
       
        //header('location:'.URL.'suratmasuk');
    }
    
    public function msg($status,$txt){
            return '{status:'.$status.',txt:"'.$txt.'"}';
        }
        
    public function rekam($s = null) {
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if (!is_null($s)) {

            $this->view->alamat = $s;
            $almt = new Admin_Model();
            $alamat = $almt->getAlamat($s);            
            //$this->view->alamat
            
            foreach ($alamat as $value) {
                $this->view->alamat .= ' ' . $value['nama_satker'];
            }
        }
        $this->view->sifat = $this->model->get('sifat_surat');
            $this->view->jenis = $this->model->get('klasifikasi_surat');
        $this->view->agenda = $this->nomor->generateNumber('SM');
        $this->view->render('suratmasuk/rekam');
    }

    public function detil($id) {
        $agenda = substr($id, 0, 1);
        $disposisi = new Disposisi();
        if($agenda != 'S'){
            $data = $this->model->getSuratById($id);
            $this->view->data[0] = $this->model->getId();
            $this->view->data[1] = $this->model->getAgenda();
            $this->view->data[2] = $this->model->getTglTerima();
            $this->view->data[3] = $this->model->getTglSurat();
            $this->view->data[4] = $this->model->getNomor();
            $this->view->data[5] = $this->model->getAlamat();
            $this->view->data[6] = $this->model->getPerihal();
            $this->view->data[7] = $this->model->getFile();
            $this->view->dataSurat = array();
            $this->view->dataSurat[] = $this->view->data;            
        }else{
            $param = array('no_agenda'=>$id);
            $data = $this->model->getSuratById($param);
            $this->view->data[0] = $this->model->getId();            
            $this->view->data[1] = $this->model->getAgenda();
            $this->view->data[2] = $this->model->getTglTerima();
            $this->view->data[3] = $this->model->getTglSurat();
            $this->view->data[4] = $this->model->getNomor();
            $this->view->data[5] = $this->model->getAlamat();
            $this->view->data[6] = $this->model->getPerihal();
            $this->view->data[7] = $this->model->getFile();
            $this->view->dataSurat = array();
            $this->view->dataSurat[] = $this->view->data;
        }
        $this->view->ddisp = $disposisi->getDisposisi(array('id_surat'=>$this->view->data[0]));
        $id_disp = $disposisi->id_disposisi;
        $bagian = Session::get('bagian');
        $this->view->ddispkasi = $disposisi->getDisposisiKasi($id_disp,$bagian);
        $lamp = new Lampiran_Model();
        $this->view->lampiran = $lamp->getLampiranSurat($this->view->data[0], 'SM');
        $this->view->count = count($this->view->lampiran);
        /*
         * hapus notifikasi
         */
        $notif = new Notifikasi();
        $id_user = 0;
        $user = Session::get('user');
        $sql = "SELECT id_user FROM user WHERE username=:user";
        $param = array(':user'=>$user);
        $data = $this->model->select($sql, $param);
        //var_dump($data);
        foreach($data as $val){
            $id_user = $val['id_user'];
        }
        $sql = "SELECT id_notif FROM notifikasi WHERE id_user=:id_user AND id_surat=:id_surat AND jenis_surat=:jenis";
        $param = array(':id_user'=>$id_user, ':id_surat'=>$id, ':jenis'=>'SM');
        $data = $this->model->select($sql, $param);
        foreach ($data as $val){
            $notif->set('id_notif', $val['id_notif']);
            $notif->set('stat_notif', 0);
            $notif->setNotif();
        }
        
        //render tampilan
        $this->view->render('suratmasuk/detilsurat');
    }

    public function disposisi($id) {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
            if($this->rekamdisposisi()){
                $this->view->success="Rekam disposisi berhasil";
            }else{
                $this->view->error="Rekam disposisi gagal!";
            }
        }
        $this->model->getSuratById($id);

//        foreach ($data as $value) {
            $this->view->data['id_suratmasuk'] = $this->model->getId();
            $this->view->data['no_surat'] = $this->model->getNomor();
            $this->view->data['status'] = $this->model->getStatusSurat();
            $this->view->data['tgl_terima'] = Tanggal::tgl_indo($this->model->getTglTerima());
            $this->view->data['tgl_surat'] = Tanggal::tgl_indo($this->model->getTglSurat());            
            $this->view->data['no_agenda'] = $this->model->getAgenda();
            $this->view->data['lampiran'] = $this->model->getjmlLampiran();
            $sql = "SELECT sifat_surat FROM sifat_surat WHERE kode_sifat ='" . $this->model->getSifat()."'";
            
            $sifat = $this->model->select($sql);
            
            foreach ($sifat as $value2) {
                $this->view->data['sifat'] = $value2['sifat_surat'];
            }
            $sql2 = "SELECT klasifikasi FROM klasifikasi_surat WHERE kode_klassurat ='" . $this->model->getJenis()."'";
            $jenis = $this->model->select($sql2);
            foreach ($jenis as $value3) {
                $this->view->data['jenis'] = $value3['klasifikasi']; 
            }
            $sql3 = 'SELECT nama_satker FROM alamat WHERE kode_satker=' . trim($this->model->getAlamat());
            $asal = $this->model->select($sql3);            
            foreach ($asal as $value1) {
                $this->view->data['asal_surat'] = $value1['nama_satker'];
            }
            
            $this->view->data['perihal'] = $this->model->getPerihal();
//        }
        $this->view->seksi = $this->model->get('r_bagian');
        $this->view->petunjuk = $this->model->get('r_petunjuk');
//        $this->view->data2 = $this->model->select('SELECT * FROM disposisi WHERE id_surat=' . $id);
        $disposisi = new Disposisi();
        $this->view->data2 = $disposisi->getDisposisi(array('id_surat'=>$id));
        $this->view->count = count($this->view->data2);
        //echo $this->view->count;
//        var_dump($this->view->petunjuk);
        if ($this->view->count > 0) {

//            foreach ($this->view->data2 as $key => $value) {
                $this->view->disp[0] = $this->view->data2->id_disposisi;
                $this->view->disp[1] = $this->view->data2->id_surat;
                $this->view->disp[2] = $this->view->data2->sifat;
                $this->view->disp[3] = $this->view->data2->dist;
                $this->view->disp[4] = $this->view->data2->petunjuk;
                $this->view->disp[5] = $this->view->data2->catatan;
//            }
            $this->view->disposisi = $this->view->disp[3]; //explode(',', $this->view->disp[3]);
            $this->view->petunjuk2 = $this->view->disp[4]; //explode(',', $this->view->disp[4]);
//            var_dump($this->view->petunjuk2);
//            var_dump($this->view->disp);
            //$this->view->render('suratmasuk/disposisi');
        } 
            $this->view->render('suratmasuk/disposisi');
       
    }
    
    //sepertinya sama dengan method sebelumnya
    public function ctkDisposisi($id) {
        $disposisi = new Disposisi();
        $this->view->darray = array();
//        $arrayid = explode(",", $id);
        if(is_array($id)){
            $count = count($id);
//            var_dump($id);
//            var_dump($count);
            $this->view->array = true;            
            for($i=0;$i<$count;$i++){
//                var_dump($i);
//                var_dump($id[$i]);
                $this->model->getSuratById($id[$i]);

//                foreach ($datas as $value) {
                    $this->view->data[$i]['id_suratmasuk'] = $this->model->getId();
                    $this->view->data[$i]['no_surat'] = $this->model->getNomor();
                    $this->view->data[$i]['status'] = $this->model->getStatusSurat();
                    $this->view->data[$i]['tgl_terima'] = Tanggal::tgl_indo($this->model->getTglTerima());
                    $this->view->data[$i]['tgl_surat'] = Tanggal::tgl_indo($this->model->getTglSurat());
                    $sql = 'SELECT sifat_surat FROM sifat_surat WHERE kode_sifat ="' . trim($this->model->getSifat().'"');
                    $sifat = $this->model->select($sql);
                    foreach ($sifat as $value1) {
                        $this->view->data[$i]['sifat'] = $value1['sifat_surat'];
                    }
//                    $this->view->data[$i]['sifat'] = $value['sifat'];
                    $this->view->data[$i]['no_agenda'] = $this->model->getAgenda();
                    $this->view->data[$i]['lampiran'] = $this->model->getjmlLampiran();
                    $sql = 'SELECT klasifikasi FROM klasifikasi_surat WHERE kode_klassurat ="' . trim($this->model->getJenis().'"');
                    $klas = $this->model->select($sql);
                    foreach ($klas as $value1) {
                        $this->view->data[$i]['jenis'] = $value1['klasifikasi'];
                    }
//                    $this->view->data[$i]['jenis'] = $value['jenis'];
                    $sql = 'SELECT nama_satker FROM alamat WHERE kode_satker=' . trim($this->model->getAlamat());
                    $asal = $this->model->select($sql);
                    foreach ($asal as $value1) {
                        $this->view->data[$i]['asal_surat'] = $value1['nama_satker'];
                    }
                    $this->view->data[$i]['perihal'] = $this->model->getPerihal();
//                }
                $datad = $disposisi->getDisposisi(array('id_surat' => $id[$i]));
                $countd = count($datad);
                if ($countd > 0) {
                        $this->view->disp[$i][0] = $datad->id_disposisi;
                        $this->view->disp[$i][1] = $datad->id_surat;
                        $this->view->disp[$i][2] = $datad->sifat;
                        $this->view->disp[$i][3] = $datad->dist;
                        $this->view->disp[$i][4] = $datad->petunjuk;
                        $this->view->disp[$i][5] = $datad->catatan;
                }
            }
            include_once 'views/suratmasuk/disposisisurat.php';
        }else{
            $datas = $this->model->getSuratById($id);
                $this->view->data[0]['id_suratmasuk'] = $this->model->getId();
                $this->view->data[0]['no_surat'] = $this->model->getNomor();
                $this->view->data[0]['status'] = $this->model->getStatusSurat();
                $this->view->data[0]['tgl_terima'] = Tanggal::tgl_indo($this->model->getTglTerima());
                $this->view->data[0]['tgl_surat'] = Tanggal::tgl_indo($this->model->getTglSurat());
                $sql = 'SELECT sifat_surat FROM sifat_surat WHERE kode_sifat ="' . trim($this->model->getSifat().'"');
                $sifat = $this->model->select($sql);
                foreach ($sifat as $value1) {
                    $this->view->data[0]['sifat'] = $value1['sifat_surat'];
                }
//                $this->view->data[0]['sifat'] = $value['sifat'];
                $this->view->data[0]['no_agenda'] = $this->model->getAgenda();
                $this->view->data[0]['lampiran'] = $this->model->getJmlLampiran();
                $sql = 'SELECT klasifikasi FROM klasifikasi_surat WHERE kode_klassurat ="' . trim($this->model->getJenis().'"');
                $klas = $this->model->select($sql);
                foreach ($klas as $value1) {
                    $this->view->data[0]['jenis'] = $value1['klasifikasi'];
                }
//                $this->view->data[0]['jenis'] = $value['jenis'];
                $sql = 'SELECT nama_satker FROM alamat WHERE kode_satker=' . trim($this->model->getAlamat());
                $asal = $this->model->select($sql);
                foreach ($asal as $value1) {
                    $this->view->data[0]['asal_surat'] = $value1['nama_satker'];
                }
                $this->view->data[0]['perihal'] = $this->model->getPerihal();
//            }
            $datad = $disposisi->getDisposisi(array('id_surat' => $id));
            $count = count($datad);
            //var_dump($count);
            if ($count > 0) {
                    $this->view->disp[0][0] = $datad->id_disposisi;
                    $this->view->disp[0][1] = $datad->id_surat;
                    $this->view->disp[0][2] = $datad->sifat;
                    $this->view->disp[0][3] = $datad->dist;
                    $this->view->disp[0][4] = $datad->petunjuk;
                    $this->view->disp[0][5] = $datad->catatan;
            }
            include_once('views/suratmasuk/disposisisurat.php');
        }
        
    }
    
    public function disposisix($id){
        $x = trim($id,',');
        $x=  explode(",", $id);
//        var_dump($x);
        $this->ctkDisposisi($x);
                
    }

    public function rekamdisposisi() {
        $id_surat = $_POST['id_surat'];
        $sifat = $_POST['sifat'];
        $petunjuk = $_POST['petunjuk'];
        $catatan = $_POST['catatan'];
        $disposisi = $_POST['disposisi'];
//        $disp = implode(',',$disposisi);
//        $petunjuk = implode(',',$petunjuk);
        
        $data = array(
            'id_surat'=>$id_surat,
            'sifat'=>$sifat,
            'disposisi'=>$disposisi,
            'petunjuk'=>$petunjuk,
            'catatan'=>$catatan
            );
        $dispos = new Disposisi();
        $rekam = $dispos->addDisposisi($data);
//        $rekam = $this->model->rekamdisposisi($data);
        //var_dump($rekam);
        if(!$rekam){ //baris ini berhasil
            $this->view->error = "data tidak berhasil disimpan!";
            echo "<div id=error>Rekam disposisi surat masuk  gagal!</div>";
            
        }else{
            $this->model->distribusi($id_surat, $disposisi); 
            $notif = new Notifikasi();
            $notif->set('id_surat', $id_surat);
            $notif->set('jenis_surat', 'SM');
            $notif->set('stat_notif', 1);
            $len = count($disposisi);
            //echo $len;
            //foreach ($disposisi as $val){
            for($i=0;$i<$len;$i++){
                echo $disposisi[$i];
                $sql = "SELECT id_bagian FROM r_bagian WHERE kd_bagian='".$disposisi[$i]."'";
                $data = $this->model->select($sql);
                //var_dump($data);
                foreach($data as $value){
                    $id_bagian = $value['id_bagian'];
                    $sql1 = "SELECT id_user FROM user WHERE bagian=$id_bagian AND role=2";
                    $data1 = $this->model->select($sql1);
                    //var_dump($data1);
                    foreach($data1 as $value1){
                        $id_user = $value1['id_user'];                        
                        $notif->set('id_user', $id_user);
                        $notif->set('role', 2);
                        $notif->set('bagian', $id_bagian);
                        $notif->addNotifikasi(); //notifikasi kasi
                    }
                }
            }
            $datastat = array('stat'=>'12');
            $where = 'id_suratmasuk='.$id_surat;
            @Session::createSession();
            $user = Session::get('user');
            $log = new Log();
            $log->addLog($user,'REKAM DISPOSISI','user '.$user.' rekam disposisi no agenda '.$this->model->getNomorAgenda($id_surat));
            unset($log);
            $this->model->update('suratmasuk',$datastat,$where); //update status -> disposisi
//            header('location:'.URL.'suratmasuk');
            echo "<div id=success>Rekam disposisi surat masuk  berhasil</div>";
        }
        
//        return true;
        
    }
    
    public function ubahdisposisi() {
        $id_disp = $_POST['id_disposisi'];
        $id_surat = $_POST['id_surat'];
        $sifat = $_POST['sifat'];
        $petunjuk = $_POST['petunjuk'];
        $catatan = $_POST['catatan'];
        $disposisi = $_POST['disposisi'];
        $data = array(
            'id_surat'=>$id_surat,
            'sifat'=>$sifat,
            'disposisi'=>$disposisi,
            'petunjuk'=>$petunjuk,
            'catatan'=>$catatan
            );
        $where = ' id_disposisi='.$id_disp;
        $dispos = new Disposisi();
        $edit = $dispos->editDisposisi($data, $where);
        if(!$edit){ //baris ini berhasil
            $this->view->error = "data tidak berhasil disimpan!";
            echo "<div id=error>Ubah disposisi surat masuk  no agenda ".$this->model->getNomorAgenda($id_surat)." gagal!</div>";
            
        }else{
            $where = ' id_surat='.$id_surat;
            $this->model->delete('distribusi', $where); //menghapus catatan distribusi lama
            $this->model->distribusi($id_surat, $disposisi); 
            $notif = new Notifikasi();
            $notif->delete('notifikasi', ' id_surat='.$id_surat.' AND jenis_surat="SM"'); //menghapus notifikasi lama
            $notif->set('id_surat', $id_surat);
            $notif->set('jenis_surat', 'SM');
            $notif->set('stat_notif', 1);
            if(!is_array($disposisi)) $disposisi = explode (",", $disposisi);
            $len = count($disposisi);
            for($i=0;$i<$len;$i++){
                echo $disposisi[$i];
                $sql = "SELECT id_bagian FROM r_bagian WHERE kd_bagian='".$disposisi[$i]."'";
                $data = $this->model->select($sql);
                //var_dump($data);
                foreach($data as $value){
                    $id_bagian = $value['id_bagian'];
                    $sql1 = "SELECT id_user FROM user WHERE bagian=$id_bagian AND role=2";
                    $data1 = $this->model->select($sql1);
                    //var_dump($data1);
                    foreach($data1 as $value1){
                        $id_user = $value1['id_user'];                        
                        $notif->set('id_user', $id_user);
                        $notif->set('role', 2);
                        $notif->set('bagian', $id_bagian);
                        $notif->addNotifikasi(); //notifikasi kasi
                    }
                }
            }
            $datastat = array('stat'=>'12');
            $where = 'id_suratmasuk='.$id_surat;
            @Session::createSession();
            $user = Session::get('user');
            $log = new Log();
            $log->addLog($user,'UBAH DISPOSISI','user '.$user.' rekam disposisi no agenda '.$this->model->getNomorAgenda($id_surat));
            unset($log);
            $this->model->update('suratmasuk',$datastat,$where); //update status -> disposisi
            echo "<div id=success>Ubah disposisi surat masuk  no agenda ".$this->model->getNomorAgenda($id_surat)." berhasil</div>";
        }
        
    }

    public function distribusi($id) {
        $this->view->dataSurat = $this->model->select('SELECT * FROM suratmasuk WHERE id_suratmasuk=' . $id);
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');

        foreach ($this->view->dataSurat as $value) {
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_surat'];
            $this->view->data[2] = $value['perihal'];
            $this->view->data[3] = $value['asal_surat'];
        }
        $this->view->render('suratmasuk/distribusi');
    }

    public function rekamDistribusi() {
        $id = $_POST['id'];
        $bagian = $_POST['bagian'];
        //var_dump($bagian);
        $this->model->distribusi($id, $bagian);
    }
    
    public function rekamCatatan(){
        $disposisi = new Disposisi();
        $id_surat = $_POST['id_surat'];
        $id_disposisi = $_POST['id_disp'];
        $bagian = $_POST['bagian'];
        $peg = $_POST['peg'];
        $catatan = $_POST['catatan'];        
        $data = array('id_disposisi'=>$id_disposisi,
            'bagian'=>$bagian,
            'pelaksana'=>$peg,
            'catatan'=>$catatan,
            'time'=>date('Y-m-d H:i:s'));
        
        //var_dump($data);
        $disposisi->addDisposisiKasi($data);
        $notif = new Notifikasi();        
        $notif->set('id_surat', $id_surat);
        $notif->set('jenis_surat', 'SM');
        $notif->set('id_user', $peg);
        $notif->set('stat_notif',1);
        $notif->set('role', 3);
        $notif->set('bagian',Session::get('bagian'));
        $notif->addNotifikasi(); //notifikasi pelaksana
        $datastat = array('stat'=>'13');
        $where = 'id_suratmasuk='.$id_surat;
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'REKAM CATATAN KASI','user '.$user.' rekam catatan kasi no agenda '.$this->model->getNomorAgenda($id_surat));
        unset($log);
        if($this->model->update('suratmasuk',$datastat,$where)){ //update status surat -> disposisi kasi
            echo "<div id=success>Rekam disposisi Pj Eselon IV berhasil!</div>";
        }  else {
            echo "<div id=error>Rekam disposisi Pj Eselon IV gagal!</div>";
        }
        //$this->model->insert('catatan',$data);
//        header('location:'.URL.'suratmasuk');
        return true;
    }
    
    public function catatan($id){
        if(!Auth::isAllow(2, Session::get('role'))){
            header('location:'.URL.'home');
        }
        if(isset($_POST['submit'])){
        
            if($this->rekamCatatan()){
                $this->view->success="Rekam catatan berhasil";
            }else{
                $this->view->error="Rekam catatan gagal";
            }
        }
        $disposisi = new Disposisi();
        $this->view->datad = $disposisi->getDisposisi(array('id_surat'=>$id));      
        //$this->view->bagian = $this->view->datad->dist[0];
        $sql = "SELECT kd_bagian FROM r_bagian WHERE id_bagian=".Session::get('bagian');
        $bagian = $this->model->select($sql);
        foreach ($bagian as $val){
            $this->view->bagian = $val['kd_bagian'];
        }
        //dibawah ini bisa pake getSuratById
        $datas = $this->model->select("SELECT * FROM suratmasuk WHERE id_suratmasuk=".$this->view->datad->id_surat);
        foreach($datas as $value){
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_agenda'];
            $this->view->data[2] = $value['no_surat'];
            $asal = $this->model->select('SELECT nama_satker FROM alamat WHERE kode_satker='.trim($value['asal_surat']));
                foreach($asal as $alamat){
                    $this->view->data[3] = $alamat['nama_satker'];
                }
            $this->view->data[4] = $value['perihal'];
        }
        $sql ="SELECT id_user, namaPegawai FROM user WHERE jabatan = 6 AND bagian = ".Session::get('bagian');
        $this->view->peg = $this->model->select($sql);
        //var_dump($this->view->peg);
        $this->view->render('suratmasuk/catatan');
    }
    
    public function ctkEkspedisi(){
        $eks = new EkspedisiSurat();
//        $id = $this->model->select("SELECT id_suratmasuk FROM suratmasuk");
        $this->view->data = $eks->displayEkspedisi();
//        $this->view->data = $this->model->showAll();
        
        $this->view->load('suratmasuk/expedisi');
    }
    
    public function upload($id){
        if(!Auth::isAllow(5, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(3, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        if(isset($_POST['submit'])){
            if($this->uploadFileSurat()){
                $this->view->success='Upload berhasil';
            }else{
                $this->view->error='Upload gagal';
            }
        }
        
        $this->model->getSuratById($id);
//        foreach ($data as $value){
            $this->view->id = $this->model->getId();
            $this->view->no_surat = $this->model->getNomor();
            $this->view->no_agenda = $this->model->getAgenda();
            $this->view->tgl_surat = $this->model->getTglSurat();
            $this->view->satker = $this->model->getAlamat();
//        }
        
        $this->view->render('suratmasuk/upload');
    }
    public function uploadFileSurat(){
        $upload = new Upload('upload');
        $upload->setDirTo('arsip/');
        $tipe='M';
        $satker = $_POST['satker'];
        $nomor = $_POST['nomor'];
        //nama baru akan terdiri dari tipe naskah_nomor surat_asal(asal/tetapi asal terlaku kepanjangan)
        $ubahNama = array($tipe,$nomor,$satker);
        $upload->setUbahNama($ubahNama);
        $upload->changeFileName($upload->getFileName(), $ubahNama);
        $namafile = $upload->getFileTo();
        $where = ' id_suratmasuk='.$_POST['id'];
        $data = array(
            'file'=>$namafile
        );
        if($upload->uploadFile()){
        $this->model->uploadFile($data,$where);
        $datastat = array('stat'=>'14');
        @Session::createSession();
        $user = Session::get('user');
        $log = new Log();
        $log->addLog($user,'UPLOAD','user '.$user.' upload file surat no agenda '.$this->model->getNomorAgenda($_POST['id']).' file:'.$namafile);
        unset($log);
        $this->model->update('suratmasuk',$datastat,$where); //update status -> pelaksana
        echo "<div id=success>Upload file berhasil</div>";
        }else{
            echo "<div id=error>Upload file berhasil</div>";
        }
//        return true;
        //header('location:'.URL.'suratmasuk');
        
    }
    
    public function view($id){
        $data = $this->model->getSuratById($id);        
        $this->view->file = $data->getFile();
        $this->view->load('suratmasuk/viewsurat');
    }
    
    public function number(){
        $nomor = new Nomor();
        echo $nomor->generateNumber('SM');
    }
    

}

?>
