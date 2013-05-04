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
    
    public function getKlas(){
        $sql = "SELECT * FROM klasifikasi_arsip";
        return $this->select($sql);
    }

    public function getRak(){
        $sql = "SELECT * FROM lokasi WHERE tipe=1";
        return $this->select($sql);
    }
    
    public function getBaris($parent=null){
        if(!is_null($parent)){
            $sql = "SELECT * FROM lokasi WHERE tipe=2 AND parent=".$parent;
        }else{
            $sql = "SELECT * FROM lokasi WHERE tipe=2";
        }
        
        return $this->select($sql);
    }
    
    public function getBox($parent=null){
        if(!is_null($parent)){
            $sql = "SELECT * FROM lokasi WHERE tipe=3 AND parent=".$parent;
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
                    WHERE id_suratmasuk=".$id_surat;
                break;
        }
        
        $data = $this->select($sql);
        $tgl = '';
        foreach ($data as $val){
            $tgl = substr($val['tgl'], 0,4);
        }
        
        return $tgl;
        
    }
    
    public function getArsipByLokasi($lokasi){
        
        $sql = "SELECT id_lokasi FROM lokasi 
                WHERE lokasi='".$lokasi[3]."'
                AND parent=(SELECT id_lokasi FROM lokasi WHERE lokasi='".$lokasi[2]."'
                AND parent=(SELECT id_lokasi FROM lokasi WHERE lokasi='".$lokasi[1]."' AND bagian='".$lokasi[0]."'))";        
        
        $datai = $this->select($sql);
        $id = 0;
        foreach ($datai as $val){
            $id = $val['id_lokasi'];
        }
        
        $darsip = array();
        $sql = "SELECT a.id_arsip as id_arsip,
            a.id_surat as id_surat,
            b.no_surat as no_surat,
            b.tgl_surat as tgl_surat,
            d.nama_satker as alamat,
            a.tipe_surat as tipe, 
            c.tipe_naskah as tipe_naskah
            FROM arsip a LEFT JOIN suratmasuk b ON a.id_surat=b.id_suratmasuk             
            LEFT JOIN tipe_naskah c ON a.jenis=c.id_tipe
            LEFT JOIN alamat d ON b.asal_surat=d.kode_satker
            WHERE id_lokasi=".$id." AND a.tipe_surat='SM'";        
        
        $datasm = $this->select($sql);
        foreach ($datasm as $val){
            $arsip = new Arsip_Model();
            $arsip->id_arsip = $val['id_arsip'];
            $arsip->id_surat = $val['id_surat'];
            $arsip->no_surat = $val['no_surat'];
            $arsip->tgl_surat = $val['tgl_surat'];
            $arsip->alamat = $val['alamat'];
            $arsip->tipe = $val['tipe'];
            $arsip->klas = $val['tipe_naskah'];            
            $darsip[] = $arsip;
        }
        
        $sql = "SELECT a.id_arsip as id_arsip,
            a.id_surat as id_surat,
            b.no_surat as no_surat,
            b.tgl_surat as tgl_surat,
            d.nama_satker as alamat,
            a.tipe_surat as tipe, 
            c.tipe_naskah as tipe_naskah
            FROM arsip a LEFT JOIN suratkeluar b ON a.id_surat=b.id_suratkeluar             
            LEFT JOIN tipe_naskah c ON a.jenis=c.id_tipe
            LEFT JOIN alamat d ON b.tujuan=d.kode_satker
            WHERE id_lokasi=".$id." AND a.tipe_surat='SK'";        
        
        $datask = $this->select($sql);
        foreach ($datask as $val){
            $arsip = new Arsip_Model();
            $arsip->id_arsip = $val['id_arsip'];
            $arsip->id_surat = $val['id_surat'];
            $arsip->no_surat = $val['no_surat'];
            $arsip->tgl_surat = $val['tgl_surat'];
            $arsip->alamat = $val['alamat'];
            $arsip->tipe = $val['tipe'];
            $arsip->klas = $val['tipe_naskah'];            
            $darsip[] = $arsip;
        }
        
        return $darsip;     
        
    }
    
    public function getArsipByKlas($klas){
        
        $sql = "SELECT id_klasarsip FROM klasifikasi_arsip
                WHERE klasifikasi='".$klas."'";        
        
        $datai = $this->select($sql);
        $id = 0;
        foreach ($datai as $val){
            $id = $val['id_klasarsip'];
        }
        
        $darsip = array();
        $sql = "SELECT a.id_arsip as id_arsip,
            a.id_surat as id_surat,
            b.no_surat as no_surat,
            b.tgl_surat as tgl_surat,
            d.nama_satker as alamat,
            a.tipe_surat as tipe, 
            c.tipe_naskah as tipe_naskah
            FROM arsip a LEFT JOIN suratmasuk b ON a.id_surat=b.id_suratmasuk             
            LEFT JOIN tipe_naskah c ON a.jenis=c.id_tipe
            LEFT JOIN alamat d ON b.asal_surat=d.kode_satker
            WHERE a.jenis=".$id." AND a.tipe_surat='SM'";        
        
        $datasm = $this->select($sql);
        foreach ($datasm as $val){
            $arsip = new Arsip_Model();
            $arsip->id_arsip = $val['id_arsip'];
            $arsip->id_surat = $val['id_surat'];
            $arsip->no_surat = $val['no_surat'];
            $arsip->tgl_surat = $val['tgl_surat'];
            $arsip->alamat = $val['alamat'];
            $arsip->tipe = $val['tipe'];
            $arsip->klas = $val['tipe_naskah'];            
            $darsip[] = $arsip;
        }
        
        $sql = "SELECT a.id_arsip as id_arsip,
            a.id_surat as id_surat,
            b.no_surat as no_surat,
            b.tgl_surat as tgl_surat,
            d.nama_satker as alamat,
            a.tipe_surat as tipe, 
            c.tipe_naskah as tipe_naskah
            FROM arsip a LEFT JOIN suratkeluar b ON a.id_surat=b.id_suratkeluar             
            LEFT JOIN tipe_naskah c ON a.jenis=c.id_tipe
            LEFT JOIN alamat d ON b.tujuan=d.kode_satker
            WHERE a.jenis=".$id." AND a.tipe_surat='SK'";        
        
        $datask = $this->select($sql);
        foreach ($datask as $val){
            $arsip = new Arsip_Model();
            $arsip->id_arsip = $val['id_arsip'];
            $arsip->id_surat = $val['id_surat'];
            $arsip->no_surat = $val['no_surat'];
            $arsip->tgl_surat = $val['tgl_surat'];
            $arsip->alamat = $val['alamat'];
            $arsip->tipe = $val['tipe'];
            $arsip->klas = $val['tipe_naskah'];            
            $darsip[] = $arsip;
        }
        
        return $darsip;
        
        
    }
}
?>
