<h2>Daftar Surat Masuk</h2>

        <hr>
        <a href="<?php echo URL;?>suratmasuk/rekam"><input class="btn" type="button" value="R E K A M"></a>
<div class="CSSTableGenerator"><table border="1">
    <tr><td >AGENDA</td><td >INFORMASI SURAT</td><td >AKSI</td></tr>
<?php
    foreach($this->listSurat as $key => $value) {
        echo '<tr valign=top>';
        //echo '<td>' . $value['no_agenda'] . '</td>';
        echo '<td>' . Tanggal::tgl_indo($value['tgl_terima']) . '</br>'.$value['no_agenda']. '</td>';
        echo '<td><a href="'.URL.'suratmasuk/detil/'.$value['id_suratmasuk'].'">' . $value['no_surat'] . '</a> || '
            . Tanggal::tgl_indo($value['tgl_surat']) . '</br>'. $value['asal_surat'] . '</br>'. $value['perihal'] .
             '</td>';
        //echo '<td>' . $value['tgl_terima'] . '</td>';
        //echo '<td>' . $value['tgl_surat'] . '</td>';
        //echo '<td>' . $value['asal_surat'] . '</td>';
        //echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>
                <a href="'.URL.'suratmasuk/edit/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Ubah></a> 
                <a href="'.URL.'suratmasuk/remove/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Hapus></a>
                <a href="'.URL.'suratmasuk/disposisi/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Disposisi></a>
                <a href="'.URL.'suratmasuk/ctkdisposisi/'.$value['id_suratmasuk'].'"><input class=btn type=button value="Cetak Disposisi"></a>
                <!--<a href="'.URL.'suratmasuk/updatestatus/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Status></a>
                    <a href="'.URL.'suratmasuk/distribusi/'.$value['id_suratmasuk'].'"><input class=btn type=button value=Distribusi></a>--></td>';
        echo '</tr>';
    }
?>
</table></div>