<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KinerjaPegawai extends Model{
    
    private $batasWaktuSurat;
    private $suratMulai;
    private $suratSelesai;
    private $user;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function set($attr, $value){
        switch($attr){
            case 'batasWaktuSurat':
                $this->batasWaktuSurat = $value;
                break;
            case 'suratMulai':
                $this->suratMulai = $value;
                break;
            case 'suratSelesai':
                $this->suratSelesai = $value;
                break;
            case 'user':
                $this->user = $value;
                break;
        }
    }
    
    public function get($attr){
        switch($attr){
            case 'batasWaktuSurat':
                return $this->batasWaktuSurat;
                break;
            case 'suratMulai':
                return $this->suratMulai;
                break;
            case 'suratSelesai':
                return $this->suratSelesai;
                break;
            case 'user':
                return $this->user;
                break;
        }
    }
    
    public function calculateKinerja(User $user){
        $sql = "SELECT 
                a.id_suratkeluar as no_agenda,
                a.start as start,
                a.end as end,
                b.namaPegawai as nama
                FROM suratkeluar a 
                LEFT JOIN user b ON a.user = b.username
                WHERE a.user='".$user->get('nama_user')."'
                    ";
        $data = $this->select($sql);
        $arraydata = null;
        $monitoring = new Monitoring_Model();
        foreach ($data as $value){
            $tgl1 = $value['start'];
            $tgl2 = $value['end'];
            if($tgl2=='0000-00-00 00:00:00' OR $tgl2==null) $tgl2=$tgl1;
            $selisihhari = $monitoring->cekSelisihHari($tgl1, $tgl2);
            $start = explode(" ", $value['start']);
            $start = trim($start[1]);
            if ($value['end']=='0000-00-00 00:00:00' OR $value['end']==null) {
                if(!is_null($arraydata)){
                    $arraydata[3]++;
                }else{
                    $arraydata = array(strtoupper($value['nama']),0,0,1); 
                }
               
            }else {
                $end = explode(" ", $value['end']);
                $end = trim($end[1]);
                if ($selisihhari > 0) {
                    $hari1 = $monitoring->selisihJam($monitoring->jampulang, $start);
                    $hari2 = $monitoring->selisihJam($end, $monitoring->jammasuk);
                    $selisihjam = $hari1 + $hari2 + ($selisihhari-1)*10.5;
                } else {
                    $selisihjam = $monitoring->selisihJam($end, $start);
                }
                
                $kinerja = round(($selisihjam / $monitoring->cekSifatSuratKeluar($value['no_agenda'])) * 100, 2);
               if($kinerja>100){
                   if(!is_null($arraydata)){
                       $arraydata[2]++;
                   }else{
                       $arraydata = array(strtoupper($value['nama']),0,1,0);
                   }
               }elseif($kinerja<=100){
                   if(!is_null($arraydata)){
                       $arraydata[1]++;
                   }else{
                       $arraydata = array(strtoupper($value['nama']),1,0,0);
                   }
               }
          
            } 
        }
        
        return $arraydata;
    }
    
    public function displayKinerja(){
        $duser = new User();
        $data = $duser->getUser();
        $kinerja = array();
        foreach ($data as $val){
            if(Auth::isRole($val->get('role'), 3)){
                $kp = $this->calculateKinerja($val);
                if(!is_null($kp))
                $kinerja[]=$kp;
            }
            
        }
        
        return $kinerja; 
        
    }
    
    function __destruct() {
        ;
    }
    
    
}
?>
