<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Suratkeluar_Model extends Surat{

    //put your code here
    var $lastId;
    private $jns_surat;
    private $user;
    private $rujukan;

    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }    
       
    public function setTipeSurat($value){
        $this->jns_surat = $value;
    }
    
    public function getTipeSurat(){
        return $this->jns_surat;
    }
    
    public function setUserCreate($value){
        $this->user = $value;
    }
    
    public function getUserCreate(){
        return $this->user;
    }
    
    public function setRujukan($value){
        $this->rujukan = $value;
    }
    
    public function getRujukan(){
        return $this->rujukan;
    }

    public function showAll($limit=null,$batas=null) {
        @Session::createSession();
        $role = Session::get('role');
        $bagian = Session::get('bagian');
        $user = Session::get('user');
        if((Auth::isRole($role, 2) AND !Auth::isBagian($bagian, 1) ) ){
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
            FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan = b.kode_satker
            LEFT JOIN sifat_surat c ON a.sifat = c.kode_sifat
            LEFT JOIN klasifikasi_surat d ON a.jenis = d.kode_klassurat
            LEFT JOIN status e ON a.status = e.id_status
            LEFT JOIN tipe_naskah f ON a.tipe = f.id_tipe 
            LEFT JOIN notifikasi g ON a.id_suratkeluar = g.id_surat
            WHERE g.jenis_surat='SK' AND g.id_user=".User::getIdUser($user)."
            GROUP BY a.id_suratkeluar ORDER BY a.id_suratkeluar DESC";
        }elseif(Auth::isRole($role, 3) ){
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
            FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan = b.kode_satker
            LEFT JOIN sifat_surat c ON a.sifat = c.kode_sifat
            LEFT JOIN klasifikasi_surat d ON a.jenis = d.kode_klassurat
            LEFT JOIN status e ON a.status = e.id_status
            LEFT JOIN tipe_naskah f ON a.tipe = f.id_tipe 
            WHERE a.user='".$user."'
            GROUP BY a.id_suratkeluar ORDER BY a.id_suratkeluar DESC";
            
        }else{
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
        }
        
//        var_dump($sql);
        if(!is_null($limit) AND !is_null($batas)){
            $sql .= " LIMIT $limit,$batas";
        }
        $data = $this->select($sql);
        $surat = array();
        foreach ($data as $value){
            $obj = new $this;
            $obj->setId($value['id_suratkeluar']);
            $obj->setRujukan($value['rujukan']);
            $obj->setNomor($value['no_surat']);
            $obj->setTglSurat($value['tgl_surat']);
            $obj->setAlamat($value['tujuan']);
            $obj->setPerihal($value['perihal']);
            $obj->setSifat($value['sifat']);
            $obj->setJenis($value['jenis']);
            $obj->setJmlLampiran($value['lampiran']);
            $obj->setFile($value['file']);
            $obj->setStatus($value['status']);
            $obj->setTipeSurat($value['tipe']);
            $surat[] = $obj;
        }

        return $surat;
    }

    public function input($data=null) {
        
        $rekam = $this->insert('suratkeluar', $data);
        if($rekam){
            return true;
        }else{
            return false;
        }
    }

    public function getSuratById($id=null, $aksi=null) {
        $sql = '';
        if ($aksi == 'detil') {
            $sql = "SELECT a.id_suratkeluar as id_suratkeluar,
                a.rujukan as rujukan,
                a.no_surat as no_surat,
                a.tgl_surat as tgl_surat,
                b.nama_satker as tujuan,
                a.perihal as perihal,
                a.user as user,
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
//        var_dump($sql);
        $data = $this->select($sql);
//        var_dump($data);
        foreach ($data as $value){
            $this->setId($value['id_suratkeluar']);
            $this->setRujukan($value['rujukan']);
            $this->setNomor($value['no_surat']);
            $this->setTglSurat($value['tgl_surat']);
            $this->setAlamat($value['tujuan']);
            $this->setPerihal($value['perihal']);
            $this->setSifat($value['sifat']);
            $this->setJenis($value['jenis']);
            $this->setJmlLampiran($value['lampiran']);
            $this->setTipeSurat($value['tipe']);
            $this->setFile($value['file']);
            $this->setStatus($value['status']);
            $this->setUserCreate($value['user']);
        }
//        var_dump($this->getId());
        return $this;
    }
    
    public function get($table){
        return $this->select('SELECT * FROM '.$table);
    }
    
    public function editSurat($data=null,$where=null){
        return $this->update('suratkeluar', $data, $where);
    }
    
    public function remove($id=null){
        /*
         * ntar hapus juga menghapus semua hal yg 
         * berhubungan dengan surat ini, termasuk lampiran dsb
         */
//        echo $where;
        $sk = $this->getSuratById($id);
        if(file_exists('arsip/'.$sk->getFile())) unlink('arsip/'.$sk->getFile()); //hapus file surat
        $where = ' id_suratkeluar=' . $id; 
        $sql = "SELECT file FROM lampiran WHERE id_surat=".$id." AND jns_surat='SK'";
        $datalamp = $this->select($sql);
        foreach ($datalamp as $val){
            if(file_exists('arsip/'.$val['file'])) unlink('arsip/'.$val['file']); //hapus file lampiran
        }
        
        $sql = "SELECT file FROM revisisurat WHERE id_surat=".$id;
        $datarev = $this->select($sql);
        foreach ($datarev as $val){
            if(file_exists('arsip/'.$val['file'])) unlink('arsip/'.$val['file']); //hapus file revisi
        }
        $this->delete('suratkeluar', $where);
    }
    
    public function uploadFile($data,$where){
    
        $this->update('suratkeluar', $data, $where);
    }
    
    public function addRevisi($data){
        return $this->insert('revisisurat', $data);
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
            WHERE a.id_surat=".$id." ORDER BY a.time DESC";
        $data = $this->select($sql);
        return $data;
    }
    
    public function getJmlRevisi($id){
        $sql = "SELECT COUNT(*) as jumlah FROM revisisurat WHERE id_surat=".$id;
        $data = $this->select($sql);
        $jml=0;
        foreach ($data as $val){
            $jml = $val['jumlah'];
        }
        
        return $jml;
        
    }


    function __destruct() {
        ;
    }
    

}

?>
