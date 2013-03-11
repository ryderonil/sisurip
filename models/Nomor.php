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
    
    public function __set($name, $value) {
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


    public function __get($name) {
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
    public function generateNumber($tipeNomor, $tipeSurat = null){
        
        $tipe = null;
        $this->setTanggal();
        //$this->getKodeSuratKeluar();
        if($tipeNomor=='SM'){
            $this->nomor = $this->createAgendaSuratMasuk();
        }else{
            $this->nomor = $this->createAgendaSuratKeluar($tipeSurat);
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
    
    private function createAgendaSuratKeluar($tipeSurat){
        
    }
    
    public function getNomorAgenda(){
        
    }
    
    public function getNumber(){
        
    }
}
?>
