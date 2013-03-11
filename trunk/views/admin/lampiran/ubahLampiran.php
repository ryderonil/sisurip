<div id="form-wrapper"><h1>Ubah Jenis Lampiran</h1>
<form method="POST" action="<?php echo URL; ?>admin/updateRekamLampiran">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>TIPE NASKAH DINAS</label><input type="text" name="tipe_naskah" value="<?php echo $this->data[1];?>"></br>    
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form></div>

</br>
<hr>
</br>
<div class="CSSTableGenerator"><table border="1">
    <tr><th>NO</th><th>TIPE NASKAH</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->lampiran as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>        
        <td><?php echo $value['tipe_naskah']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahLampiran/<?php echo $value['id_lampiran'];?>"><input type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusLampiran/<?php echo $value['id_lampiran'];?>"><input type="button" value="HAPUS"></a></td></tr>
    <?php $no++; }?>
</table></div>