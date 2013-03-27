<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Notifikasi extends Model{
    
    private $id_notif;
    private $id_surat;
    private $jenis_surat;
    private $id_user;
    private $stat_notif;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function set($attr, $value){
        switch($attr){
            case 'id_notif':
                $this->id_notif=$value;
                break;
            case 'id_surat':
                $this->id_surat=$value;
                break;
            case 'jenis_surat';
                $this->jenis_surat=$value;
                break;
            case 'id_user':
                $this->id_user=$value;
                break;
            case 'stat_notif':
                $this->stat_notif=$value;
                break;
        }
    }
    
    public function get($attr){
        switch($attr){
            case 'id_notif':
                return $this->id_notif;
                break;
            case 'id_surat':
                return $this->id_surat;
                break;
            case 'jenis_surat';
                return $this->jenis_surat;
                break;
            case 'id_user':
                return $this->id_user;
                break;
            case 'stat_notif':
                return $this->stat_notif;
                break;
        }
    }
    
    public function addNotifikasi(){
        $data =array(
                'id_surat'=>$this->get('id_surat'),
                'jenis_surat'=>$this->get('jenis_surat'),
                'id_user'=>$this->get('id_user'),
                'stat_notif'=>$this->get('stat_notif')
            );
        $insert = $this->insert('notifikasi', $data);
        if($insert){
            return true;
        }
        return false;
    }
    
    public function getNotifikasi($role,$bagian){
        
    }
    
    public function isRead($id_surat, $user, $jenis_surat){
        $id_user=0;
        if(is_numeric($user)){
            $id_user=$user;
            //echo $id_user.'.</br>';
        }else{
            $sql = "SELECT id_user FROM user WHERE username = :username";            
            $sth = $this->prepare($sql);
            $sth->bindValue(':username',$user);
            $sth->execute();
            $data = $sth->fetchAll(PDO::FETCH_OBJ);
            foreach ($data as $value) {
                $id_user = $value->id_user;
            }
            //echo $id_user.'</br>';
        }
        //echo $id_surat.','.$jenis_surat.','.$user.','.$id_user.'</br>';
        $sql = "SELECT * FROM notifikasi WHERE id_surat=:id_surat AND id_user=:id_user AND jenis_surat=:jenis_surat AND stat_notif=1";
        $sth = $this->prepare($sql);
        $sth->bindValue(':id_surat',$id_surat);
        $sth->bindValue(':id_user',$id_user);
        $sth->bindValue(':jenis_surat',$jenis_surat);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $count = count($data);
        //echo $count;
        if($count>0) return true;
        return false;
    }
    
    /*
     * bisa nama, bisa id
     */
    public static function getJumlahNotifikasi($id_user){
        $pdo = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        $id_user = $id_user;
        $sql ='';
        $count = 0;
        if(is_numeric($id_user)){
            $sql = "SELECT COUNT(stat_notif) as jml FROM notifikasi WHERE id_user=:id_user";
        }else{
            $sql = "SELECT id_user FROM user WHERE username = :username";            
            $sth = $pdo->prepare($sql);
            $sth->bindValue(':username',$id_user);
            $sth->execute();
            $data = $sth->fetchAll(PDO::FETCH_OBJ);
            foreach ($data as $value) {
                $id_user = $value->id_user;
            }
            $sql = "SELECT COUNT(stat_notif) as jml FROM notifikasi WHERE id_user=:id_user";
        }
        
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':id_user',$id_user);
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_OBJ);
        foreach ($data as $value) {
            $count = $value->jml;
        }
        
        return $count;
    }
    
}
?>
