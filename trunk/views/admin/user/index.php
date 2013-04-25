<h2>Tambah User</h2><hr><div id="form-wrapper">
<form id="form-rekam" method="POST" action="#">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamUser">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    
    <label>NAMA PEGAWAI</label><input class="required" type="text" name="namaPegawai"></br>
    <label>NIP</label><input class="required number" type="text" name="NIP"></br>
    <label>NAMA USER</label><input class="required" type="text" name="username"></br>
    <label>PASSWORD</label><input class="required" type="text" name="password"></br>
    <label>BAGIAN</label><select class="required" name="bagian">
        <option value="">--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value){
                echo '<option value='.$value['id_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></br>
    <label>JABATAN</label><select class="required" name="jabatan">
        <option value="">--PILIH JABATAN--</option>
        <?php foreach($this->jabatan as $key=>$value){
                echo '<option value='.$value['id_jabatan'].'>'.strtoupper($value['nama_jabatan']).'</option>';
            }
        ?>
    </select></br>
    <label>ROLE</label><select class="required" name="role">
        <option value="">--PILIH ROLE--</option>
        <?php foreach($this->role as $key=>$value){
                echo '<option value='.$value['id_role'].'>'.strtoupper($value['role']).'</option>';
            }
        ?>
    </select></br>   
    <label></label><input type="reset" name="submit" value="RESET"><input type="submit" name="submit" value="SIMPAN">
</form></div>
</br>
<hr>
</br>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>NAMA PEGAWAI</th><th>NAMA USER</th><th>AKSI</th><th>AKTIF</th></tr>
    <?php foreach($this->user as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['namaPegawai']; ?></td>
        <td><?php echo $value['username']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahUser/<?php echo $value['id_user'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusUser/<?php echo $value['id_user'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai('<?php echo $value['username'];?>');"></a></td>
        <td><a href="<?php echo URL;?>admin/setAktifUser/<?php echo $value['id_user'].'/'.$value['active'];?>"><input class="btn" type="button" value="<?php echo $value['active']; ?>"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>

<script type="text/javascript">

function selesai(user){
    var answer = 'apakah akun atas nama '+user+' akan dihapus?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}


</script>