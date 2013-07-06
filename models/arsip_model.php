<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Arsip_Model extends Model {

    //put your code here
    
    var $id_arsip;
    var $id_surat;
    var $lokasi;
    var $klas;
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }
    
    public function emptyNomor($no){
        if($no==''){
            return true;
        }
        
        return false;
    }


    public function getSurat($id, $surat){
        switch($surat){
            case 'SM':
                $sm = new Suratmasuk_Model();
                $sm->getSuratById($id);
                return $sm;
                break;
            case 'SK':
                $sk=new Suratkeluar_Model();
                return $sk->getSuratById($id, 'ubah');
                break;
            
        }
    }
    
    public function rekamArsip($data){
        return $this->insert('arsip', $data);
    }
    
    public function editArsip($data, $where){
        return $this->update('arsip', $data, $where);
    }
    
    public function getKlas(){
        $sql = "SELECT * FROM klasifikasi_arsip";
        return $this->select($sql);
    }

    public function getRak($kosong=null){
        $sql = "SELECT * FROM lokasi WHERE tipe=1";
        if(!is_null($kosong)){
                if($kosong) $sql .= " AND status='E'";
            }
        return $this->select($sql);
    }
    
    public function getBaris($parent=null,$kosong=null){
        if(!is_null($parent)){
            $sql = "SELECT * FROM lokasi WHERE tipe=2 AND parent=".$parent;
            if(!is_null($kosong)){
                if($kosong) $sql .= " AND status='E'";
            }
        }else{
            $sql = "SELECT * FROM lokasi WHERE tipe=2";
        }
        
        return $this->select($sql);
    }
    
    public function getBox($parent=null, $kosong=null){
        if(!is_null($parent)){
            $sql = "SELECT * FROM lokasi WHERE tipe=3 AND parent=".$parent;
            if(!is_null($kosong)){
                if($kosong) $sql .= " AND status='E'";
            }
        }else{
            $sql = "SELECT * FROM lokasi WHERE tipe=3";
        }
        
        return $this->select($sql);
    }
    
    public function getArsip($id, $tipe){
        $sql = "SELECT a.id_arsip as id_arsip,
                a.id_lokasi as id_lokasi,
                b.id_lokasi as box,
                c.id_lokasi as baris,
                d.id_lokasi as rak,
                a.jenis as klas
                FROM arsip a LEFT JOIN lokasi b ON a.id_lokasi = b.id_lokasi
                LEFT JOIN lokasi c ON b.parent = c.id_lokasi
                LEFT JOIN lokasi d ON c.parent = d.id_lokasi
                WHERE a.id_surat=".$id." AND a.tipe_surat='".$tipe."'";
        
        $data = $this->select($sql);
        foreach ($data as $val){
            $this->id_arsip = $val['id_arsip'];
            $this->id_surat = $id;
            $this->klas = $val['klas'];
            $this->lokasi = array($val['id_lokasi'],$val['rak'],$val['baris'],$val['box']);
        }
        return $this;
    }
    
    public function getArsipIkhtisar($key=null,$value=null){
        
        if(is_null($key) AND is_null($value)) {
            $sql = "SELECT a.id_arsip as id_arsip,
                a.id_surat as id_surat,
                a.tipe_surat as tipe_surat,
                a.id_lokasi as id_lokasi,
                b.id_lokasi as box,
                c.id_lokasi as baris,
                d.id_lokasi as rak,
                e.bagian as bagian,
                a.jenis as kd_klas,
                f.klasifikasi as klas
                FROM arsip a LEFT JOIN lokasi b ON a.id_lokasi = b.id_lokasi
                LEFT JOIN lokasi c ON b.parent = c.id_lokasi
                LEFT JOIN lokasi d ON c.parent = d.id_lokasi
                LEFT JOIN lokasi e ON d.id_lokasi = e.id_lokasi
                LEFT JOIN klasifikasi_arsip f ON a.jenis = f.id_klasarsip";
        }else{
            $sql = "SELECT a.id_arsip as id_arsip,
                a.id_surat as id_surat,
                a.tipe_surat as tipe_surat,
                a.id_lokasi as id_lokasi,
                b.id_lokasi as box,
                c.id_lokasi as baris,
                d.id_lokasi as rak,
                e.bagian as bagian,
                a.jenis as kd_klas,
                f.klasifikasi as klas
                FROM arsip a LEFT JOIN lokasi b ON a.id_lokasi = b.id_lokasi
                LEFT JOIN lokasi c ON b.parent = c.id_lokasi
                LEFT JOIN lokasi d ON c.parent = d.id_lokasi
                LEFT JOIN lokasi e ON d.id_lokasi = e.id_lokasi
                LEFT JOIN klasifikasi_arsip f ON a.jenis = f.id_klasarsip";
            if(is_int($value)){
                $sql .=" WHERE a.$key = $value";
            }  else {
                $sql .=" WHERE a.$key = '$value'";
            }
            
        }
        
        $data = $this->select($sql);
        $return = array();
        foreach ($data as $val){
            $arsip = new $this;
            $arsip->id_arsip = $val['id_arsip'];
            $arsip->id_surat = $val['id_surat'];
            $arsip->klas = $val['klas'];
            $arsip->lokasi = array('id'=>$val['id_lokasi'],'rak'=>$val['rak'],'baris'=>$val['baris'],'box'=>$val['box']);
            $arsip->bagian = $val['bagian'];
            $arsip->kd_klas = $val['kd_klas'];
            $arsip->tipe_surat = $val['tipe_surat'];
            $return[] = $arsip;
        }
        
        return $return;
    }
    
    public function getKurun($id_surat, $tipe){
        switch($tipe){
            case 'SM':
                $sql = "SELECT tgl_terima as tgl
                    FROM suratmasuk
                    WHERE id_suratmasuk=".$id_surat;
                break;
            case 'SK':
                $sql = "SELECT tgl_surat as tgl
                    FROM suratkeluar
                    WHERE id_suratkeluar=".$id_surat;
                break;
        }
        
        $data = $this->select($sql);
        $tgl = '';
        foreach ($data as $val){
            $tgl = substr($val['tgl'], 0,4);
        }
        
        return $tgl;
        
    }
    
    public function isAllowWrite($id, $tipe){
        $file = '';
        switch($tipe){
            case 'SM':
                $sm = new Suratmasuk_Model();
                $data = $sm->getSuratById($id);
                $file = $data->getFile(); 
                break;
            case 'SK':
                $sk = new Suratkeluar_Model();
                $data = $sk->getSuratById($id, 'ubah');
                $file = $data->getFile();
                break;
            default:
                throw new Exception('parameter yang dimasukkan salah!');
                break;
        }
        if($file=='' OR $file==null) return false;
        $ext = end(explode('.', $file));
        if($ext!='pdf') return false;
        if(!file_exists('arsip/'.$file)) return false;
        return true;
    }
    
    /*
     * cek apakah sudah diarsipkan
     * @param id_surat, tipe surat[SM,SK]
     * return boolean
     */
    public function isHasBeenArchived($id, $tipe='SM'){
        $sql = 'SELECT COUNT(*) as jml FROM arsip WHERE id_surat='.$id.' AND tipe_surat="'.$tipe.'"';
        $data = $this->select($sql);
        foreach ($data as $val){
            if(((int)$val['jml'])>0) return true;
        }
        
        return false;
    }


    function __destruct() {
        ;
    }
}
?>
