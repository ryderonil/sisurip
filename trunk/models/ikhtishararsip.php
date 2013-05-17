<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class IkhtisharArsip extends Model{
    
    private $id_arsip;
    private $id_surat; //jenis surat/sm atau sk
    private $lokasi;
    private $nomor_surat;
    private $perihal;
    private $diarsipkan; //tgl
            
    
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * setter
     */
    public function set($attr, $value){
        switch ($attr){
            case 'id_arsip':
                $this->id_arsip = $value;
                break;
            case 'id_surat':
                $this->id_surat = $value;
                break;
            case 'lokasi':
                $this->lokasi = $value;
                break;
            case 'nomor_surat':
                $this->nomor_surat = $value;
                break;
            case 'perihal':
                $this->perihal = $value;
                break;
            case 'diarsipkan':
                $this->diarsipkan = $value;
                break;
        }
    }
    
    /*
     * getter
     */
    public function get($attr){
        switch ($attr){
            case 'id_arsip':
                return $this->id_arsip;
                break;
            case 'id_surat':
                return $this->id_surat;
                break;
            case 'lokasi':
                return $this->lokasi;
                break;
            case 'nomor_surat':
                return $this->nomor_surat;
                break;
            case 'perihal':
                return $this->perihal;
                break;
            case 'diarsipkan':
                return $this->diarsipkan;
                break;
        }
    }
    
    /*
     * fungsi ikhtisar arsip
     * 
     */
    public function generateIkhtisharArsip($key=null,$value=null){
        $lokasi = new Lokasi();
        $arsip = new Arsip_Model();
        $ikhtisar = array();
        if(is_null($key) AND is_null($value)){
            $data = $arsip->getArsipIkhtisar();
        }else{
            $data = $arsip->getArsipIkhtisar($key,$value);
        }
//        var_dump($data);
        foreach ($data as $val){
            if(count($ikhtisar)==0){
                $ikhtisar[] = array('bagian'=>$val->bagian);                
            }else{
                $count = count($ikhtisar);
                $ketemu = false;
                for($i=0;$i<$count;$i++){
                    if(($ikhtisar[$i]['bagian'])==$val->bagian){
                        $ketemu=true;
                    }
                }
                
                if(!$ketemu){
                    $ikhtisar[] = array('bagian'=>$val->bagian);
                }else{
                    $ketemu = false;
                }
            }
        }
//        var_dump($ikhtisar);
        
        for($i=0;$i<count($ikhtisar);$i++){            
            $ikhtisar[$i]['jumlah'] = 0;
            $ikhtisar[$i]['kurun'] =array();
            $ikhtisar[$i]['lokasi'] = array();
            $ikhtisar[$i]['klas'] = array();            
            foreach ($data as $val){
//                var_dump($ikhtisar[$i]);
                if($ikhtisar[$i]['bagian']==$val->bagian){
                    
                    //lokasi arsip
                    foreach ($data as $value){
                        if(count($ikhtisar[$i]['lokasi'])==0){                            
                            $ikhtisar[$i]['lokasi'][] = $lokasi->getLokasiBox($value->lokasi['box'],$ikhtisar[$i]['bagian']);
                            $ikhtisar[$i]['jumlah']++;
                        }else{
                            $ketemu = false;
                            for($a=0;$a<count($ikhtisar[$i]['lokasi']);$a++){
                                if($ikhtisar[$i]['lokasi'][$a]==$lokasi->getLokasiBox($value->lokasi['box'],$ikhtisar[$i]['bagian'])){
                                    $ketemu = true;
                                }
                            }
                            
                            if(!$ketemu){
                                $ikhtisar[$i]['jumlah']++;
                                $ikhtisar[$i]['lokasi'][] = $lokasi->getLokasiBox($value->lokasi['box'],$ikhtisar[$i]['bagian']);
                            }else{
                                $ketemu=false;
                            }
                        }
                        
                        //kelas arsip
                        if(count($ikhtisar[$i]['klas'])==0){
//                            echo $ikhtisar[$i]['bagian'].$val->bagian;
                            if($ikhtisar[$i]['bagian']==$value->bagian){
                                $ikhtisar[$i]['klas'][] = $value->klas;
                            }
                            
                        }else{
                            $ketemu = false;
                            for($a=0;$a<count($ikhtisar[$i]['klas']);$a++){
                                if($ikhtisar[$i]['klas'][$a]==$value->klas){
                                    $ketemu = true;
                                }
                            }
                            
                            if(!$ketemu){
//                                echo $ikhtisar[$i]['bagian'].$val->bagian;
                                if($ikhtisar[$i]['bagian']==$value->bagian){
                                    $ikhtisar[$i]['klas'][] = $value->klas;
                                }
                                
                            }else{
                                $ketemu=false;
                            }
                        }
                        
                        //kurun
                        if(count($ikhtisar[$i]['kurun'])==0){
//                            echo $this->model->getKurun($value->id_surat,$value->tipe_surat);
                            if($ikhtisar[$i]['bagian']==$value->bagian){
                                $ikhtisar[$i]['kurun'][] = $arsip->getKurun($value->id_surat,$value->tipe_surat);
                            }
                            
                        }else{
                            $ketemu = false;
                            for($a=0;$a<count($ikhtisar[$i]['kurun']);$a++){
                                if($ikhtisar[$i]['kurun'][$a]==$arsip->getKurun($value->id_surat,$value->tipe_surat)){
                                    $ketemu = true;
                                }
                            }
                            
                            if(!$ketemu){
                                if($ikhtisar[$i]['bagian']==$value->bagian){
                                    $ikhtisar[$i]['kurun'][] = $arsip->getKurun($value->id_surat,$value->tipe_surat);
                                }
                                
                            }else{
                                $ketemu=false;
                            }
                        }
                        
                    }
                    
                }
            }
        }
        
        return $ikhtisar;
    }
    
    public function getArsipByKlasifikasi($klas){
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
    
    public function getArsipbyLokasi($lokasi){
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
    
    
}
?>
