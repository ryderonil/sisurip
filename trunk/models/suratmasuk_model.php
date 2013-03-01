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
    
    public function edit($id){
        return $this->select("SELECT * FROM suratmasuk WHERE id_suratmasuk=:id", array("id"=>$id));
    }
    
    public function remove($id){
        
    }
    
    public function input(){
        
        
    }
    
    public function editSurat(){
        $data = array(
            "tgl_terima"=>$_POST['tgl_terima'],
            "tgl_surat"=>$_POST['tgl_surat'],
            "no_surat"=>$_POST['no_surat'],
            "asal_surat"=>$_POST['asal_surat'],
            "perihal"=>$_POST['perihal']
        );
        
        $id = $_POST['id'];
        $where = "id_suratmasuk = '".$id."'";
        echo $where;
        $this->update("suratmasuk", $data, $where);
        header('location:../suratmasuk/showall');
    }
    
    public function getSuratMasukById($id){ //fungsi ini mgkn tidak diperlukan
        
        $sql = "SELECT * FROM suratmasuk WHERE id_surat= :id";
        
        $sth = $this->prepare($sql);
        
        $sth->bindValue(":id", $id);
        $sth->execute();
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        return $sth->fetchAll();
    }
}

?>
