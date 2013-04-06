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
        $upload = new Upload('upload');
        $data = array(
            'rujukan' => $_POST['rujukan'],
            'no_surat' => $_POST['nomor'],
            'tipe' => $_POST['tipe'],
            'tgl_surat' => Tanggal::ubahFormatTanggal($_POST['tgl_surat']),
            'tujuan' => substr($_POST['tujuan'], 0, 6),
            'perihal' => $_POST['perihal'],
            'sifat' => $_POST['sifat'],
            'jenis' => $_POST['jenis'],
            'lampiran' => $_POST['lampiran'],
            'status' => '21'
        );

        //var_dump($data);       
        //upload file surat, sementara di temp folder krn belom dapat nomor
        $this->model->rekamSurat($data);
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
        $upload->uploadFile();
        $this->model->uploadFile($data, $where);
    }

    public function detil($id) {
        $data = $this->model->getSuratKeluarById($id, 'detil');
        foreach ($data as $value) {
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
        $this->view->count = 0;

        $this->view->render('suratkeluar/detilsurat');
    }

    public function edit($id_sk = null, $ids = null) {
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
                //echo $this->view->alamat;
                if (!is_null($ids)) {
                    $this->view->data = $this->model->getSuratKeluarById($ids, 'ubah');
                    $this->view->sifat = $this->model->get('sifat_surat');
                    $this->view->jenis = $this->model->get('klasifikasi_surat');
                    $this->view->tipe = $this->model->select('SELECT * FROM tipe_naskah');
                    //var_dump($this->view->jenis);
                }
            } else {


                $this->view->data = $this->model->getSuratKeluarById($id_sk, 'ubah');
                $this->view->sifat = $this->model->get('sifat_surat');
                $this->view->jenis = $this->model->get('klasifikasi_surat');
                $this->view->tipe = $this->model->select('SELECT * FROM tipe_naskah');
                //var_dump($this->view->jenis);
            }
        }

        foreach ($this->view->data as $value) {
            $this->view->id = $value['id_suratkeluar'];
            $this->view->tipe1 = $value['tipe'];
            $this->view->no_surat = $value['no_surat'];
            $this->view->tgl_surat = $value['tgl_surat'];
            $this->view->tujuan = $value['tujuan'];
            $this->view->perihal = $value['perihal'];
            $this->view->sifat1 = $value['sifat'];
            $this->view->jenis1 = $value['jenis'];
            $this->view->lampiran = $value['lampiran'];
            //$this->view->file = $value['file'];            
        }
        /**         * */
        //$this->view->data = $this->model->getSuratMasukById($ids);
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
        $this->model->editSurat($data, $where);
        header('location:' . URL . 'suratkeluar');
    }

    public function remove($id) {
        $where = ' id_suratkeluar=' . $id;
        $this->model->remove($where);
    }

    public function download($id) {
        // membaca informasi file dari tabel berdasarkan id nya        
        $datas = $this->model->getSuratKeluarById($id, 'ubah');
        foreach ($datas as $data) {
            // header yang menunjukkan nama file yang akan didownload
            header("Content-Disposition: attachment; filename=" . $data['file']);

            //header("Content-length: " . $data['size']);
            //header("Content-type: " . $data['type']);
            // proses membaca isi file yang akan didownload dari folder 'data'
            $fp = fopen("arsip/temp/" . $data['file'], 'r');
            $content = fread($fp, filesize('arsip/temp/' . $data['file']));
            fclose($fp);

            // menampilkan isi file yang akan didownload
            echo $content;
        }
        exit;
    }
    
    public function rekamrev($id){
        
        $this->view->data = $this->model->getSuratKeluarById($id, 'detil');
        
        $this->view->render('suratkeluar/revisi');
        
    }
    
    public function uploadrev(){
        $id = $_POST['id'];
        $catatan = $_POST['catatan'];
        $user = $_POST['user'];
        $time = date('Y-m-d H:i:s');
        $data = array(
            'id_surat'=>$id,
            'catatan'=>$catatan,
            'user'=>$user,
            'time'=>$time
        );
        
        $this->model->addRevisi($data);
        $filename ='';
        $datas = $this->model->getSuratKeluarById($id, 'detil');
        foreach ($datas as $val){
            $filename = $val['file'];
        }
        $upload = new Upload('upload');
        
        $upload->setDirTo('arsip/temp/');
        $upload->setFileTo($filename);        
        $upload->uploadFile();
        
    }

}

?>