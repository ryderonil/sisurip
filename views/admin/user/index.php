<h1>Tambah User</h1>
<form method="POST" action="<?php echo URL; ?>admin/inputRekamUser">
    
    <label>NAMA PEGAWAI</label><input type="text" name="namaPegawai"></br>
    <label>NIP</label><input type="text" name="NIP"></br>
    <label>NAMA USER</label><input type="text" name="username"></br>
    <label>PASSWORD</label><input type="text" name="password"></br>
    <label>BAGIAN</label><select name="bagian">
        <option value="">--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value){
                echo '<option value='.$value['id_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></br>
    <label>JABATAN</label><select name="jabatan">
        <option value="">--PILIH JABATAN--</option>
        <?php foreach($this->jabatan as $key=>$value){
                echo '<option value='.$value['id_jabatan'].'>'.strtoupper($value['nama_jabatan']).'</option>';
            }
        ?>
    </select></br>
    <label>ROLE</label><select name="role">
        <option value="">--PILIH ROLE--</option>
        <?php foreach($this->role as $key=>$value){
                echo '<option value='.$value['id_role'].'>'.strtoupper($value['role']).'</option>';
            }
        ?>
    </select></br>   
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>

<?php if($this->count>0) { $no=1;?>
<table border="1">
    <tr><th>NO</th><th>NAMA PEGAWAI</th><th>NAMA USER</th><th>AKSI</th><th>AKTIF</th></tr>
    <?php foreach($this->user as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['namaPegawai']; ?></td>
        <td><?php echo $value['username']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahUser/<?php echo $value['id_user'];?>">UBAH</a> | 
            <a href="<?php echo URL;?>admin/hapusUser/<?php echo $value['id_user'];?>">HAPUS</a></td>
        <td><a href="<?php echo URL;?>admin/setAktifUser/<?php echo $value['id_user'].'/'.$value['active'];?>"><?php echo $value['active']; ?></a></td></tr>
    <?php $no++; }?>
</table>
<?php } ?>