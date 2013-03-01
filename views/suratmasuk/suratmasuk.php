<table border="1">
<?php
    foreach($this->listSurat as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['no_agenda'] . '</td>';
        echo '<td>' . $value['no_surat'] . '</td>';
        echo '<td>' . $value['tgl_terima'] . '</td>';
        echo '<td>' . $value['tgl_surat'] . '</td>';
        echo '<td>' . $value['asal_surat'] . '</td>';
        echo '<td>' . $value['perihal'] . '</td>';
        echo '<td>
                <a href="'.URL.'suratmasuk/edit/'.$value['id_suratmasuk'].'">Edit</a> 
                <a href="'.URL.'suratmasuk/remove/'.$value['id_suratmasuk'].'">Delete</a></td>';
        echo '</tr>';
    }
?>
</table>