<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class EkspedisiSurat extends Model {

    private $dataEks = array();

    public function __construct() {
        parent::__construct();
    }

    public function getData() {
        return $this->dataEks;
    }

    public function displayEkspedisi() {

        $sql = "SELECT  a.id_suratmasuk as id,
                a.no_agenda as no_agenda,
                a.tgl_terima as tgl_terima,
                a.no_surat as no_surat,
                b.nama_satker as asal_surat,
                c.disposisi as disposisi
                FROM suratmasuk a LEFT JOIN alamat b ON a.asal_surat = b.kode_satker
                LEFT JOIN disposisi c ON a.id_suratmasuk = c.id_surat
                WHERE  a.stat =12";

        $data = $this->select($sql);
        foreach ($data as $val) {
            $disp = explode(",", $val['disposisi']);
            if (count($disp) > 0) {
                for ($i = 0; $i < count($disp); $i++) {
                    $temp['no_agenda'] = $val['no_agenda'];
                    $temp['no_surat'] = $val['no_surat'];
                    $temp['asal_surat'] = $val['asal_surat'];
                    $temp['disposisi'] = $disp[$i];
                    if ($disp[$i] == 'UM') {
                        $this->dataEks['UM'][] = $temp;
                    } elseif ($disp[$i] == 'P1') {
                        $this->dataEks['P1'][] = $temp;
                    } elseif ($disp[$i] == 'P2') {
                        $this->dataEks['P2'][] = $temp;
                    } elseif ($disp[$i] == 'BU') {
                        $this->dataEks['BU'][] = $temp;
                    } elseif ($disp[$i] == 'VA') {
                        $this->dataEks['VA'][] = $temp;
                    }
                }
            }
        }
        return $this->getData();
    }

    public function displayEkspedisiArray($idarray) {
        $id = explode(',', $idarray);
        foreach ($id as $val) {
            $sql = "SELECT  a.id_suratmasuk as id,
                a.no_agenda as no_agenda,
                a.tgl_terima as tgl_terima,
                a.no_surat as no_surat,
                b.nama_satker as asal_surat,
                c.disposisi as disposisi
                FROM suratmasuk a LEFT JOIN alamat b ON a.asal_surat = b.kode_satker
                LEFT JOIN disposisi c ON a.id_suratmasuk = c.id_surat
                WHERE  a.id_suratmasuk =" . $val;

            $data = $this->select($sql);
            foreach ($data as $val) {
                $disp = explode(",", $val['disposisi']);
                if (count($disp) > 0) {
                    for ($i = 0; $i < count($disp); $i++) {
                        $temp['no_agenda'] = $val['no_agenda'];
                        $temp['no_surat'] = $val['no_surat'];
                        $temp['asal_surat'] = $val['asal_surat'];
                        $temp['disposisi'] = $disp[$i];
                        if ($disp[$i] == 'UM') {
                            $this->dataEks['UM'][] = $temp;
                        } elseif ($disp[$i] == 'P1') {
                            $this->dataEks['P1'][] = $temp;
                        } elseif ($disp[$i] == 'P2') {
                            $this->dataEks['P2'][] = $temp;
                        } elseif ($disp[$i] == 'BU') {
                            $this->dataEks['BU'][] = $temp;
                        } elseif ($disp[$i] == 'VA') {
                            $this->dataEks['VA'][] = $temp;
                        }
                    }
                }
            }
        }
        
        return $this->getData();
    }
    
    function __destruct() {
        ;
    }

}

?>
