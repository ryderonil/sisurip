<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suratkeluar_Model extends Model {

    //put your code here
    var $lastId;

    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }

    public function showAll() {
        $sql = "SELECT a.id_suratkeluar as id_suratkeluar,
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
          JOIN tipe_naskah f ON a.tipe = f.id_tipe ORDER BY a.id_suratkeluar DESC";

        return $this->select($sql);
    }

    public function rekamSurat($data) {
        
        $rekam = $this->insert('suratkeluar', $data);
        if($rekam){
            return true;
        }else{
            return false;
        }
    }

    public function getSuratKeluarById($id, $aksi) {
        if ($aksi == 'detil') {
            $sql = "SELECT a.id_suratkeluar as id_suratkeluar,
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
                JOIN tipe_naskah f ON a.tipe = f.id_tipe WHERE a.id_suratkeluar=" . $id;
        }elseif ($aksi=='ubah') {
            $sql='SELECT * FROM suratkeluar WHERE id_suratkeluar='.$id;
        }


        return $this->select($sql);
    }
    
    public function get($table){
        return $this->select('SELECT * FROM '.$table);
    }
    
    public function editSurat($data,$where){
        $this->update('suratkeluar', $data, $where);
    }
    
    public function remove($where){
        /*
         * ntar hapus juga menghapus semua hal yg 
         * berhubungan dengan surat ini, termasuk lampiran dsb
         */
        $this->delete('suratkeluar', $where);
    }
    
    public function uploadFile($data,$where){
    
        $this->update('suratkeluar', $data, $where);
    }
    
    public function addRevisi($data){
        $this->insert('revisisurat', $data);
    }
    
    public function lastIdInsert($tipe){
        $sql = "SELECT MAX(id_suratkeluar) as id FROM suratkeluar WHERE tipe=".$tipe;
        $data = $this->select($sql);
        
        foreach ($data as $val){
            $this->lastId = $val['id'];
        }
        
        return $this->lastId;
        
    }
    
    public function getUser($id){
        $user = '';
        $datas = $this->select("SELECT user FROM suratkeluar WHERE id_suratkeluar=".$id);
        foreach ($datas as $val){
            $user = $val['user'];
        }
        $datab = $this->select("SELECT id_user, role, bagian FROM user WHERE username='".$user."'");
        $user =array();
        foreach ($datab as $val){
            $user[0] = $val['id_user'];
            $user[1] = $val['role'];
            $user[2] = $val['bagian'];
        }
        
        return $user;
    }
    
    public function getHistoriRevisi($id){
        
        $sql = "SELECT a.id_revisi as id_revisi, 
            a.catatan as catatan, 
            b.namaPegawai as user, 
            a.file as file, 
            a.time as time
            FROM revisisurat a LEFT JOIN user b
            ON a.user=b.username
            WHERE a.id_surat=".$id;
        $data = $this->select($sql);
        return $data;
    }
    
    

}

?>
