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
    
    public function addNotifikasi($data){
        $insert = $this->insert('notifikasi', $data);
        if($insert){
            return true;
        }
        return false;
    }
    
    public function getNotifikasi($id_user){
        
    }
    
    public function isRead($id_notif){
        
    }
    
}
?>
