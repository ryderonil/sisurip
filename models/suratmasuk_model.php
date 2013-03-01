<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of suratmasuk_model
 *
 * @author aisyah
 */
class Suratmasuk_Model extends Model{
    //put your code here
    
    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }
    
    public function showAll(){
        
        $sql = "SELECT * FROM suratmasuk";        
        
        return $this->select($sql);
    }
    
    public function edit(){
        
    }
    
    public function remove(){
        
    }
    
    public function input(){
        
    }
    
    public function getSuratMasukById($id){
        
        $sql = "SELECT * FROM suratmasuk WHERE id_surat= :id";
        
        $sth = $this->prepare($sql);
        
        $sth->bindValue(":id", $id);
        $sth->execute();
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        return $sth->fetchAll();
    }
}

?>
