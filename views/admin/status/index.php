<h2>Tambah Status Surat</h2><hr><div id="form-wrapper">
<form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamStatus">              
        
    <label>TIPE SURAT</label><input class="required" type="text" name="tipe_surat"></br>
    <label>STATUS</label><input class="required" type="text" name="status"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form></div>
</br>
<hr>
</br>
<?php if($this->count>0) { $no=1;?>
<div class="CSSTableGenerator"><table border="1">
    <tr><th>NO</th><th>TIPE SURAT</th><th>STATUS</th><th>AKSI</th></tr>
    <?php foreach($this->status as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['tipe_surat']; ?></td>
        <td><?php echo $value['status']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahStatusSurat/<?php echo $value['id_status'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusStatus/<?php echo $value['id_status'];?>"><input class="btn" type="button" value="HAPUS"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>