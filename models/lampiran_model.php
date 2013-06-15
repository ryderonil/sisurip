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

    var $id_lamp;
    var $jns_surat;
    var $id_surat;
    var $tipe;
    var $nomor;
    var $tanggal;
    var $hal;
    var $asal;
    var $ket;
    var $file;    

    public function __construct() {
        parent::__construct();
    }
    
    /*
     * setter
     */
    public function set($attr, $val){
        switch($attr){
            case 'id_lamp':
                $this->id_lamp = $val;
                break;
            case 'jns_surat':
                $this->jns_surat = $val;
                break;
            case 'id_surat':
                $this->id_surat = $val;
                break;
            case 'tipe':
                $this->tipe = $val;
                break;
            case 'nomor':
                $this->nomor = $val;
                break;
            case 'tanggal':
                $this->tanggal = $val;
                break;
            case 'hal':
                $this->hal = $val;
                break;
            case 'asal':
                $this->asal = $val;
                break;
            case 'keterangan':
                $this->ket = $val;
                break;
            case 'file':
                $this->file = $val;
                break;
        }
    }
    
    /*
     * getter
     */
    public function get($attr){
        switch($attr){
            case 'id_lamp':
                return $this->id_lamp;
                break;
            case 'jns_surat':
                return $this->jns_surat;
                break;
            case 'id_surat':
                return $this->id_surat;
                break;
            case 'tipe':
                return $this->tipe;
                break;
            case 'nomor':
                return $this->nomor;
                break;
            case 'tanggal':
                return $this->tanggal;
                break;
            case 'hal':
                return $this->hal;
                break;
            case 'asal':
                return $this->asal;
                break;
            case 'keterangan':
                return $this->ket;
                break;
            case 'file':
                return $this->file;
                break;
        }
        
    }
    
    /*
     * fungsi rekam lampiran
     * param data array
     * return boolean
     */
    public function addLampiran($data) {
        return $this->insert('lampiran', $data);
    }
    
    /*
     * fungsi hapus lampiran
     * return boolean
     */
    public function deleteLampiran() {
        $where = ' id_lamp='.$this->get('id_lamp');
        return $this->delete('lampiran', $where);
    }
    
    /*
     * fungsi update data lampiran
     * return boolean
     */
    public function editLampiran() {
        $data = array(
            'jns_surat'=>$this->get('jns_surat'),
            'id_surat'=>$this->get('id_surat'),
            'tipe'=>$this->get('tipe'),
            'nomor'=>$this->get('nomor'),
            'tanggal'=>$this->get('tanggal'),
            'hal'=>$this->get('hal'),
            'asal'=>$this->get('asal'),
            'keterangan'=>$this->get('keterangan'),
            'file'=>$this->get('file')
        );
        
        $where = ' id_lamp='.$this->get('id_lamp');
        return $this->update('lampiran', $data, $where);
    }
    
    /*
     * fungsi mendapatkan data lampiran
     * param id lampiran, default NULL
     * return lampiran array
     */
    public function getLampiran($id = null) {

        if (!is_null($id)) {
            $sql = 'SELECT * FROM lampiran WHERE id_lamp=' . $id;
        } else {
            $sql = 'SELECT * FROM lampiran';
        }
        return $this->select($sql);
    }
    
    /*
     * fungsi mendapatkan lampiran surat
     * param id surat, jenis surat->SM,SK
     * return lampiran array
     */
    public function getLampiranSurat($id, $tipe) {

        $sql = "SELECT a.id_lamp as id_lamp, a.jns_surat as jns_surat,
            a.id_surat as id_surat, b.tipe_naskah as tipe,
            a.nomor as nomor, a.tanggal as tanggal, a.hal as hal,
            a.asal as asal, a.keterangan as keterangan, a.file as file 
            FROM lampiran a LEFT JOIN tipe_naskah b ON a.tipe=b.id_tipe WHERE a.id_surat=" . $id . " AND a.jns_surat='" . $tipe . "'";

        return $this->select($sql);
    }
    
    /*
     * fungsi mendapatkan list tipe naskah
     * return tipe naskah array
     */
    public function getTypeLampiran() {
        return $this->select('SELECT * FROM tipe_naskah');
    }
    
    function __destruct() {
        ;
    }

}

?>
