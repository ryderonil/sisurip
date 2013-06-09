<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set("UTC");

class Monitoring_Model extends Model {

    var $jampulang = '17:00:00';
    var $jammasuk = '07:30:00';
    private $time_sm = 4;
    private $time_sk_ans;
    private $time_sk_bs;
    private $time_sk_s;
    private $time_sk_ss;


    /*
     * constructor
     */
    public function __construct() {
        parent::__construct();
        $this->time_sk_ans = 4;
        $this->time_sk_bs = $this->getTimeLimit('BS'); //set time limit tipe surat biasa
        $this->time_sk_s = $this->getTimeLimit('SG'); //set time limit tipe surat segera
        $this->time_sk_ss = $this->getTimeLimit('SS'); //set time limit tipe surat sangat segera
    }
    
    /*
     * monitoring kinerja surat masuk tahun berjalan
     * param tahun, jenis surat-SM, SK
     * return data array kinerja per bulan:bulan, float
     */
    public function kinerjaTahun($year,$tipe_srt) {
        if($tipe_srt=='SM'){
            $sql = "SELECT no_agenda, MONTH(tgl_terima) as bulan, start, end FROM suratmasuk WHERE YEAR(tgl_terima)='".$year."'";
        }elseif ($tipe_srt=='SK') {
            $sql = "SELECT id_suratkeluar as no_agenda, MONTH(tgl_surat) as bulan, start, end FROM suratkeluar WHERE YEAR(tgl_surat)='".$year."'";
        }
        
        $data = $this->select($sql);
        $arraydata = array();
        $krj = array();
        $count = 1;
        $bulan = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            if($tgl2=='0000-00-00 00:00:00' OR $tgl2==null) $tgl2=$tgl1;
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if($value['end']=='0000-00-00 00:00:00' OR $value['end']==null){
                $end = explode(" ",$value['start']);
            }else{
                $end = explode(" ", $value['end']);
            }
            
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->selisihJam($this->jampulang, $start);
                $hari2 = $this->selisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2 + ($selisihhari-1)*10.5;
            } else {
                $selisihjam = $this->selisihJam($end, $start);
            }            
            if($tipe_srt=='SM'){
                $kinerja = round(($selisihjam / $this->time_sm) * 100,2);
            }elseif ($tipe_srt=='SK') {
                $kinerja = round(($selisihjam / $this->cekSifatSuratKeluar($value['no_agenda'])) * 100,2);
            }
            if($value['bulan']==$bulan){             
                $krj[] = $kinerja;
                $count++;
                $sum = round(array_sum($krj)/($count),2); 
                $arraydata[$value['bulan']] = $sum;                
                
            }else if($value['bulan']!=$bulan){              
                $krj = null;                
                $krj = array();
                $krj[] = $kinerja;
                $count = 1;
                $sum = round(array_sum($krj)/($count),2); 
                $arraydata[$value['bulan']] = $sum;                          
            }
            $bulan = $value['bulan'];            
        }
        return $arraydata;
    }
    
    /*
     * monitoring kinerja surat masuk bulan tertentu
     * param bulan, jenis surat-SM, SK
     * return data array kinerja harian: tgl, float
     */
    public function kinerjaBulan($month, $year, $tipe_srt){
        if($tipe_srt=='SM'){
            $sql = "SELECT no_agenda, DATE(tgl_terima) as tanggal, start, end FROM suratmasuk WHERE MONTH(tgl_terima)='".$month."' AND YEAR(tgl_terima)='".$year."'";
        }elseif ($tipe_srt=='SK') {
            $sql = "SELECT id_suratkeluar as no_agenda, DATE(tgl_surat) as tanggal, start, end FROM suratkeluar WHERE MONTH(tgl_surat)='".$month."' AND YEAR(tgl_surat)='".$year."'";
        }
        
        $data = $this->select($sql);
        $arraydata = array();
        $krj = array();
        $count = 1;
        $tanggal = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            if($tgl2=='0000-00-00 00:00:00') $tgl2=$tgl1;
            if(is_null($tgl2)) $tgl2=$tgl1;
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if($value['end']=='0000-00-00 00:00:00' OR is_null($value['end'])){
                $end = explode(" ", $value['start']);
            }  else {
                $end = explode(" ", $value['end']);
            }
            
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->selisihJam($this->jampulang, $start);
                $hari2 = $this->selisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2 + ($selisihhari-1)*10.5;
            } else {
                $selisihjam = $this->selisihJam($end, $start);
            }            
            if($tipe_srt=='SM'){
                $kinerja = round(($selisihjam / $this->time_sm) * 100,2);
            }elseif ($tipe_srt=='SK') {
                $kinerja = round(($selisihjam / $this->cekSifatSuratKeluar($value['no_agenda'])) * 100,2);
            }
            if($value['tanggal']==$tanggal){
                $count++;
                $krj[] = $kinerja;                
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['tanggal']] = $sum;                
                
            }else if($value['tanggal']!=$tanggal){              
                $krj = null;                
                $krj = array();
                $krj[] = $kinerja;
                $count = 1;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['tanggal']] = $sum;                          
            }
            $tanggal = $value['tanggal'];            
        }
        return $arraydata;
    }
    
    /*
     * monitoring kinerja surat harian
     * param tgl, jenis surat-SM, SK
     * return data array kinerja per agenda surat : agenda, float
     */
    public function kinerjaHari($tgl,$tipe_srt){
        if($tipe_srt=='SM'){
            $sql = "SELECT no_agenda, start, end FROM suratmasuk WHERE tgl_terima='".$tgl."'";
        }elseif ($tipe_srt=='SK') {
            $sql = "SELECT id_suratkeluar as no_agenda, start, end FROM suratkeluar WHERE tgl_surat='".$tgl."'";
        }
        
        $data = $this->select($sql);
        $arraydata = array();
        $krj = array();
        $count = 1;
        $agenda = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            if($tgl2=='0000-00-00 00:00:00') $tgl2=$tgl1;
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if($value['end']=='0000-00-00 00:00:00'){
                $end = explode(" ", $value['start']);
            }  else {
                $end = explode(" ", $value['end']);
            }
            $end = trim($end[1]);
            if ($selisihhari > 0) {
                $hari1 = $this->selisihJam($this->jampulang, $start); 
                $hari2 = $this->selisihJam($end, $this->jammasuk);
                $selisihjam = $hari1 + $hari2 + ($selisihhari-1)*10.5;
            } else {
                $selisihjam = $this->selisihJam($end, $start);
            }            
            if($tipe_srt=='SM'){
                $kinerja = round(($selisihjam / $this->time_sm) * 100,2);
            }elseif ($tipe_srt=='SK') {                
                $kinerja = round(($selisihjam / $this->cekSifatSuratKeluar($value['no_agenda'])) * 100,2);
            }
            if($value['no_agenda']==$agenda){
                $count++;
                $krj[] = $kinerja;                
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['no_agenda']] = $sum;                
                
            }else if($value['no_agenda']!=$agenda){              
                $krj = null;                
                $krj = array();
                $krj[] = $kinerja;
                $count = 1;
                $sum = array_sum($krj)/($count); 
                $arraydata[$value['no_agenda']] = $sum;                          
            }
            $agenda = $value['no_agenda'];            
        }
        return $arraydata;
    }
    
    /*
     * fungsi menghitung selisih jam
     * @param end:jam akhir, start:jam awal
     * return int: detik/3600
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
     * perhitungan hari libur ada disini******
     * return menghasilkan nilai selisih hari pertama dan kedua:int
     */

    public function cekSelisihHari($start, $end) {
        $libur = $this->cekLibur($start, $end);
        $hari1 = explode(" ", $start); //memisahkan date dengan time
        
        $tgl1 = $hari1[0];
        $tgl1 = explode("-", $tgl1); //memisahkan tahun, bulan dan tanggal
        if(is_null($end)){
            $end=$start;
        }
        $hari2 = explode(" ", $end);
        $tgl2 = $hari2[0];
        $tgl2 = explode("-", $tgl2);
        if (((int) $tgl2[0] - (int) $tgl1[0]) == 0) { //jika tahunnya sama
            if (((int) $tgl2[1] - (int) $tgl1[1]) == 0) { //jika bulannya sama
                if (((int) $tgl2[2] - (int) $tgl1[2]) == 0) { //jika tanggalnya sama
                    return 0;
                } else {
                    return (int) $tgl2[2] - (int) $tgl1[2] - $libur;
                }
            } else { //jika bulan berbeda
                if (((int) $tgl2[1] - (int) $tgl1[1]) > 0) {
                    $num = cal_days_in_month(CAL_GREGORIAN, $tgl1[1], $tgl1[0]); //jumlah hari dalam bulan

                    for ($i = 1; $i < ((int) $tgl2[1] - (int) $tgl1[1]); $i++) {

                        $num += cal_days_in_month(CAL_GREGORIAN, (int) $tgl1[1] + 1, $tgl1[0]); //tiap perulangan +1 bulan
                    }
                }
                $temp = $num - (int) $tgl1[2]; //dikurangi tanggal start
                return $temp + (int) $tgl2[2] - $libur; //ditambahn tanggal end dikurangi hari libur
            }
        } else { //tahun berbeda
            $num = cal_days_in_month(CAL_GREGORIAN, $tgl1[1], $tgl1[0]); //jumlah hari dalam bulan
            $temp = $num - (int) $tgl1[2]; //dikurangi tanggal start
            return $temp + (int) $tgl2[2] - $libur; //ditambah tanggal end dikurangi hari libur
        }

        return 0;
    }
    
    /*
     * fungsi mendapatkan jumlah libur antara selisih tanggal
     * param tanggal awal, tanggal akhir
     * return int
     */
    function cekLibur($start, $end){
        $start = explode(" ", $start);
        $end = explode(" ", $end);
        $tgl1 = explode("-", $start[0]);
        $tgl2 = explode("-", $end[0]);
        
        $jd1 = GregorianToJD($tgl1[1], $tgl1[2], $tgl1[0]);

        $jd2 = GregorianToJD($tgl2[1], $tgl2[2], $tgl2[0]);
        
        $num = $jd2-$jd1; //selisih hari
        $sql = "SELECT tgl FROM libur"; //mendapatkan hari libur
        $data = $this->select($sql);
        $start = $start[0]; //awal hari untuk perhitungan
        $end = $end[0];
        $libur = 0;
        for($i=0;$i<$num;$i++){
//            echo $start.'<br>';
            $start = strtotime('+1 day', strtotime($start)); //masalahnya kayake ada disini
            $start = date('Y-m-d',$start); //diubah ke date dulu
            $wday = date('w',strtotime($start)); //ubah lagi ke strtotime->date           
            if($wday==0 OR $wday==6){
                $libur++;
            }else{
                //disini di cek dengan data hari libur di DB
                foreach ($data as $val){
                    if(date('Y-m-d',strtotime($start))==date('Y-m-d',  strtotime($val['tgl']))){ //jika sama dengan data libur ++
                        $libur++;
                    }
                }
            }
        }
        
        return $libur;
    }
    
    /*
     * fungsi mendapatkan batas penyelesaian surat
     * param tipe surat keluar -> segera, sangat segera, biasa 
     * return float
     */
    private function getTimeLimit($tipe_sk){
        $sql = "SELECT batas_waktu FROM klasifikasi_surat WHERE kode_klassurat='".$tipe_sk."'";
        $klas = $this->select($sql);
        $batas=0;
        foreach ($klas as $val){
            $batas = $val['batas_waktu'];
        }
        
        return (int) $batas*10.5; //dikalikan jam kerja harian 07.30-17.00
    }
    
    /*
     * fungsi cek sifat surat keluar
     * return int
     */
    public function cekSifatSuratKeluar($id){
        $batas=0;
        $sql = "SELECT rujukan,jenis FROM suratkeluar WHERE id_suratkeluar=".$id;        
        $data = $this->select($sql);        
        foreach ($data as $val){
            if($val['rujukan']==0){
                switch($val['jenis']){
                    case 'BS':
                        $batas = $this->time_sk_bs;
                        break;
                    case 'SG':
                        $batas = $this->time_sk_s;
                        break;
                    case 'SS':
                        $batas = $this->time_sk_ss;
                        break;
                }
            }else{
                $batas = $this->time_sk_ans;
            }
        }     
        
        return $batas;
    }
    
    /*
     * fungsi mendapatkan progress surat
     * return array surat status <> arsip
     */
    public function getProgresSurat(){
        $progres = array();
        $sql = "SELECT a.id_suratmasuk as id,
                a.no_surat, 
                a.tgl_surat, 
                b.nama_satker AS alamat, 
                c.klasifikasi, 
                d.status, 
                a.start 
                FROM suratmasuk a
                LEFT JOIN alamat b ON a.asal_surat = b.kode_satker
                LEFT JOIN klasifikasi_surat c ON a.jenis = c.kode_klassurat
                LEFT JOIN STATUS d ON a.stat = d.id_status
                WHERE a.stat<>15";
//        var_dump($sql);
        $data = $this->select($sql);
        foreach ($data as $val){
            $progres['SM'][] = $val;
        }
        
        $sql = "SELECT a.id_suratkeluar as id,
                a.no_surat,
                a.tgl_surat,
                b.nama_satker as alamat,
                c.klasifikasi,
                d.status,
                a.start
                FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan=b.kode_satker
                LEFT JOIN klasifikasi_surat c ON a.jenis = c.kode_klassurat
                LEFT JOIN status d ON a.status = d.id_status
                WHERE a.status<>23";
        
        $data = $this->select($sql);
        foreach ($data as $val){
            $progres['SK'][] = $val;
        }
        
        return $progres;
        
    }
    
    /*
     * fungsi mendapatkan batas waktu penyelesaian surat 
     * return int (jam)
     */
    public function getDueDate($tipe,$id=null){
        $due_date = 24;
        if($tipe=='SM'){
            return $due_date;
        }elseif ($tipe='SK' AND !is_null($id)) {
            $sk = new Suratkeluar_Model();
            $data = $sk->getSuratById($id, 'ubah');
//            foreach ($data as $val){
                if($data->getRujukan()!=0){
                    return $due_date;
                }else{
                    if($data->getJenis()=='SS'){
                        return 24;
                    }elseif($data->getJenis()=='SG'){
                        return 2*24;
                    }elseif ($data->getJenis()=='BS') {
                        return 5*24;
                    }
                }
//            }
        }elseif($tipe=='SK' AND is_null($id)){
            return $due_date;
        }
    }
    
    /*
     * fungsi menghitung kinerja pegawai, jumlah surat tepat waktu, terlambat, belum selesai
     * return array int
     */
    public function kinerjaPegawai() {
        
        $sql = "SELECT a.id_suratkeluar as no_agenda,
                a.start as start,
                a.end as end,
                b.namaPegawai as nama
                FROM suratkeluar a 
                LEFT JOIN user b ON a.user = b.username
                ";

        $data = $this->select($sql);
        $arraydata = array();
        $peg = '';
        foreach ($data as $value) {
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            if($tgl2=='0000-00-00 00:00:00' OR $tgl2==null) $tgl2=$tgl1;
            $selisihhari = $this->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if ($value['end']=='0000-00-00 00:00:00' OR $value['end']==null) {
                if(key_exists($value['nama'], $arraydata)){
                    $arraydata[$value['nama']][3]++;
                }else{
                    $arraydata[$value['nama']] = array($value['nama'],0,0,1); 
                }
               
            } else {
                $end = explode(" ", $value['end']);
                $end = trim($end[1]);
                if ($selisihhari > 0) {
                    $hari1 = $this->selisihJam($this->jampulang, $start);
                    $hari2 = $this->selisihJam($end, $this->jammasuk);
                    $selisihjam = $hari1 + $hari2 + ($selisihhari-1)*10.5;
                } else {
                    $selisihjam = $this->selisihJam($end, $start);
                }
                
                $kinerja = round(($selisihjam / $this->cekSifatSuratKeluar($value['no_agenda'])) * 100, 2);
               if($kinerja>100){
                   if(key_exists($value['nama'], $arraydata)){
                       $arraydata[$value['nama']][2]++;
                   }else{
                       $arraydata[$value['nama']] = array($value['nama'],0,1,0);
                   }
               }elseif($kinerja<=100){
                   if(key_exists($value['nama'], $arraydata)){
                       $arraydata[$value['nama']][1]++;
                   }else{
                       $arraydata[$value['nama']] = array($value['nama'],1,0,0);
                   }
               }
          
            }
            $peg = $value['nama'];
        }
        return $arraydata;
    }
    
    /*
     * fungsi data jumlah surat per alamat
     * return array int
     */
    public function grafikAsalSurat() {
        
        $sql = "SELECT asal_surat 
                FROM suratmasuk ";
        $data = $this->select($sql);
        $arraydata = array();
        foreach ($data as $value) {
                if(key_exists($value['asal_surat'], $arraydata)){
                    $arraydata[$value['asal_surat']][1]++;
                }else{
                    $arraydata[$value['asal_surat']] = array($value['asal_surat'],1);
                }
        }
        return $arraydata;
    }
    
    /*
     * fungsi jumlah surat masuk harian bulan berjalan
     * return array int
     */
    public function grafikJmlSuratMasuk($bln=null) {
        if(is_null($bln)){
            $month = date('m');
        }
        
        
        $sql = "SELECT tgl_terima as tgl
                FROM suratmasuk 
                WHERE MONTH(tgl_terima)='".$month."'";
        $data = $this->select($sql);
        $arraydata = array();
        foreach ($data as $value) {
                if(key_exists(substr($value['tgl'],-2), $arraydata)){
                    $arraydata[substr($value['tgl'],-2)][1]++;
                }else{
                    $arraydata[substr($value['tgl'],-2)] = array(substr($value['tgl'],-2),1);
                }
        }
        return $arraydata;
    }
    
    /*
     * mendapatkan jumlah surat keluar per tipe naskah dinas
     * return array int
     */
    public function grafikTipeSuratKeluar() {
        
        $sql = "SELECT a.tipe as tipe,
                b.tipe_naskah as nama
                FROM suratkeluar a 
                LEFT JOIN tipe_naskah b
                ON a.tipe=b.id_tipe";
        $data = $this->select($sql);
        $arraydata = array();
        foreach ($data as $value) {
                if(key_exists($value['tipe'], $arraydata)){
                    $arraydata[$value['tipe']][1]++;
                }else{
                    $arraydata[$value['tipe']] = array($value['nama'],1);
                }
        }
        return $arraydata;
    }
    
    /*
     * mendapatkan jumlah surat keluar harian dalam bulan berjalan
     * return array int
     */
    public function grafikJmlSuratKeluar($bln=null) {
        if(is_null($bln)){
            $month = date('m');
        }
        
        $sql = "SELECT tgl_surat as tgl
                FROM suratkeluar 
                WHERE MONTH(tgl_surat)='".$month."'";
        $data = $this->select($sql);
        $arraydata = array();
        foreach ($data as $value) {
                if(key_exists(substr($value['tgl'],-2), $arraydata)){
                    $arraydata[substr($value['tgl'],-2)][1]++;
                }else{
                    $arraydata[substr($value['tgl'],-2)] = array(substr($value['tgl'],-2),1);
                }
        }
        return $arraydata;
    }
    
    /*
     * fungsi cek jam/hari kerja, jika bukan hari kerja maka akan dicari hari kerja ke depan
     * yang paling dekat
     * fungsi mendapatkan hari kerja yang paling dekat dengan rentang waktu yang telah ditentukan
     * param time, rentang, $cek (true[cek hari kerja atau bukan], false[])
     */
    public function cekNextDay($start, $param=true, $rentang=null){
        
        $start = explode(" ", $start);
        $from = strtotime($this->jammasuk);
        $to = strtotime($this->jampulang);
        $time = strtotime($start[1]);
        
        $sql = "SELECT tgl FROM libur"; //mendapatkan hari libur
        $data = $this->select($sql);
        //cek dulu hari libur apa nggak!
        if($param){
            $harikerja = true;
            foreach ($data as $val){
                if(strtotime($start[0])==  strtotime($val['tgl'])) {
                    $harikerja=false;
                    break;
                }  
            }

            //cek hari sabtu minggu
            $date = date('Y-m-d', strtotime($start[0]));
            if(date('w',  strtotime($date))==0 OR date('w',  strtotime($date))==6) {
                $harikerja=false;
            }

            if($harikerja){
                if($time<$from) return date('Y-m-d H:i:s',  strtotime ($start[0].' '.$this->jammasuk)); //jika kurang dari jam masuk, catak sbg jam masuk
                if($time<$to AND $time>$from) return implode (" ", $start); //jika di jam kerja, catat sebagai jam kerja
            }
        }
        
        $rentang = (is_null($rentang)? 1 : $rentang);
        
        $startdate = $start[0]; //awal hari untuk perhitungan
        $count = 0;
        $cek = true;
        while($cek==true){
            $startday = strtotime('+1 day', strtotime($startdate)); //masalahnya kayake ada disini
            $startdate = date('Y-m-d',$startday); //diubah ke date dulu
            $wday = date('w',strtotime($startdate)); //ubah lagi ke strtotime->date  
            $k = false;
            if($wday!=0 AND $wday!=6){
                foreach ($data as $val){
                    if(strtotime($startdate)==  strtotime($val['tgl'])){
                        $k=true;
                        break;
                    }
                }   
            }else{
                $k=true;
            }
            
            if(!$k){
                $count++; 
            }else{
                $k=false;
            }
            
            if($count==$rentang){
                $cek=false;
            }
        }
        
        if($param){
            return date('Y-m-d H:i;s',  strtotime($startdate.' '.$this->jammasuk));
        }else{
            $hms = $start[1];
            if($time<$from) $hms = date('Y-m-d H:i:s',  strtotime ($startdate.' '.$this->jammasuk));
            if($time>$to) $hms = date('Y-m-d H:i:s',  strtotime ($startdate.' '.$this->jampulang));
            if($time<$to AND $time>$from) $hms = implode (" ", $start);
            return date('Y-m-d H:i;s',  strtotime($hms));
        }
        
    }
    
    function __destruct() {
        ;
    }

}
?>
