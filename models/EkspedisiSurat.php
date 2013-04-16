<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EkspedisiSurat extends Model{
    
    private $dataEks = array();
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getData(){
        return $this->dataEks;
    }

    public function displayEkspedisi($data){    
        
        foreach ($data as $val){
            $sql = "SELECT * FROM suratmasuk WHERE id_suratmasuk=:id_surat";
            $arr = array(':id_surat'=>$val['id_suratmasuk']);
            $temp = $this->select($sql,$arr);
            foreach ($temp as $value){
                $this->dataEks[] = $value;
            }
            
        }
        
        $view = new View();
        $view->data = $this->getData();
        $view->load('suratmasuk/expedisi');
    }
}
?>
