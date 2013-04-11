<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Nomor extends Model{
    
    private $nomor;
    private $perihal;
    private $tgl;
    private $tujuan;
    
    public function __construct() {
        parent::__construct();
        //echo 'nomor';
    }
    
    public function generateAgenda(){
        
    }
    
    public function set($name, $value) {
        switch($name){
            case 'nomor':
                $this->nomor = $value;
                break;
            case 'perihal':
                $this->perihal = $value;
                break;            
            case 'tujuan':
                $this->tujuan = $value;
                break;
        }
    }
    
    public function setTanggal(){        
        $this->tgl = Tanggal::getTglSekarang();
    }


    public function get($name) {
        switch($name){
            case 'nomor':
                return $this->nomor;
                break;
            case 'perihal':
                return $this->perihal;
                break;
            case 'tgl':
                return $this->tgl;
                break;
            case 'tujuan':
                return $this->tujuan;
                break;
        }
        return false;
    }
    
    /*
     * menciptakan nomor
     * @param tipenomor (SM=>agenda surat masuk, SK=agenda surat keluar)
     * @param tipesurat => sesuai dengan tipe dan kode surat
     */
    public function generateNumber($tipeNomor, $bagian = null){
        
        //$tipe = $tipeSurat;
        $this->setTanggal();
        //$this->getKodeSuratKeluar();
        if($tipeNomor=='SM'){
            $this->nomor = $this->createAgendaSuratMasuk();
        }else{
            $this->nomor = $this->createAgendaSuratKeluar($tipeNomor, $bagian);
        }
        return $this->nomor;
    }
    
    private function createAgendaSuratMasuk(){
        $lastid = $this->select('SELECT MAX(id_suratmasuk) as id FROM suratmasuk');     
        
        foreach ($lastid as $id){
            $lastid = $id['id'];
        }
        
        //$data = $this->select('SELECT no_agenda FROM suratmasuk WHERE id_suratmasuk='.$lastid);
        $data = $this->select('SELECT no_agenda FROM suratmasuk 
                    WHERE id_suratmasuk = (SELECT MAX(id_suratmasuk) FROM suratmasuk )');
        $agenda = null;
        foreach ($data as $value){
            $agenda = $value['no_agenda'];
        }
        
        $agenda = substr($agenda, 2);
        
        $agenda = (int) $agenda;
        $length = 4-strlen($agenda);
        //echo $length;
        $agenda = $agenda+1;
        
        
        for($i=0;$i<$length;$i++){
            $agenda = '0'.$agenda;
        }
        $curr_agenda = 'SM'.($agenda);
        //echo $curr_agenda;
        
        return $curr_agenda;
    }
    
    private function createAgendaSuratKeluar($tipeSurat,$bagian){
        $agenda = 0;
        $admin = new Admin_Model();        
        $nomor = $admin->getNomor($bagian);
        $kd_tipe = "SELECT kode_naskah FROM tipe_naskah WHERE id_tipe=".$tipeSurat;
        $datat = $this->select($kd_tipe);
        foreach ($datat as $val){
            $kd_tipe = $val['kode_naskah'];
        }
        $sql = "SELECT no_surat FROM suratkeluar WHERE tipe=".$tipeSurat." AND no_surat<>''";
        $datan = $this->select($sql);
        $arr_no = array();
        foreach ($datan as $val){
            $temp = explode("-", $val['no_surat']);
            $temp = $temp[1];
            $no = explode("/", $temp);
            $no = $no[0];
            $arr_no[] = (int) $no;
        }
        //var_dump($arr_no);
//        $agenda = max($arr_no);
        //var_dump($agenda);
//        $lastid = $this->select('SELECT MAX(id_suratkeluar) as id FROM suratkeluar WHERE tipe='.$tipeSurat);
//        $count = count($lastid);
        $count = count($arr_no);
        if($count>0){
            $agenda = max($arr_no);
//            foreach ($lastid as $id){
//                $lastid = $id['id']; //cek apakah hasilnya null, jika null maka agenda=1
//            }
            
//            $data = $this->select('SELECT no_surat FROM suratkeluar
//                    WHERE id_suratkeluar = '.$lastid);
//            $count = count($data);
//            if($count>0){
//                foreach ($data as $val){
//                    $data = $val['no_surat']; //cek apakah hasilnya null, jika null maka nilai agenda=1;
//                }
//                $temp = explode("-", $data);
//                $temp = explode("/", $temp[1]);
                //var_dump($temp);
//                $agenda = $temp[0];           

//                $agenda = (int) $agenda;
//            }
            
        }
        //var_dump($lastid);
        
        
        //$data = $this->select('SELECT no_agenda FROM suratmasuk WHERE id_suratmasuk='.$lastid);
        
        //var_dump($data);
        
                
        $length = 4-strlen($agenda);
        //echo $length;
        $agenda = $agenda+1;
        
        
        for($i=0;$i<$length;$i++){
            $agenda = '0'.$agenda;
        }
        
        $nosrt = $kd_tipe."-".$agenda.$nomor;
        
        return $nosrt;
        
    }
    
    public function getNomorAgenda(){
        
    }
    
    public function getNumber(){
        
    }
}
?>
