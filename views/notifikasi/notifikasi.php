<h2>Notifikasi (<?php echo $this->jmlnotif;?>)</h2>
<hr>
</br>
<?php if(count($this->notifsm)>0){ ?>
<div id="table-wrapper" style="overflow:scroll; height:400px;">
    <table class="CSSTableGenerator">
        <tr><td colspan="3">Surat Masuk</td></tr>
        <?php 
        
            foreach($this->notifsm as $value){
                foreach ($value as $val){
                echo "<tr><td>$val[tgl_terima]</br>$val[no_agenda]</td>
                    <td>$val[no_surat] | $val[tgl_surat]</br>
                    $val[asal_surat]</br>$val[perihal]</td><td><a href=".URL."suratmasuk/detil/$val[id_suratmasuk]><input type=button class=btn value=DETIL></a></td></tr>";
                }
            }
        
            
        ?>
    </table>
</div>
<?php }?>
</br>
<hr>
</br>
<?php if(count($this->notifsk)>0){ ?>
<div id="table-wrapper" style="overflow:scroll; height:400px;">
    <table class="CSSTableGenerator">
        <tr><td colspan="3">Surat Keluar</td></tr>
        <?php
        
            foreach($this->notifsk as $value){
                foreach ($value as $val){
                echo "<tr><td>$val[tgl_surat]</td>
                    <td>$val[tipe] | $val[no_surat]</br>
                    $val[tujuan]</br>$val[perihal]</td><td><a href=".URL."suratkeluar/detil/$val[id_suratkeluar]><input type=button class=btn value=DETIL></a></td></tr>";
                }
            }
            
        ?>
    </table>
</div>
<?php }?>