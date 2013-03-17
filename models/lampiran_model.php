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
class Lampiran_Model extends Model {

    //put your code here

    public function __construct() {
        //echo 'ini adalah model</br>';
        parent::__construct();
    }
    
    public function addLampiran($data){
        return $this->insert('lampiran', $data);
    }
    
    public function deleteLampiran($where){
        return $this->delete('lampiran', $where);
    }
    
    public function editLampiran($data, $where){
        return $this->update('lampiran', $data, $where);
    }
    
    public function getLampiran($id=null){
        
        if(!is_null($id)){
            $sql = 'SELECT * FROM lampiran WHERE id_lamp='.$id;
        }else{
            $sql = 'SELECT * FROM lampiran';
        }
        
        return $this->select($sql);
    }
    
    public function getTypeLampiran(){
        return $this->select('SELECT * FROM tipe_naskah');
    }

}

?>
