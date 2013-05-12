<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Monitoring_Controller extends Controller {

    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama();
        $this->view->js = array(
            'suratmasuk/js/default'
        );
    }

    public function index() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $this->view->render('monitoring/report');
    }

    public function kinerja() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $this->view->render('monitoring/report');
    }

    public function kinerjaSMTahun() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
//        $q = $_POST['queryString'];
        //echo $q;
        $year = DATE('Y');
        $arraydata = $this->model->kinerjaTahun($year, 'SM');
        $masa = "TAHUN " . $year;
        $max = max($arraydata);
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Masuk</font></h2>";
        echo "<h3 align=center>$masa</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>bulan</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            $bulan = Tanggal::bulan_indo($key);
            echo "<tr><td width=10%><font color=grey>$bulan</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<a href=#><div class='bar bar-danger' style='width:$val%;' onclick='srmasukbulan(" . $key . ");'></div></a>";
            } else if ($value < 50) {
                echo "<a href=#><div class='bar bar-success' style='width:$val%;' onclick='srmasukbulan(" . $key . ");'></div></a>";
            } else {
                echo "<a href=#><div class='bar' style='width:$val%;' onclick='srmasukbulan(" . $key . ");'></div></a>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function kinerjaSMBulan() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $q = $_POST['queryString'];
        $bulan = substr($q, 0, 1);
        if ($bulan == '1') {
            $cek = substr($q, 1, 1);
            if (is_int($cek)) {
                $bulan .= substr($q, 1, 1);
            }
        }
        $year = date('Y');
        $arraydata = $this->model->kinerjaBulan($q, $year, 'SM');
        $bulan = Tanggal::bulan_indo($bulan);
        $masa = "BULAN " . strtoupper($bulan) . " TAHUN " . $year;
        $max = max($arraydata);
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Masuk</font></h2>";
        echo "<h3 align=center>$masa</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>tanggal</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            $js = str_replace("-", "", $key);
            $tanggal = Tanggal::tgl_indo($key);
            echo "<tr><td width=15%><font color=grey>$tanggal</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<a href=#><div class='bar bar-danger' style='width:$val%;' onclick='srmasuk(" . $js . ");'></div></a>";
            } else if ($value < 50) {
                echo "<a href=#><div class='bar bar-success' style='width:$val%;' onclick='srmasuk(" . $js . ");'></div></a>";
            } else {
                echo "<a href=#><div class='bar' style='width:$val%;' onclick='srmasuk(" . $js . ");'></div></a>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function kinerjaSMHari() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $q = $_POST['tanggal'];
        $tgl = substr($q, 6, 2);
        $bln = substr($q, 4, 2);
        $year = substr($q, 0, 4);
        $tgl = $year . "-" . $bln . "-" . $tgl;
        $arraydata = $this->model->kinerjaHari($tgl, 'SM');
        $masa = "TANGGAL " . Tanggal::tgl_indo($tgl);
        $max = max($arraydata);
        //$masa = 'Bulan : Maret 2013';
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Masuk</font></h2>";
        echo "<h3 align=center>$masa</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>agenda</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            //$bulan = Tanggal::tgl_indo($key);
            echo "<tr><td width=15%><a href=" . URL . "suratmasuk/detil/$key><font color=grey>$key</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<a href=" . URL . "suratmasuk/detil/$key><div class='bar bar-danger' style='width:$val%;' ></div></a>";
            } else if ($value < 50) {
                echo "<a href=" . URL . "suratmasuk/detil/$key><div class='bar bar-success' style='width:$val%;' ></div></a>";
            } else {
                echo "<a href=" . URL . "suratmasuk/detil/$key><div class='bar' style='width:$val%;' ></div></a>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function kinerjaSuratKeluar() {
        echo "<div><input type=button value=tombol><input type=button value=tombol_juga></div>";
    }

    public function kinerjaSKTahun() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $q = $_POST['tanggal'];
        $year = DATE('Y');
        $arraydata = $this->model->kinerjaTahun($year, 'SK');
        $masa = "TAHUN " . $year;
        $max = max($arraydata);
        //$masa = 'Bulan : Maret 2013';
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Keluar</font></h2>";
        echo "<h3 align=center>$masa</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>bulan</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            //echo $key;
            $bulan = Tanggal::bulan_indo($key);
            echo "<tr><td width=10%><font color=grey>$bulan</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<a href=#><div class='bar bar-danger' style='width:$val%;' onclick='srkeluarbulan(" . $key . ");'></div></a>";
            } else if ($value < 50) {
                echo "<a href=#><div class='bar bar-success' style='width:$val%;' onclick='srkeluarbulan(" . $key . ");'></div></a>";
            } else {
                echo "<a href=#><div class='bar' style='width:$val%;' onclick='srkeluarbulan(" . $key . ");'></div></a>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function kinerjaSKBulan() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $q = $_POST['queryString'];
        //echo $q;
        $bulan = substr($q, 0, 1);
        if ($bulan == '1') {
            $cek = substr($q, 1, 1);
            if (is_int($cek)) {
                $bulan .= substr($q, 1, 1);
            }
        }
        //echo $bulan;
        $year = date('Y');
//        $sql = "SELECT no_agenda, DATE(tgl_terima) as tanggal, start, end FROM suratmasuk WHERE MONTH(tgl_terima)='".$q."' AND YEAR(tgl_terima)='".$year."'";
        //echo $sql;
        $arraydata = $this->model->kinerjaBulan($q, $year, 'SK');
        //var_dump($arraydata);
        $bulan = Tanggal::bulan_indo($bulan);
        $masa = "BULAN " . strtoupper($bulan) . " TAHUN " . $year;



        $max = max($arraydata);
        //$masa = 'Bulan : Maret 2013';
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Keluar</font></h2>";
        echo "<h3 align=center>$masa</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>tanggal</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            //echo $key;
            //$param=  explode("-", $key);
//            var_dump($param);
            $js = str_replace("-", "", $key);
            //$js = $param[2]."-".$param[1];
//            var_dump($js);
            $tanggal = Tanggal::tgl_indo($key);
            echo "<tr><td width=15%><font color=grey>$tanggal</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<a href=#><div class='bar bar-danger' style='width:$val%;' onclick='srkeluarhari(" . $js . ");'></div></a>";
            } else if ($value < 50) {
                echo "<a href=#><div class='bar bar-success' style='width:$val%;' onclick='srkeluarhari(" . $js . ");'></div></a>";
            } else {
                echo "<a href=#><div class='bar' style='width:$val%;' onclick='srkeluarhari(" . $js . ");'></div></a>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function kinerjaSKHari() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $q = $_POST['tanggal'];
        //echo $q;
        $tgl = substr($q, 6, 2);
        //var_dump($tgl);
        $bln = substr($q, 4, 2);
        //var_dump($bln);
        //bulan=;
        //var_dump($param);
        $year = substr($q, 0, 4);
        //var_dump($year);
        $tgl = $year . "-" . $bln . "-" . $tgl;
        //var_dump($tgl);
//        $sql = "SELECT no_agenda, start, end FROM suratmasuk WHERE tgl_terima='".$tgl."'";
        //echo $sql;
        $arraydata = $this->model->kinerjaHari($tgl, 'SK');
        //var_dump($arraydata);
        //$bulan = Tanggal::bulan_indo($q);
        $masa = "TANGGAL " . Tanggal::tgl_indo($tgl);


        $max = max($arraydata);
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Keluar</font></h2>";
        echo "<h3 align=center>$masa</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>agenda</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            echo "<tr><td width=15%><a href=" . URL . "suratmasuk/detil/$key><font color=grey>$key</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<a href=" . URL . "suratkeluar/detil/$key><div class='bar bar-danger' style='width:$val%;' ></div></a>";
            } else if ($value < 50) {
                echo "<a href=" . URL . "suratkeluar/detil/$key><div class='bar bar-success' style='width:$val%;' ></div></a>";
            } else {
                echo "<a href=" . URL . "suratkeluar/detil/$key><div class='bar' style='width:$val%;' ></div></a>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function ikhtisar() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $this->view->render('monitoring/ikhtisar');
    }

    public function progresSurat() {
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $datac = $this->model->getProgresSurat();
//        var_dump($datac);
        echo "<div id=table-wrapper><h2 align=center><font color=black>MONITORING PENYELESAIAN SURAT</font></h2>";
        echo "<h3 align=center></h3>";
        echo "</br><div id=chart-wrapper><table class=CSSTableGenerator>";
        echo "<tr><td><font color=black><b>No</b></font></td>
            <td><font color=black><b>nomor/tgl surat</b></font></td>
            <td><font color=black><b>alamat</b></font></td>
            <td><font color=black><b>sifat/status</b></font></td>
            <td><font color=black><b>mulai pengerjaan</b></font></td>
            <td><font color=black><b>batas waktu</b></font></td>
            </tr>";
        $no = 1;
        foreach ($datac as $key => $val) {
            if ($key == 'SM') {
                echo '<tr><td></td><td colspan=5><font size=4><strong>SURAT MASUK</strong></font></td></tr>';
                foreach ($val as $prog) {
                    $date = new DateTime($prog['start']);
                    $add = $this->model->getDueDate('SM');
                    $date->add(new DateInterval('PT' . $add . 'H0M0S'));
                    $due_date = $date->format('Y-m-d H:i:s');
                    echo "<tr><td><font color=black><b>$no</b></font></td>
                        <td><font color=black><b>$prog[no_surat]/</br>$prog[tgl_surat]</b></font></td>
                        <td><font color=black><b>$prog[alamat]</b></font></td>
                        <td><font color=black><b>$prog[klasifikasi]/</br>$prog[status]</b></font></td>
                        <td><font color=black><b>$prog[start]</b></font></td>
                        <td><font color=black><b>$due_date</b></font></td>
                        </tr>";
                    $no++;
                }
            } else {
                echo '<tr><td></td><td colspan=5><font size=4><strong>SURAT KELUAR</strong></font></td></tr>';
                foreach ($val as $prog) {
                    $date = new DateTime($prog['start']);
                    $add = (string) $this->model->getDueDate('SK', $prog['id']);
//                    var_dump($add);
                    $date->add(new DateInterval('PT' . $add . 'H0M0S'));
                    $due_date = $date->format('Y-m-d H:i:s');
                    echo "<tr><td><font color=black><b>$no</b></font></td>
                        <td><font color=black><b>$prog[no_surat]/</br>$prog[tgl_surat]</b></font></td>
                        <td><font color=black><b>$prog[alamat]</b></font></td>
                        <td><font color=black><b>$prog[klasifikasi]/</br>$prog[status]</b></font></td>
                        <td><font color=black><b>$prog[start]</b></font></td>
                        <td><font color=black><b>$due_date</b></font></td>
                        </tr>";
                    $no++;
                }
            }
        }
    }
    
    //jumlah surat berdasarkan tipe
    public function grafikTipeSuratKeluar(){
        $data = $this->model->grafikTipeSuratKeluar();
        $this->view->data = array();
        foreach ($data as $val){
            $this->view->data[] = $val;
        }
        $this->view->load('monitoring/tipe');
    }
    
    public function grafikKinerjaPegawai(){
        $data = $this->model->kinerjaPegawai();
        $this->view->data = array();
        foreach ($data as $val){
            $this->view->data[] = $val;
        }
        $this->view->load('monitoring/kinerjapegawai');
    }
    
    public function kinerjaPegawai(){        
        $this->view->load('monitoring/kinerjaframe');
    }
    //jumlah surat berdasarkan pengirim--->surat masuk
    public function grafikAsalSurat(){
        $data = $this->model->grafikAsalSurat();
        $this->view->data = array();
        foreach ($data as $val){
            $this->view->data[] = $val;
        }
        $this->view->load('monitoring/asalsurat');
    }
    
    //jumlah surat masuk harian dalam bulan bersangkutan
    public function grafikJmlSuratMasukHarian(){
        $data = $this->model->grafikJmlSuratMasuk();
        $this->view->data = array();
        foreach ($data as $val){
            $this->view->data[] = $val;
        }
        $this->view->load('monitoring/jmlsuratmasuk');
    }
    
    //jumlah surat keluar harian dalam bulan bersangkutan
    public function grafikJmlSuratKeluarHarian(){
        $data = $this->model->grafikJmlSuratKeluar();
        $this->view->data = array();
        foreach ($data as $val){
            $this->view->data[] = $val;
        }
        $this->view->load('monitoring/jmlsuratkeluar');
    }
    
    public function grafik(){
        if(!Auth::isAllow(1, Session::get('role'), 1, Session::get('bagian'))){
            if(!Auth::isAllow(2, Session::get('role'))){
                header('location:'.URL.'home');
            }
        }
        $this->view->load('monitoring/grafik');
    }

}

?>
