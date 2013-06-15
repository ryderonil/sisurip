<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * rencananya filter selain kategori dokumen juga tanggal in:date tglawal tglakhir
 * pencarian sebelumnya dengan mengkonversi database suratmasuk, suratkeluar dan lampiran ke dalam list
 * dengan penunjuk id, jenis surat, 
 */

class Cari_Controller extends Controller {

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama();
        $this->view->js = array(
            'cari/js/default',
            'suratkeluar/js/jquery.tipTip',
            'suratkeluar/js/jquery.tipTip.minified'
        );
    }

    public function index() {
        $this->view->render('cari/cari');
    }

    public function find() {
//        $keyword = $_POST['queryString'];
//        $this->model->splitKeyword($keyword);
        $keyword = $_POST['keyword'];
        $category = $_POST['category'];
        $before = $_POST['before'];
        $after = $_POST['after'];
        
        $this->model->keyword = $keyword;
        $this->view->keyword = $this->model->keyword;
        if($category!='') $this->model->filter=$category;
        if($after!='') $this->model->after = Tanggal::ubahFormatTanggal ($after);
        if($before!='') $this->model->before = Tanggal::ubahFormatTanggal ($before);
        $count = 0;
        if ($this->model->filter != null) {
            if ($this->model->filter == "suratmasuk") {
                $this->view->hasil = $this->model->findSuratMasuk($this->model->keyword);
                $this->view->count = count($this->view->hasil);
                $this->view->load('cari/hasilcari');
            } elseif ($this->model->filter == "suratkeluar") {
                $this->view->hasil = $this->model->findSuratKeluar($this->model->keyword);
                $this->view->count = count($this->view->hasil);
                $this->view->load('cari/hasilcari');
            } elseif ($this->model->filter == "lampiran") {
                $this->view->hasil = $this->model->findLampiran($this->model->keyword);
                $this->view->count = count($this->view->hasil);
                $this->view->load('cari/hasilcari');
            } elseif ($this->model->filter == "all") {
                $hasil1 = $this->model->findSuratMasuk($this->model->keyword);
                $hasil2 = $this->model->findSuratKeluar($this->model->keyword);
                $hasil3 = $this->model->findLampiran($this->model->keyword);
                $this->view->hasil = array_merge($hasil1, $hasil2, $hasil3);
                $this->view->count = count($this->view->hasil);
                $this->view->load('cari/hasilcari');
            } else if ($this->model->filter == "nomor") {
                $this->view->hasil = $this->model->findByNomor();
                $this->view->count = count($this->view->hasil);
                $this->view->load('cari/hasilcari');
            }else if ($this->model->filter == "alamat") {
                $this->view->hasil = $this->model->findByAlamat();
                $this->view->count = count($this->view->hasil);
                $this->view->load('cari/hasilcari');
            }
        } else if ($this->model->filter == null AND $this->model->before != null AND $this->model->after != null) {
            $this->view->hasil = $this->model->findByDate();
            $this->view->count = count($this->view->hasil);
            $this->view->load('cari/hasilcari');
        }
    }
    
    function __destruct() {
        ;
    }

}

?>
