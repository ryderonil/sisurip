<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Helper_Model extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function lookup($keyword){
        echo $keyword;
        $sql = "SELECT kode_satker, nama_satker FROM alamat WHERE nama_satker LIKE '%$keyword%'";
        
        return $this->select($sql);
    }
    
    function getAlamat(){
        $admin = new Admin_Model();
        return $admin->getAlamat();
    }
    
}
?>
