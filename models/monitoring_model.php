<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set("UTC");

class Monitoring_Model extends Model {

    var $jampulang = '17:00:00';
    var $jammasuk = '07:30:00';
    
    /*
     * constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * 
     */
    public function monitoringKinerjaSuratMasuk() {
        $sql = "SELECT no_agenda, tgl_terima, start, end FROM suratmasuk";
        $data = $this->select($sql);
        foreach ($data as $value) {
            $selisihhari = $this->cekSelisihHari($value['start'], $value['end']);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            $end = explode(" ", $value['end']);
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->cekSelisihJam($this->jampulang, $start);
                $hari2 = $this->cekSelisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2;
            } else {
                $selisihjam = $this->cekSelisihJam($end, $start);
            }
            $kinerja = ceil(($selisihjam / 4) * 100);
        }
    }
    
    /*
     * monitoring kinerja surat masuk tahun berjalan
     * return data array kinerja per bulan
     */
    public function kinerjaTahun($year,$tipe_srt) {
        if($tipe_srt=='SM'){
            $sql = "SELECT no_agenda, MONTH(tgl_terima) as bulan, start, end FROM suratmasuk WHERE YEAR(tgl_terima)='".$year."'";
        }elseif ($tipe_srt=='SK') {
            $sql = "SELECT id_suratkeluar as no_agenda, MONTH(tgl_surat) as bulan, start, end FROM suratkeluar WHERE YEAR(tgl_surat)='".$year."'";
        }
        
        $data = $this->select($sql);
        //var_dump($data);
        $arraydata = array();
        $krj = array();
        $count = 1;
        $bulan = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if(is_null($value['end'])){
                $end = explode(" ",$value['start']);
            }else{
                $end = explode(" ", $value['end']);
            }
            
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->selisihJam($this->jampulang, $start);
                $hari2 = $this->selisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2;
            } else {
                $selisihjam = $this->selisihJam($end, $start);
            }            
            $kinerja = ceil(($selisihjam / 4) * 100);
            //echo $kinerja."*</br>";
            if($value['bulan']==$bulan AND $count>1){             
                $krj[] = $kinerja;                
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['bulan']] = $sum;                
                $count++;
            }else if($value['bulan']!=$bulan AND $count>1){              
                $krj = null;                
                $krj = array();
                $krj[] = $kinerja;
                $count = 1;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['bulan']] = $sum;                          
            }else if($count==1){                
                $krj[] = $kinerja;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['bulan']] = $sum;                
                $count++;
            }
            //var_dump($krj);
            //var_dump($count);           
            
            $bulan = $value['bulan'];            
        }
        return $arraydata;
    }
    
    /*
     * monitoring kinerja surat masuk bulan tertentu
     * return data array kinerja harian
     */
    public function kinerjaBulan($month, $year, $tipe_srt){
        if($tipe_srt=='SM'){
            $sql = "SELECT no_agenda, DATE(tgl_terima) as tanggal, start, end FROM suratmasuk WHERE MONTH(tgl_terima)='".$month."' AND YEAR(tgl_terima)='".$year."'";
        }elseif ($tipe_srt=='SK') {
            $sql = "SELECT id_suratkeluar as no_agenda, DATE(tgl_surat) as tanggal, start, end FROM suratkeluar WHERE MONTH(tgl_surat)='".$month."' AND YEAR(tgl_surat)='".$year."'";
        }
        
        $data = $this->select($sql);
        //var_dump($data);
        $arraydata = array();
        $krj = array();
        $count = 1;
        $tanggal = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if(is_null($value['end'])){
                $end = explode(" ", $value['start']);
            }  else {
                $end = explode(" ", $value['end']);
            }
            
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->selisihJam($this->jampulang, $start);
                $hari2 = $this->selisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2;
            } else {
                $selisihjam = $this->selisihJam($end, $start);
            }            
            $kinerja = ceil(($selisihjam / 4) * 100);
            //echo $kinerja."*</br>";
            if($value['tanggal']==$tanggal AND $count>1){
                //echo $value['tanggal']."-".$tanggal;
                $krj[] = $kinerja;                
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['tanggal']] = $sum;                
                $count++;
            }else if($value['tanggal']!=$tanggal AND $count>1){              
                $krj = null;                
                $krj = array();
                $krj[] = $kinerja;
                $count = 1;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['tanggal']] = $sum;                          
            }else if($count==1){                
                $krj[] = $kinerja;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['tanggal']] = $sum;                
                $count++;
            }
            //var_dump($krj);
            //var_dump($count);           
            
            $tanggal = $value['tanggal'];            
        }
        return $arraydata;
    }
    
    /*
     * monitoring kinerja surat masuk harian
     * return data array kinerja per agenda surat 
     */
    public function kinerjaHari($tgl,$tipe_srt){
        if($tipe_srt=='SM'){
            $sql = "SELECT no_agenda, start, end FROM suratmasuk WHERE tgl_terima='".$tgl."'";
        }elseif ($tipe_srt=='SK') {
            $sql = "SELECT id_suratkeluar as no_agenda, start, end FROM suratkeluar WHERE tgl_surat='".$tgl."'";
        }
        
        $data = $this->select($sql);
        //var_dump($data);
        $arraydata = array();
        $krj = array();
        $count = 1;
        $agenda = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if(is_null($value['end'])){
                $end = explode(" ", $value['start']);
            }  else {
                $end = explode(" ", $value['end']);
            }
//            $end = explode(" ", $value['end']);
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->selisihJam($this->jampulang, $start);
                $hari2 = $this->selisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2;
            } else {
                $selisihjam = $this->selisihJam($end, $start);
            }            
            $kinerja = ceil(($selisihjam / 4) * 100); //dibedakan antara sm dan sk
            //echo $kinerja."*</br>";
            if($value['no_agenda']==$agenda AND $count>1){
                //echo $value['tanggal']."-".$tanggal;
                $krj[] = $kinerja;                
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['no_agenda']] = $sum;                
                $count++;
            }else if($value['no_agenda']!=$agenda AND $count>1){              
                $krj = null;                
                $krj = array();
                $krj[] = $kinerja;
                $count = 1;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['no_agenda']] = $sum;                          
            }else if($count==1){                
                $krj[] = $kinerja;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['no_agenda']] = $sum;                
                $count++;
            }
            //var_dump($krj);
            //var_dump($count);           
            
            $agenda = $value['no_agenda'];            
        }
        return $arraydata;
    }
    
    /*
     * fungsi menghitung selisih jam
     * @param end:jam akhir, start:jam awal
     * return jam: detik/3600
     */
    public function selisihJam($end, $start) {
        $time1 = explode(":", $end);
        $jam1 = $time1[0];
        $min1 = $time1[1];
        $sec1 = $time1[2];
        $time2 = explode(":", $start);
        $jam2 = $time2[0];
        $min2 = $time2[1];
        $sec2 = $time2[2];
        //dst tidur dulu :D ------------ NGANTUK PAKDE, CAPEK JUGA

        $data1 = mktime($jam1, $min1, $sec1);
        $data2 = mktime($jam2, $min2, $sec2);
        $hasil = $data1 - $data2;

        return $hasil / 3600;
    }

    /*
     * fungsi menghitung selisih hari
     * return menghasilkan nilai selisih hari pertama dan kedua
     */

    public function cekSelisihHari($start, $end) {
        $hari1 = explode(" ", $start); //memisahkan date dengan time
        
        $tgl1 = $hari1[0];
        $tgl1 = explode("-", $tgl1); //memisahkan tahun, bulan dan tanggal
        if(is_null($end)){
            $end=$start;
        }
        $hari2 = explode(" ", $end);
        $tgl2 = $hari2[0];
        $tgl2 = explode("-", $tgl2);
//        var_dump($tgl2);
        if (((int) $tgl2[0] - (int) $tgl1[0]) == 0) {
            if (((int) $tgl2[1] - (int) $tgl1[1]) == 0) {
                if (((int) $tgl2[2] - (int) $tgl1[2]) == 0) {
                    return 0;
                } else {
                    return (int) $tgl2[2] - (int) $tgl1[2];
                }
            } else {
                if (((int) $tgl2[1] - (int) $tgl1[1]) > 0) {
                    $num = cal_days_in_month(CAL_GREGORIAN, $tgl1[1], $tgl1[0]);

                    for ($i = 1; $i < ((int) $tgl2[1] - (int) $tgl1[1]); $i++) {

                        $num += cal_days_in_month(CAL_GREGORIAN, (int) $tgl1[1] + 1, $tgl1[0]);
                    }
                }
                $temp = $num - (int) $tgl1[2];
                return $temp + (int) $tgl2[2];
            }
        } else {
            $num = cal_days_in_month(CAL_GREGORIAN, $tgl1[1], $tgl1[0]);
            echo $num;
            $temp = $num - (int) $tgl1[2];
            return $temp + (int) $tgl2[2];
        }

        return 0;
    }
    
    // Set timezone
    // Time format is UNIX timestamp or
    // PHP strtotime compatible strings

    function dateDiff($time1, $time2, $precision = 6) {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Set default diff to 0
            $diffs[$interval] = 0;
            // Create temp time from time1 and interval
            $ttime = strtotime("+1 " . $interval, $time1);
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                $time1 = $ttime;
                $diffs[$interval]++;
                // Create new temp time from time1 and interval
                $ttime = strtotime("+1 " . $interval, $time1);
            }
        }

        $count = 0;
        $times = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval 
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1) {
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

        // Return string with times
        return implode(", ", $times);
    }

}
?>
