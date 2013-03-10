<table border="1">
    <tr><td colspan="7"><a href="<?php echo URL;?>suratmasuk/rekam"><input type="button" value="R E K A M"></a></td></tr>
<?php
    foreach($this->listSurat as $key => $value) {
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        echo '<td>' . Tanggal::tgl_indo($value['tgl_terima']) . '</td>';
        echo '<td><a href="'.URL.'suratmasuk/getSuratMasukById/'.$value['id_suratmasuk'].'">' . $value['no_surat'] . '</a> || '
            . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'. $value['asal_surat'] . '</br>'. $value['perihal'] .
             '</td>';
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>
                <a href="'.URL.'suratmasuk/edit/'.$value['id_suratmasuk'].'">Edit</a> 
                <a href="'.URL.'suratmasuk/remove/'.$value['id_suratmasuk'].'">Delete</a>
                <a href="'.URL.'suratmasuk/disposisi/'.$value['id_suratmasuk'].'">Disposisi</a>
                <a href="'.URL.'suratmasuk/ctkdisposisi/'.$value['id_suratmasuk'].'">Cetak Disposisi</a>
                <a href="'.URL.'suratmasuk/updatestatus/'.$value['id_suratmasuk'].'">Status</a></td>';
        echo '</tr>';
    }
?>
</table>