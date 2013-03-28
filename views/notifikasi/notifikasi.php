<h2>Notifikasi (<?php echo $this->jmlnotif;?>)</h2>
<hr>
</br>
<div id="table-wrapper">
    <table class="CSSTableGenerator">
        <tr><td colspan="3">Surat Masuk</td></tr>
        <?php 
            foreach($this->notifsm as $value){
                foreach ($value as $val){
                echo "<tr><td>$val[tgl_terima]</br>$val[no_agenda]</td>
                    <td>$val[no_surat] | $val[tgl_surat]</br>
                    $val[asal_surat]</br>$val[perihal]</td><td>AKSI</td></tr>";
                }
            }
        ?>
    </table>
</div>
</br>
<hr>
</br>
<div id="table-wrapper">
    <table class="CSSTableGenerator">
        <tr><td colspan="3">Surat Keluar</td></tr>
        <?php 
            foreach($this->notifsk as $value){
                foreach ($value as $val){
                echo "<tr><td>$val[tgl_surat]</td>
                    <td>$val[tipe] | $val[no_surat]</br>
                    $val[tujuan]</br>$val[perihal]</td><td>AKSI</td></tr>";
                }
            }
        ?>
    </table>
</div>