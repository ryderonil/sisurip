<h2>Catatan Revisi</h2>
<hr>
</br>
<table>
    <?php 
    $id = 0;
    foreach ($this->data as $val) { 
        $id = $val['id_suratkeluar'];
        ?>    
    <tr><td>TANGGAL SURAT</td><td><?php echo $val['tgl_surat'];?></td></tr>
    <tr><td>TUJUAN</td><td><?php echo $val['tujuan'];?></td></tr>
    <tr><td>PERIHAL</td><td><?php echo $val['perihal'];?></td></tr>
    <tr><td>SIFAT</td><td><?php echo $val['sifat'];?></td></tr>
    <tr><td>JENIS</td><td><?php echo $val['jenis'];?></td></tr>
    <tr><td>TIPE SURAT</td><td><?php echo $val['tipe'];?></td></tr>
    <?php } ?>
</table>
<hr>
</br>
<div id="form-wrapper">
    <form method="POST" action="<?php echo URL; ?>suratkeluar/uploadrev" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="user" value="<?php echo $user;?>">       
        <table>
            <tr><td valign="top"><label>CATATAN REVISI</label></td><td><textarea id="input" name="catatan" cols="60" rows="20"></textarea></td></tr>
            <tr><td><label>UPLOAD</label></td><td><input type="file" name="upload"></td></tr>
            <tr><td></td><td><input type="submit" name="submit" value="SIMPAN"></td></tr>
        </table>
    </form>
</div>