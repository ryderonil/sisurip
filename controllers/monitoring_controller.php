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
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }

    public function index() {

        $this->view->render('monitoring/report');
    }

    public function kinerja() {
        //$a = "2013-02-25";
        //$b = "2013-04-02";
        //echo $this->model->cekSelisihHari($a,$b);
        //echo $this->model->selisihJam("09:30:56","08:05:56");

        $this->view->render('monitoring/report');
    }

    public function ikhtisar() {
        $this->view->render('monitoring/ikhtisar');
    }

    public function kinerjaSuratMasuk() {

        $q = $_POST['queryString'];
        if ($q != '') {
            $param = explode(",", $q);
            if (!is_null($param[1])) {
                $sql = "SELECT * FROM suratmasuk WHERE MONTH(tgl_terima)='" . $param[0] . "' AND DATE(tgl_terima)='" . $param[1] . "'";
                $data = $this->model->kinerjaSMHari($sql);
            } else if (!is_null($param[0])) {
                $sql = "SELECT * FROM suratmasuk WHERE MONTH(tgl_terima)='" . $param[0] . "'";
                $data = $this->model->kinerjaSMBulan($sql);
            }
        } else {
            $surat = new Suratmasuk_Model();
            $data = $surat->showAll();

            $arraydata = array();
            foreach ($data as $value) {

                $tgl1 = $value['start'];
                $tgl2 = $value['end'];
                $selisihhari = $this->model->cekSelisihHari($tgl1, $tgl2);
                $start = explode(" ", $value['start']);
                $start = trim($start[1]);
                $end = explode(" ", $value['end']);
                $end = trim($end[1]);
                if ($selisihhari > 0) {
                    $hari1 = $this->model->selisihJam($this->model->jampulang, $start);
                    $hari2 = $this->model->selisihJam($end, $this->model->jammasuk);
                    $selisihjam = $hari1 + $hari2;
                } else {
                    $selisihjam = $this->model->selisihJam($end, $start);
                }

                $kinerja = ceil(($selisihjam / 4) * 100);
                $arraydata[$value['no_agenda']] = $kinerja;
            }

            //var_dump($arraydata);
        }

        $max = max($arraydata);
        echo "<div id=table-wrapper><h2 align=center><font color=black>Ketepatan Waktu Penatausahaan Surat Masuk</font></h2>";
        echo "<h3 align=center>Bulan : Maret 2013</h3>";
        echo "</br><div id=chart-wrapper><table>";
        echo "<tr><td><font color=black><b>agenda</b></font></td><td></td><td></td></tr>";
        foreach ($arraydata as $key => $value) {
            echo "<tr><td width=5%><a href=" . URL . "suratmasuk/detil/$key><font color=grey>$key</font></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
            echo "<td width=50%><div class='progress'>";
            $val = round(($value / $max) * 100, 0);
            if ($value > 100) {
                echo "<div class='bar bar-danger' style='width:$val%;'></div>";
            } else if ($value < 50) {
                echo "<div class='bar bar-success' style='width:$val%;'></div>";
            } else {
                echo "<div class='bar' style='width:$val%;'></div>";
            }

            echo "</td><td>&nbsp;&nbsp;<font color=grey>$value%</font></td></tr></div>";
        }
        echo "</table></div></div>";
    }

    public function kinerjaSuratKeluar() {
        
    }

}

?>
