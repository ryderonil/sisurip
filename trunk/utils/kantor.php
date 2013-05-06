<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Kantor{
    
    
    public static function getNama(){
        $model = new Model();
        
        $kantor = $model->select('SELECT singkatan FROM kantor');
        foreach ($kantor as $data) {
             $kantor = $data['singkatan'];
        }
        unset($model);
        return $kantor;
    }
    
    public static function getKanwil(){
        $model = new Model();
        $kanwil = $model->select('SELECT es2 FROM kantor');
        foreach ($kanwil as $data) {
             $kanwil = $data['es2'];
        }
        $kanwil = (string)$kanwil;
        $kanwil = strlen($kanwil)==1?'0'.$kanwil:$kanwil;
        $config = array('host'=>DB_HOST,
                        'db_name'=>DB_NAME_KPPN,
                        'pass'=>DB_PASS,
                        'port'=>DB_PORT_KPPN,
                        'user'=>DB_USER);
        
        $con = new Koneksi();
        $sql = "SELECT nmkanwil FROM t_kanwil WHERE kdkanwil=:kdkanwil";
        $pdo = $con->getConnection($config);
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':kdkanwil',$kanwil);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $nmkanwil = 'KANTOR WILAYAH ';
        foreach ($data as $val){
            $nmkanwil .= strtoupper($val['nmkanwil']);
        }
        unset($con);
        unset($model);
        return $nmkanwil;
    }
    
    public static function getNamaKPPN(){
        $model = new Model();
        $kppn = $model->select('SELECT satker FROM kantor');
        foreach ($kppn as $data) {
             $kppn = $data['satker'];
        }
        $kppn = (string)$kppn;
        $len = strlen($kppn);
        if($len==1){
            $kppn = '00'.$kppn;
        }elseif ($len==2) {
            $kppn = '0'.$kppn;
        }
        $config = array('host'=>DB_HOST,
                        'db_name'=>DB_NAME_KPPN,
                        'pass'=>DB_PASS,
                        'port'=>DB_PORT_KPPN,
                        'user'=>DB_USER);
        
        $con = new Koneksi();
        $sql = "SELECT nmkppn FROM t_kppn WHERE kdkppn=:kdkppn";
        $pdo = $con->getConnection($config);
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':kdkppn',$kppn);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $nmkppn = 'KANTOR PELAYANAN PERBENDAHARAAN NEGARA ';
        foreach ($data as $val){
            $nmkppn .= strtoupper($val['nmkppn']);
        }
        unset($con);
        unset($model);
        return $nmkppn;
    }
    
    public static function getTelepon(){
        $model = new Model();
        
        $return = $model->select('SELECT telepon FROM kantor');
        foreach ($return as $data) {
             $return = $data['telepon'];
        }
        unset($model);
        return $return;
    }
    
    public static function getFaksimile(){
        $model = new Model();
        
        $return = $model->select('SELECT faksimile FROM kantor');
        foreach ($return as $data) {
             $return = $data['faksimile'];
        }
        unset($model);
        return $return;
    }
    
    public static function getEmail(){
        $model = new Model();
        
        $return = $model->select('SELECT email FROM kantor');
        foreach ($return as $data) {
             $return = $data['email'];
        }
        unset($model);
        return $return;
    }
    
    public static function getSmsGateway(){
        $model = new Model();
        
        $return = $model->select('SELECT sms FROM kantor');
        foreach ($return as $data) {
             $return = $data['sms'];
        }
        unset($model);
        return $return;
    }
    
    public static function getWebsite(){
        $model = new Model();
        
        $return = $model->select('SELECT website FROM kantor');
        foreach ($return as $data) {
             $return = $data['website'];
        }
        unset($model);
        return $return;
    }
    
    public static function getAlamat(){
        $model = new Model();
        
        $return = $model->select('SELECT alamat FROM kantor');
        foreach ($return as $data) {
             $return = $data['alamat'];
        }
        unset($model);
        return $return;
    }
}
?>
