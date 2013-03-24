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
            'suratkeluar/js/default'
        );
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }

    //put your code here

    public function index() {
        $this->showAll();
    }

    public function showAll() {
        $this->view->data = $this->model->showAll();
        $this->view->render('suratkeluar/suratkeluar');
    }

    public function rekam($id_sm = null, $ids = null) {
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
                    $datasm = $this->model->select('SELECT id_suratmasuk, no_agenda, no_surat FROM suratmasuk WHERE id_suratmasuk=' . $ids);
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

        $data = array(
            'rujukan' => $_POST['rujukan'],
            'no_surat' => $_POST['nomor'],
            'tgl_surat' => Tanggal::ubahFormatTanggal($_POST['tgl_surat']),
            'tujuan' => substr($_POST['tujuan'],0,6),
            'perihal' => $_POST['perihal'],
            'sifat' => $_POST['sifat'],
            'jenis' => $_POST['jenis'],
            'lampiran' => $_POST['lampiran'],
            'file' => $_POST['upload'], //belum ditangani
            'status' => '1'
        );
        
        //var_dump($data);
        $this->model->rekamSurat($data);
    }
    
    public function detil($id){
        $data = $this->model->getSuratKeluarById($id);
        foreach($data as $value){
            $this->view->id = $value['id_suratkeluar'];
            $this->view->rujukan = $value['rujukan'];
            $this->view->tipe = $value['tipe'];
            $this->view->no_surat = $value['no_surat'];
            $this->view->tgl_surat = $value['tgl_surat'];
            $this->view->tujuan = $value['tujuan'];
            $this->view->perihal = $value['perihal'];
            $this->view->sifat = $value['sifat'];
            $this->view->jenis = $value['jenis'];
            $this->view->lampiran = $value['lampiran'];
            $this->view->file = $value['file'];
            $this->view->status = $value['status'];
        }
        $this->view->count=0;
        
        $this->view->render('suratkeluar/detilsurat');
    }

}

?>
