<div id="form-wrapper"><form method="POST" action="<?php echo URL?>suratmasuk/rekamdisposisi">
    <h1 align="center">Catat Disposisi</h1>
    <h2>Informasi Surat :</h2></br>
    <?php foreach($this->data as $value) { ?>
    <input type="hidden" name="id_surat" value="<?php echo $value['id_suratmasuk'];?>">
    <table>
        <tr><td>No Surat</td><td><input type="text" name="" value="<?php echo $value['no_surat'];?>" readonly></td>
            <td>Status</td><td><input type="text" name="" value="<?php echo $value['status'];?>" readonly></td>
            <td>Diterima Tgl</td><td><input type="text" name="" value="<?php echo $value['tgl_terima'];?>" readonly></td></tr>   
        <tr><td>Tgl Surat</td><td><input type="text" name="" value="<?php echo $value['tgl_surat'];?>" readonly></td>
            <td>Sifat</td><td><input type="text" name="" value="<?php echo $value['sifat'];?>" readonly></td>
            <td>no Agenda</td><td><input type="text" name="" value="<?php echo $value['no_agenda'];?>" readonly></td></tr>
        <tr><td>Lampiran</td><td><input type="text" name="" value="<?php echo $value['lampiran'];?>" readonly></td>
            <td>Jenis</td><td><input type="text" name="" value="<?php echo $value['jenis'];?>" readonly></td><td></td><td></td></tr>
        <tr><td>Dari</td><td colspan="7"><input type="text" name="" value="<?php echo $value['asal_surat'];?>" readonly></td></tr>
        <tr><td>Perihal</td><td colspan="7"><input type="text" name="" value="<?php echo $value['perihal'];?>" readonly></td></tr>
    </table> 
    <?php } ?>
    <hr>
    <h2>Sifat :</h2>
    <input type="radio" name="sifat" value="SS"> SANGAT SEGERA 
    <input type="radio" name="sifat" value="S"> SEGERA
    <hr>
    <h2>Disposisi Kepada :</h2>  
    <?php        
        foreach($this->seksi as $value) { 
            echo '<input type=checkbox name=disposisi[] value='.$value['kd_bagian'].'> Kepala '.$value['bagian'].'</br>';
                        
        }
    ?>
    <hr>
    <h2>Petunjuk :</h2>
    <table>
        <tr><td>
    <?php
        $length = count($this->petunjuk);
        $length = ceil($length/2);
        $row = 1;
        foreach($this->petunjuk as $value) { 
            echo '<input type=checkbox name=petunjuk[] value='.$value['id_petunjuk'].'> '.$value['petunjuk'].'</br>';
            
            if($row==$length){
                echo "</td><td>";
            }
            $row++;
        }
    ?>
            </td></tr>
    </table>    
    <hr>
    <h2>Catatan :</h2></br>
    <textarea name="catatan" rows="15" cols="80"></textarea>
    <hr>
    <table>
        <tr><td>Tgl Penyelesaian :</td><td><input type="text" name="" value=""></td>
            <td>Diajukan kembali tgl :</td><td><input type="text" name="" value=""></td></tr>
        <tr><td>Penerima :</td><td><input type="text" name="" value=""></td>
            <td>Penerima :</td><td><input type="text" name="" value=""></td></tr>
        <tr><td></td><td></td><td></td><td></td></tr>
        <tr><td>Tgl Penyelesaian :</td><td><input type="text" name="" value=""></td>
            <td>Tgl Penyelesaian :</td><td><input type="text" name="" value=""></td></tr>
        <tr><td>Penerima :</td><td><input type="text" name="" value=""></td>
            <td>Penerima :</td><td><input type="text" name="" value=""></td></tr>
    </table>    
    <input type="submit" name="submit" value="SIMPAN">
</form>
</div>