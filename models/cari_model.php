<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cari_Model extends Model {

    var $filter;
    var $keyword;
    var $after;
    var $before;

    public function __construct() {
        parent::__construct();
    }

    public function findLampiran() {
        if ($this->before != null AND $this->after == null) {
            $sql = "SELECT id_lamp, tanggal, nomor, hal, file FROM lampiran WHERE hal LIKE '%$this->keyword%' AND tanggal>='" . $this->before . "'";
        } elseif ($this->before == null AND $this->after != null) {
            $sql = "SELECT id_lamp, tanggal, nomor, hal, file FROM lampiran WHERE hal LIKE '%$this->keyword%' AND tanggal<='" . $this->after . "'";
        } elseif ($this->before != null AND $this->after != null) {
            $sql = "SELECT id_lamp, tanggal, nomor, hal, file FROM lampiran WHERE hal LIKE '%$this->keyword%' AND tanggal>='" . $this->before . "' AND tanggal<='" . $this->after . "'";
        } else {
            $sql = "SELECT id_lamp, tanggal, nomor, hal, file FROM lampiran WHERE hal LIKE '%$this->keyword%'";
        }

        $data = $this->select($sql);

        $result = array();
        $int = 0;
        foreach ($data as $val) {
            $result[$int][0] = $val['id_lamp'];
            $result[$int][1] = $val['tanggal'];
            $result[$int][2] = $val['nomor'];
            $result[$int][3] = $val['hal'];
            $int++;
        }
        return $result;
    }

    public function findSuratMasuk() {
        if ($this->before != null AND $this->after == null) {
            $sql = "SELECT id_suratmasuk, tgl_surat, no_surat, perihal, file FROM suratmasuk WHERE perihal LIKE '%$this->keyword%' AND tgl_surat>='" . $this->before . "'";
        } elseif ($this->before == null AND $this->after != null) {
            $sql = "SELECT id_suratmasuk, tgl_surat, no_surat, perihal, file FROM suratmasuk WHERE perihal LIKE '%$this->keyword%' AND tgl_surat<='" . $this->after . "'";
        } elseif ($this->before != null AND $this->after != null) {
            $sql = "SELECT id_suratmasuk, tgl_surat, no_surat, perihal, file FROM suratmasuk WHERE perihal LIKE '%$this->keyword%' AND tgl_surat>='" . $this->before . "' AND tgl_surat<='" . $this->after . "'";
        } else {
            $sql = "SELECT id_suratmasuk, tgl_surat, no_surat, perihal, file FROM suratmasuk WHERE perihal LIKE '%$this->keyword%'";
        }

        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val) {
            $result[$int][0] = $val['id_suratmasuk'];
            $result[$int][1] = $val['tgl_surat'];
            $result[$int][2] = $val['no_surat'];
            $result[$int][3] = $val['perihal'];
            $int++;
        }
        return $result;
    }

    public function findSuratKeluar() {
        if ($this->before != null AND $this->after == null) {
            $sql = "SELECT id_suratkeluar, tgl_surat, no_surat, perihal, file FROM suratkeluar WHERE perihal LIKE '%$this->keyword%' AND tgl_surat >='" . $this->before . "'";
        } elseif ($this->before == null AND $this->after != null) {
            $sql = "SELECT id_suratkeluar, tgl_surat, no_surat, perihal, file FROM suratkeluar WHERE perihal LIKE '%$this->keyword%' AND tgl_surat <='" . $this->after . "'";
        } elseif ($this->before != null AND $this->after != null) {
            $sql = "SELECT id_suratkeluar, tgl_surat, no_surat, perihal, file FROM suratkeluar WHERE perihal LIKE '%$this->keyword%' AND tgl_surat >='" . $this->before . "' AND tgl_surat <='" . $this->after . "'";
        } else {
            $sql = "SELECT id_suratkeluar, tgl_surat, no_surat, perihal, file FROM suratkeluar WHERE perihal LIKE '%$this->keyword%'";
        }
//        var_dump($sql);
        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val) {
            $result[$int][0] = $val['id_suratkeluar'];
            $result[$int][1] = $val['tgl_surat'];
            $result[$int][2] = $val['no_surat'];
            $result[$int][3] = $val['perihal'];
            $int++;
        }
        return $result;
    }

    public function findByDate() {
        $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, file as file, 'lampiran' as tipe FROM lampiran WHERE tanggal>='" . $this->before . "' AND tanggal<='" . $this->after . "'";
        $sql .= " UNION ";
        $sql .= "SELECT id_suratmasuk as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat masuk' as tipe FROM suratmasuk WHERE tgl_surat>='" . $this->before . "' AND tgl_surat<='" . $this->after . "'";
        $sql .= " UNION ";
        $sql .= "SELECT id_suratkeluar as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat keluar' as tipe FROM suratkeluar WHERE tgl_surat >='" . $this->before . "' AND tgl_surat <='" . $this->after . "'";
        $sql .= " ORDER BY tgl DESC";
//        var_dump($sql);
        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val) {
            $result[$int][0] = $val['id'];
            $result[$int][1] = $val['tgl'];
            $result[$int][2] = $val['nomor'];
            $result[$int][3] = $val['hal'];
            $result[$int][4] = $val['tipe'];
            $int++;
        }
        return $result;
    }

    public function splitKeyword($keyword) {
        $array = explode(" ", $keyword);
//        var_dump($array);
        $jmlkey = count($array);
//        var_dump($jmlkey);
        if ($jmlkey == 2) {
            $filter = explode(":", $array[0]);
            if ($this->cekFilterKey($filter)) {
                @$this->keyword = $array[1];
            }
        } elseif ($jmlkey == 3) {
            if ($this->cekFilterKey($filter = explode(":", $array[0]))) {
                if ($this->cekFilterKey($filter1 = explode(":", $array[1]))) {
                    $this->keyword = $array[2];
                }
            }
        } elseif ($jmlkey > 3) {
            if ($this->cekFilterKey($filter = explode(":", $array[0]))) {
                if ($this->cekFilterKey($filter1 = explode(":", $array[1]))) {
                    if ($this->cekFilterKey($filter2 = explode(":", $array[2]))) {
                        $this->keyword = $array[3];
                    }
                }
            }
        } else {
            $this->filter = 'all';
            $this->keyword = $array[0];
        }
    }

    private function cekFilterKey($data = array()) {
//        var_dump($data);
        if ($data[0] == 'in') {
            $this->filter = $data[1];
            return true;
        } else if ($data[0] == 'after') {
            $this->after = Tanggal::ubahFormatTanggal($data[1]);
            return true;
        } else if ($data[0] == 'before') {
            $this->before = Tanggal::ubahFormatTanggal($data[1]);
            return true;
        }

        return false;
    }

    public function findByNomor() {
        if ($this->before != null AND $this->after == null) {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, file as file, 'lampiran' as tipe FROM lampiran WHERE nomor LIKE '%$this->keyword%' AND tanggal>='".$this->before."'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratmasuk as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat masuk' as tipe FROM suratmasuk WHERE no_surat LIKE '%$this->keyword%' AND tgl_surat>='".$this->before."'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratkeluar as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat keluar' as tipe FROM suratkeluar WHERE no_surat LIKE '%$this->keyword%' AND tgl_surat>='".$this->before."'";
        } elseif ($this->before == null AND $this->after != null) {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, file as file, 'lampiran' as tipe FROM lampiran WHERE nomor LIKE '%$this->keyword%' AND tanggal<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratmasuk as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat masuk' as tipe FROM suratmasuk WHERE no_surat LIKE '%$this->keyword%' AND tgl_surat<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratkeluar as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat keluar' as tipe FROM suratkeluar WHERE no_surat LIKE '%$this->keyword%' AND tgl_surat<='".$this->after."'";
        } elseif ($this->before != null AND $this->after != null) {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, file as file, 'lampiran' as tipe FROM lampiran WHERE nomor LIKE '%$this->keyword%'  AND tanggal>='".$this->before."' AND tanggal<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratmasuk as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat masuk' as tipe FROM suratmasuk WHERE no_surat LIKE '%$this->keyword%' AND tgl_surat>='".$this->before."' AND tgl_surat<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratkeluar as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat keluar' as tipe FROM suratkeluar WHERE no_surat LIKE '%$this->keyword%' AND tgl_surat>='".$this->before."' AND tgl_surat<='".$this->after."'";
        } else {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, file as file, 'lampiran' as tipe FROM lampiran WHERE nomor LIKE '%$this->keyword%'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratmasuk as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat masuk' as tipe FROM suratmasuk WHERE no_surat LIKE '%$this->keyword%'";
            $sql .= " UNION ";
            $sql .= "SELECT id_suratkeluar as id, tgl_surat as tgl, no_surat as nomor, perihal as hal, file as file, 'surat keluar' as tipe FROM suratkeluar WHERE no_surat LIKE '%$this->keyword%'";
        }
        
        $sql .= " ORDER BY tgl DESC";
//        var_dump($sql);
        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val) {
            $result[$int][0] = $val['id'];
            $result[$int][1] = $val['tgl'];
            $result[$int][2] = $val['nomor'];
            $result[$int][3] = $val['hal'];
            $result[$int][4] = $val['tipe'];
            $int++;
        }
        return $result;
    }
    
    //masih susah logikanya
    public function findByAlamat(){
        if ($this->before != null AND $this->after == null) {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, asal as alamat, file as file, 'lampiran' as tipe FROM lampiran WHERE asal LIKE '%$this->keyword%' AND tanggal>='".$this->before."'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratmasuk as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat masuk' as tipe FROM suratmasuk a LEFT JOIN alamat b ON a.asal_surat = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%' AND a.tgl_surat>='".$this->before."'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratkeluar as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat keluar' as tipe FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%' AND a.tgl_surat>='".$this->before."'";
        } elseif ($this->before == null AND $this->after != null) {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, asal as alamat, file as file, 'lampiran' as tipe FROM lampiran WHERE asal LIKE '%$this->keyword%' AND tanggal<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratmasuk as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat masuk' as tipe FROM suratmasuk a LEFT JOIN alamat b ON a.asal_surat = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%' AND a.tgl_surat<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratkeluar as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat keluar' as tipe FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%' AND a.tgl_surat<='".$this->after."'";
        } elseif ($this->before != null AND $this->after != null) {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, asal as alamat, file as file, 'lampiran' as tipe FROM lampiran WHERE asal LIKE '%$this->keyword%'  AND tanggal>='".$this->before."' AND tanggal<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratmasuk as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat masuk' as tipe FROM suratmasuk a LEFT JOIN alamat b ON a.asal_surat = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%' AND a.tgl_surat>='".$this->before."' AND a.tgl_surat<='".$this->after."'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratkeluar as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat keluar' as tipe FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%' AND a.tgl_surat>='".$this->before."' AND a.tgl_surat<='".$this->after."'";
        } else {
            $sql = "SELECT id_lamp as id, tanggal as tgl, nomor as nomor, hal as hal, asal as alamat, file as file, 'lampiran' as tipe FROM lampiran WHERE asal LIKE '%$this->keyword%'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratmasuk as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat masuk' as tipe FROM suratmasuk a LEFT JOIN alamat b ON a.asal_surat = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%'";
            $sql .= " UNION ";
            $sql .= "SELECT a.id_suratkeluar as id, a.tgl_surat as tgl, a.no_surat as nomor, a.perihal as hal, b.nama_satker as alamat, a.file as file, 'surat keluar' as tipe FROM suratkeluar a LEFT JOIN alamat b ON a.tujuan = b.kode_satker WHERE b.nama_satker LIKE '%$this->keyword%'";
        }
        
        $sql .= " ORDER BY tgl DESC";
//        var_dump($sql);
        $data = $this->select($sql);
        $result = array();
        $int = 0;
        foreach ($data as $val) {
            $result[$int][0] = $val['id'];
            $result[$int][1] = $val['tgl'];
            $result[$int][2] = $val['nomor'];
            $result[$int][3] = $val['hal'];
            $result[$int][4] = $val['tipe'];
            $int++;
        }
        return $result;
    }

}

?>
