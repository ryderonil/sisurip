<?php

/**
 * @author aisyah
 * @copyright 2012
 */
class Paging {

    var $batas;
    var $page;
    var $url;

    public function __construct($url, $batas, $page = null) {
        if (is_null($page)) {
            $this->page = 0;
        } else {
            $this->page = $page;
        }
        $this->batas = $batas;
        $this->url = $url;
    }

    public function cari_posisi() {

        $posisi = ($this->page - 1) * $this->batas;
        return $posisi;
    }

    public function jml_halaman($jml_data) {
        $jml_hal = ceil($jml_data / $this->batas);
        return $jml_hal;
    }

    function navHalaman($jmlhalaman) {
        $link_halaman = "<div class=paging>";
        $link_halaman .= "HALAMAN $this->page DARI $jmlhalaman ";
        // Link ke halaman pertama (first) dan sebelumnya (prev)
        if ($this->page > 1) {

            $prev = $this->page - 1;

            $link_halaman .= "<span class=prevnext><a href=" . URL . "$this->url/$prev><input type=button class=btn value='<' ></a></span>";
        } else {
            $link_halaman .= "<span class=disabled><input type=button class=btn value='<' ></span>";
        }


        // Link ke halaman berikutnya (Next) dan terakhir (Last) 
        if ($this->page < $jmlhalaman) {
            $next = $this->page + 1;

            $link_halaman .= " <span class=prevnext><a href=" . URL . "$this->url/$next><input type=button class=btn value='>' ></a></span> 
                             ";
        } else {
            $link_halaman .= " <span class=disabled><input type=button class=btn value='>' ></span>";
        }
        $link_halaman .="</div>";
        return $link_halaman;
    }

}