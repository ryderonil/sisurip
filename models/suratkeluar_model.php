<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suratkeluar_Model extends Model{
    //put your code here
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
        
    }  
    
    
    public function showAll(){
      $sql= "SELECT a.id_suratkeluar as id_suratkeluar,
          a.rujukan as rujukan,
          a.no_surat as no_surat,
          a.tgl_surat as tgl_surat,
          b.nama_satker as tujuan,
          a.perihal as perihal,
          c.sifat_surat as sifat,
          d.klasifikasi as jenis,
          a.lampiran as lampiran,
          a.file as file,
          e.status as status,
          f.tipe_naskah as tipe
          FROM suratkeluar a JOIN alamat b ON a.tujuan = b.kode_satker
          JOIN sifat_surat c ON a.sifat = c.kode_sifat
          JOIN klasifikasi_surat d ON a.jenis = d.kode_klassurat
          JOIN status e ON a.status = e.id_status
          JOIN tipe_naskah f ON a.tipe = f.id_tipe";
      
      return $this->select($sql);
    }
    
    public function rekamSurat($data){
        $this->insert('suratkeluar', $data);
    }
    
    public function getSuratKeluarById($id){
        $sql= "SELECT a.id_suratkeluar as id_suratkeluar,
          a.rujukan as rujukan,
          a.no_surat as no_surat,
          a.tgl_surat as tgl_surat,
          b.nama_satker as tujuan,
          a.perihal as perihal,
          c.sifat_surat as sifat,
          d.klasifikasi as jenis,
          a.lampiran as lampiran,
          a.file as file,
          e.status as status,
          f.tipe_naskah as tipe
          FROM suratkeluar a JOIN alamat b ON a.tujuan = b.kode_satker
          JOIN sifat_surat c ON a.sifat = c.kode_sifat
          JOIN klasifikasi_surat d ON a.jenis = d.kode_klassurat
          JOIN status e ON a.status = e.id_status
          JOIN tipe_naskah f ON a.tipe = f.id_tipe WHERE a.id_suratkeluar=".$id;
        
        return $this->select($sql);
    }
}
?>
