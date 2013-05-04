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
        $keyword = $_POST['queryString'];
        $this->model->splitKeyword($keyword);
//        var_dump($this->model->filter);
//        var_dump($this->model->before);
//        var_dump($this->model->after);
        $count = 0;
        if ($this->model->filter != null) {
            if ($this->model->filter == "suratmasuk") {
                $hasil = $this->model->findSuratMasuk($this->model->keyword);
                $count = count($hasil);
                if ($count == 0) {
                    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
                } else {
                    $pesan = "Ditemukan : $count hasil pencarian dengan kata kunci " . $this->model->keyword;
                    echo "<table class=CSSTableGenerator><tr><td colspan=4 halign=left>$pesan</td></tr>";
                    foreach ($hasil as $val) {
                        echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td></tr>";
                    }
                    echo "</table>";
                }
            } elseif ($this->model->filter == "suratkeluar") {
                $hasil = $this->model->findSuratKeluar($this->model->keyword);
                $count = count($hasil);
                if ($count == 0) {
                    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
                } else {
                    $pesan = "Ditemukan : $count hasil pencarian dengan kata kunci " . $this->model->keyword;
                    echo "<table class=CSSTableGenerator><tr><td colspan=4 halign=left>$pesan</td></tr>";
                    foreach ($hasil as $val) {
                        echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td></tr>";
                    }
                    echo "</table>";
                }
            } elseif ($this->model->filter == "lampiran") {
                $hasil = $this->model->findLampiran($this->model->keyword);
                $count = count($hasil);
                if ($count == 0) {
                    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
                } else {
                    $pesan = "Ditemukan : $count hasil pencarian dengan kata kunci " . $this->model->keyword;
                    echo "<table class=CSSTableGenerator><tr><td colspan=4 halign=left>$pesan</td></tr>";
                    foreach ($hasil as $val) {
                        echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td></tr>";
                    }
                    echo "</table>";
                }
            } elseif ($this->model->filter == "all") {
                $hasil1 = $this->model->findSuratMasuk($this->model->keyword);
                $hasil2 = $this->model->findSuratKeluar($this->model->keyword);
                $hasil3 = $this->model->findLampiran($this->model->keyword);
                $hasil = array_merge($hasil1, $hasil2, $hasil3);
                $count = count($hasil);
                if ($count == 0) {
                    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
                } else {
                    $pesan = "Ditemukan : $count hasil pencarian dengan kata kunci " . $this->model->keyword;
                    //$hasil = array_merge($hasil2);
                    //$hasil = array_merge($hasil3);
                    //$data = var_dump($hasil);
                    echo "<table class=CSSTableGenerator><tr><td colspan=4 halign=left>$pesan</td></tr>";
                    foreach ($hasil as $val) {
                        echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td></tr>";
                    }
                    echo "</table>";
                }
            } else if ($this->model->filter = "nomor") {
                $hasil = $this->model->findByNomor();
                $count = count($hasil);
                if ($count == 0) {
                    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
                } else {
                    $pesan = "Ditemukan : $count hasil pencarian dengan kata kunci " . $this->model->keyword;
                    echo "<table class=CSSTableGenerator><tr><td colspan=5 halign=left>$pesan</td></tr>";
                    foreach ($hasil as $val) {
                        echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td><td>$val[4]</td></tr>";
                    }
                    echo "</table>";
                }
            }else if ($this->model->filter = "alamat") {
                $hasil = $this->model->findByAlamat();
                $count = count($hasil);
                if ($count == 0) {
                    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
                } else {
                    $pesan = "Ditemukan : $count hasil pencarian dengan kata kunci " . $this->model->keyword;
                    echo "<table class=CSSTableGenerator><tr><td colspan=5 halign=left>$pesan</td></tr>";
                    foreach ($hasil as $val) {
                        echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td><td>$val[4]</td></tr>";
                    }
                    echo "</table>";
                }
            }
        } else if ($this->model->filter == null AND $this->model->before != null AND $this->model->after != null) {
            $hasil = $this->model->findByDate();
            $count = count($hasil);
            if ($count == 0) {
                echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
            } else {
                $pesan = "Ditemukan : $count hasil pencarian tanggal " . Tanggal::tgl_indo($this->model->before) . " sampai dengan tanggal " . Tanggal::tgl_indo($this->model->after);
                echo "<table class=CSSTableGenerator><tr><td colspan=5 halign=left>$pesan</td></tr>";
                foreach ($hasil as $val) {
                    echo "<tr><td>$val[0]</td><td>" . Tanggal::tgl_indo($val[1]) . "</td><td>$val[2]</td><td>$val[3]</td><td>$val[4]</td></tr>";
                }
                echo "</table>";
            }
        }
    }

}

?>
