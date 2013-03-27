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
            'suratmasuk/js/default'
        );
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }

    //put your code here

    public function index() {
        //$this->view->render('suratmasuk/index');
        //header('location:'.URL.'suratmasuk/showall');
        $this->showAll();
    }

    public function showAll() {

        $this->view->listSurat = $this->model->showAll();

        $this->view->render('suratmasuk/suratmasuk');
    }

    public function edit($id_sm = null, $ids = null) {
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
                    $this->view->data = $this->model->getSuratMasukById($ids);
                    $this->view->sifat = $this->model->get('sifat_surat');
                    $this->view->jenis = $this->model->get('klasifikasi_surat');
                    //var_dump($this->view->jenis);
                }
            } else {


                $this->view->data = $this->model->getSuratMasukById($id_sm);
                $this->view->sifat=$this->model->get('sifat_surat');
                $this->view->jenis=$this->model->get('klasifikasi_surat');
                //var_dump($this->view->jenis);
            }
        }
        /** **/
        //$this->view->data = $this->model->getSuratMasukById($ids);
        $this->view->render('suratmasuk/ubah');
    }

    public function remove($id) {
        $this->model->remove($id);
    }

    public function editSurat() {
        $this->model->editSurat();
    }

    public function input() {
        $tglagenda = date('Y-m-d');
        $asal = trim($_POST['asal_surat']);
        $asal = explode(' ', $asal);
        $start = date('Y-m-d h:m:s');
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
            "stat"=>'1',
            "start"=>$start
        );
        if( $this->model->input($data)){
            $this->view->error = 'rekam data tidak berhasil';
            $this->view->render('suratmasuk/rekam');
        }else{
            $notif = new Notifikasi();
            $datakk = $this->model->select("SELECT id_user FROM user WHERE role=1 AND bagian =1 AND active='Y'");
            foreach($datakk as $val){
                $notif->set('id_user',$val['id_user']);
            }
            $notif->set('id_surat',$this->model->lastIdInsert());
            $notif->set('jenis_surat','SM');
            $notif->set('stat_notif',1);
            //$data1 =array(
                //'id_surat'=>$id_surat,
                //'jenis_surat'=>$jenis_surat,
                //'id_user'=>$kk,
                //'stat_notif'=>$stat_notif
            //);
            //var_dump($data1);
            $notif->addNotifikasi();
            $this->view->success = 'rekam data berhasil';
            $this->view->render('suratmasuk/rekam');
        }
       
        //header('location:'.URL.'suratmasuk');
    }

    public function rekam($s = null) {
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
        $this->view->dataSurat = $this->model->getSuratMasukById($id);
        foreach ($this->view->dataSurat as $key => $value) {
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_agenda'];
            $this->view->data[2] = $value['tgl_terima'];
            $this->view->data[3] = $value['tgl_surat'];
            $this->view->data[4] = $value['no_surat'];
            $this->view->data[5] = $value['asal_surat'];
            $this->view->data[6] = $value['perihal'];
            $this->view->data[7] = $value['file'];
        }
        $lamp = new Lampiran_Model();
        $this->view->lampiran = $lamp->getLampiranSurat($this->view->data[0]);
        $this->view->count = count($this->view->lampiran);
        $this->view->render('suratmasuk/detilsurat');
    }

    public function disposisi($id) {
        $data = $this->model->getSuratMasukById($id);

        foreach ($data as $value) {
            $this->view->data['id_suratmasuk'] = $value['id_suratmasuk'];
            $this->view->data['no_surat'] = $value['no_surat'];
            $this->view->data['status'] = $value['status'];
            $this->view->data['tgl_terima'] = Tanggal::tgl_indo($value['tgl_terima']);
            $this->view->data['tgl_surat'] = Tanggal::tgl_indo($value['tgl_surat']);            
            $this->view->data['no_agenda'] = $value['no_agenda'];
            $this->view->data['lampiran'] = $value['lampiran'];
            $sql = "SELECT sifat_surat FROM sifat_surat WHERE kode_sifat ='" . $value['sifat']."'";
            
            $sifat = $this->model->select($sql);
            
            foreach ($sifat as $value2) {
                $this->view->data['sifat'] = $value2['sifat_surat'];
            }
            $sql2 = "SELECT klasifikasi FROM klasifikasi_surat WHERE kode_klassurat ='" . $value['jenis']."'";
            $jenis = $this->model->select($sql2);
            foreach ($jenis as $value3) {
                $this->view->data['jenis'] = $value3['klasifikasi']; 
            }
            $sql3 = 'SELECT nama_satker FROM alamat WHERE kode_satker=' . trim($value['asal_surat']);
            $asal = $this->model->select($sql3);            
            foreach ($asal as $value1) {
                $this->view->data['asal_surat'] = $value1['nama_satker'];
            }
            
            $this->view->data['perihal'] = $value['perihal'];
        }
        $this->view->seksi = $this->model->get('r_bagian');
        $this->view->petunjuk = $this->model->get('r_petunjuk');
        $this->view->data2 = $this->model->select('SELECT * FROM disposisi WHERE id_surat=' . $id);
        $this->view->count = count($this->view->data2);
        //echo $this->view->count;
        //var_dump($this->view->petunjuk);
        if ($this->view->count > 0) {

            foreach ($this->view->data2 as $key => $value) {
                $this->view->disp[0] = $value['id_disposisi'];
                $this->view->disp[1] = $value['id_surat'];
                $this->view->disp[2] = $value['sifat'];
                $this->view->disp[3] = $value['disposisi'];
                $this->view->disp[4] = $value['petunjuk'];
                $this->view->disp[5] = $value['catatan'];
            }
            $this->view->disposisi = explode(',', $this->view->disp[3]);
            $this->view->petunjuk2 = explode(',', $this->view->disp[4]);
            //var_dump($this->view->petunjuk2);

            //$this->view->render('suratmasuk/disposisi');
        } 
            $this->view->render('suratmasuk/disposisi');
       
    }
    
    //sepertinya sama dengan method sebelumnya
    public function ctkDisposisi($id) {
        $disposisi = new Disposisi();
        $datas = $this->model->getSuratMasukById($id);

        foreach ($datas as $value) {
            $this->view->data['id_suratmasuk'] = $value['id_suratmasuk'];
            $this->view->data['no_surat'] = $value['no_surat'];
            $this->view->data['status'] = $value['status'];
            $this->view->data['tgl_terima'] = Tanggal::tgl_indo($value['tgl_terima']);
            $this->view->data['tgl_surat'] = Tanggal::tgl_indo($value['tgl_surat']);
            $this->view->data['sifat'] = $value['sifat'];
            $this->view->data['no_agenda'] = $value['no_agenda'];
            $this->view->data['lampiran'] = $value['lampiran'];
            $this->view->data['jenis'] = $value['jenis'];
            $sql = 'SELECT nama_satker FROM alamat WHERE kode_satker=' . trim($value['asal_surat']);
            $asal = $this->model->select($sql);
            foreach ($asal as $value1) {
                $this->view->data['asal_surat'] = $value1['nama_satker'];
            }
            $this->view->data['perihal'] = $value['perihal'];
        }
        $datad = $disposisi->getDisposisi(array('id_surat' => $id));
        $count = count($datad);
        //var_dump($count);
        if ($count > 0) {
            
            //foreach ($datad as $value) {
                $this->view->disp[0] = $datad->id_disposisi;
                $this->view->disp[1] = $datad->id_surat;
                $this->view->disp[2] = $datad->sifat;
                $this->view->disp[3] = $datad->dist;
                $this->view->disp[4] = $datad->petunjuk;
                $this->view->disp[5] = $datad->catatan;
            //}
            //$this->view->disposisi = explode(',', $this->view->disp[3]);
            //$this->view->petunjuk = explode(',', $this->view->disp[4]);
        }
        //var_dump($datad);
        //var_dump($this->view->disp[4]);
        //$this->view->load('suratmasuk/disposisisurat.php');
        //$this->view->render('suratmasuk/ctkDisposisi');
        include_once('views/suratmasuk/disposisisurat.php');
    }

    public function rekamdisposisi() {
        $this->model->rekamdisposisi();
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
        $id_disposisi = $_POST['id_disp'];
        $bagian = $_POST['bagian'];
        $peg = $_POST['peg'];
        $catatan = $_POST['catatan'];
        $data = array('id_disposisi'=>$id_disposisi,
            'bagian'=>$bagian,
            'pelaksana'=>$peg,
            'catatan'=>$catatan);
        
        $disposisi->addDisposisi($data);
        //$this->model->insert('catatan',$data);
        header('location:'.URL.'suratmasuk');
    }
    
    public function catatan($id){
        $disposisi = new Disposisi();
        $this->view->datad = $disposisi->getDisposisi(array('id_surat'=>$id));
        //var_dump($this->view->data);
        //$bagian = explode($this->view->data->dist);
        //var_dump($bagian);
        $this->view->bagian = $this->view->datad->dist[0];
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
        $this->view->render('suratmasuk/catatan');
    }
    
    public function ctkEkspedisi(){
        $this->view->data = $this->model->showAll();
        
        $this->view->load('suratmasuk/expedisi.php');
    }
    
    public function upload($id){
        
        $data = $this->model->getSuratMasukById($id);
        foreach ($data as $value){
            $this->view->id = $value['id_suratmasuk'];
            $this->view->no_surat = $value['no_surat'];
            $this->view->no_agenda = $value['no_agenda'];
            $this->view->tgl_surat = $value['tgl_surat'];
            $this->view->satker = $value['asal_surat'];
        }
        
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
        $upload->uploadFile();
        $this->model->uploadFile($data,$where);
        header('location:'.URL.'suratmasuk');
        
    }
    
    

}

?>
