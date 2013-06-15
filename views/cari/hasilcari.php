<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if ($this->count == 0) {
    echo "<div id=warning>Data tidak ditemukan! silahkan lakukan pencarian dengan kata kunci yang lain</div>";
} else {
    $pesan = "Ditemukan : $this->count hasil pencarian dengan kata kunci " . $this->keyword;
    echo "<table class=CSSTableGenerator><tr><td colspan=5 halign=left>$pesan</td></tr>";
    foreach ($this->hasil as $val) {
        $ext = '';
        if ($val->getFile() != '' OR !is_null($val->getFile())) {
            $ext = end(explode('.', $val->getFile()));
        }
        if ($val->getFile() != '' AND !is_null($val->getFile()) AND $ext != 'doc' AND $ext != 'docx') {
            echo "<tr><td>".$val->getId()."</td><td>" . Tanggal::tgl_indo($val->getTanggal()) . "</td><td>".$val->getNomor()."</td><td>".$val->getPerihal()."</td><td><input type=button class='btn' value=".$val->getTipe()." ";
            if ($val->getTipe() == 'lampiran') {
                echo "onclick=viewlampiran(".$val->getId().")></td></tr>";
            } elseif ($val->getTipe() == 'surat_masuk') {
                echo "onclick=displaysm(".$val->getId().")></td></tr>";
            } elseif ($val->getTipe() == 'surat_keluar') {
                echo "onclick=displaysk(".$val->getId().")></td></tr>";
        }
        } else {
            echo "<tr><td>".$val->getId()."</td><td>" . Tanggal::tgl_indo($val->getTanggal()) . "</td><td>".$val->getNomor()."</td><td>".$val->getPerihal()."</td><td><input type=button class='btn btn-red' value=".$val->getTipe()." onclick=alert(file tidak ada)></td></tr>";
            
        }
        
    }
    echo "</table>";
}
?>
