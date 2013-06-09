<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Lokasi extends Model{
    
    var $bagian;
    var $id;
    var $lokasi;
    
    public function __construct() {
        parent::__construct();
    }
    
    /*
     * fungsi mendapatkan kode lengkap lokasi
     * return string
     */
    public function getLokasiBox($id_box,$bagian){
        $sql = "SELECT a.lokasi as box, 
                                    b.lokasi as baris,
                                    c.lokasi as rak,
                                    a.bagian as bagian
                                    FROM lokasi a LEFT JOIN lokasi b ON a.parent=b.id_lokasi
                                    LEFT JOIN lokasi c ON b.parent=c.id_lokasi 
                                    WHERE a.id_lokasi=".$id_box." AND a.bagian ='".$bagian."'";                                      
        $lokasi = '';
        $datal = $this->select($sql);
        foreach ($datal as $loc){
            $lokasi .= '-'.$loc['rak'];
            $lokasi .= '-'.$loc['baris'];
            $lokasi .= '-'.$loc['box'];
            $this->id = $id_box;
            $this->bagian = $loc['bagian'];
            $this->lokasi = $lokasi;
        }
        return $this->bagian.$this->lokasi;
    }
    
    public function __toString() {
        return $this->bagian.$this->lokasi;
    }
    
    function __destruct() {
        ;
    }
            
}
?>
