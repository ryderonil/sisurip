<h2>Ubah Status Surat</h2><hr><div id="form-wrapper">
<form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamStatus">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>TIPE SURAT</label><input class="required" type="text" name="tipe_surat" value="<?php echo $this->data[1];?>"></br>
    <label>STATUS</label><input class="required" type="text" name="status" value="<?php echo $this->data[2];?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form></div>

</br>
<hr>
</br>
<div class="CSSTableGenerator"><table border="1">
    <tr><th>NO</th><th>TIPE SURAT</th><th>STATUS</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->status as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['tipe_surat']; ?></td>
        <td><?php echo $value['status']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahStatusSurat/<?php echo $value['id_status'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusStatus/<?php echo $value['id_status'];?>"><input class="btn" type="button" value="HAPUS"></a></td></tr>
    <?php $no++; }?>
</table></div>