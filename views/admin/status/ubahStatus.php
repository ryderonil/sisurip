<h1>Ubah Status Surat</h1>
<form method="POST" action="<?php echo URL; ?>admin/updateRekamStatus">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>TIPE SURAT</label><input type="text" name="tipe_surat" value="<?php echo $this->data[1];?>"></br>
    <label>STATUS</label><input type="text" name="status" value="<?php echo $this->data[2];?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>


<div class="CSSTableGenerator"><table border="1">
    <tr><th>NO</th><th>TIPE SURAT</th><th>STATUS</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->status as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['tipe_surat']; ?></td>
        <td><?php echo $value['status']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahStatusSurat/<?php echo $value['id_status'];?>">UBAH</a> | 
            <a href="<?php echo URL;?>admin/hapusStatus/<?php echo $value['id_status'];?>">HAPUS</a></td></tr>
    <?php $no++; }?>
</table></div>