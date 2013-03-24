<h2>Ubah User</h2><hr><div id="form-wrapper">
<form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamUser">
    <input type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <label>NAMA PEGAWAI</label><input class="required" type="text" name="namaPegawai" value="<?php echo $this->data[3]; ?>"></br>
    <label>NIP</label><input class="required" type="text" name="NIP" value="<?php echo $this->data[4]; ?>"></br>
    <label>NAMA USER</label><input class="required" type="text" name="username" value="<?php echo $this->data[1]; ?>"></br>
    <label>PASSWORD</label><input class="required" type="text" name="password" value="<?php echo $this->data[2]; ?>"></br>
    <label>BAGIAN</label><select class="required" name="bagian">
        <option value="">--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value){
            
            if($this->data[6]==$value['id_bagian']){
                echo '<option value='.$value['id_bagian'].' selected >'.strtoupper($value['bagian']).'</option>';
            }else{
                echo '<option value='.$value['id_bagian'].' >'.strtoupper($value['bagian']).'</option>';
            } 
                
            }
        ?>
    </select></br>
    <label>JABATAN</label><select class="required" name="jabatan">
        <option value="">--PILIH JABATAN--</option>
        <?php foreach($this->jabatan as $key=>$value){
               
                if($this->data[5]==$value['id_jabatan']){
                    echo '<option value='.$value['id_jabatan'].' selected >'.strtoupper($value['nama_jabatan']).'</option>';
                }else{
                    echo '<option value='.$value['id_jabatan'].' >'.strtoupper($value['nama_jabatan']).'</option>';
                } 
                   
                }
        ?>
    </select></br>
    <label>ROLE</label><select class="required" name="role">
        <option value="">--PILIH ROLE--</option>
        <?php foreach($this->role as $key=>$value){
                
                if($this->data[7]==$value['id_role']){
                    echo '<option value='.$value['id_role'].' selected >'.strtoupper($value['role']).'</option>';
                }else{
                    echo '<option value='.$value['id_role'].' >'.strtoupper($value['role']).'</option>';
                } 
                    
            }
        ?>
    </select></br>   
    <label></label><input type="button" onclick="location.href='<?php echo URL;?>admin/rekamUser'"value="BATAL" ><input type="submit" name="submit" value="SIMPAN" onclick="return selesai();">
</form></div>
</br>
<hr>
</br>
<<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>NAMA PEGAWAI</th><th>NAMA USER</th><th>AKSI</th><th>AKTIF</th></tr>
    <?php $no=1; foreach($this->user as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['namaPegawai']; ?></td>
        <td><?php echo $value['username']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahUser/<?php echo $value['id_user'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusUser/<?php echo $value['id_user'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai();"></a></td>
        <td><a href="<?php echo URL;?>admin/setAktifUser/<?php echo $value['id_user'].'/'.$value['active'];?>"><input class="btn" type="button" value="<?php echo $value['active']; ?>"></a></td></tr>
    <?php $no++; }?>
</table></div>

<script type="text/javascript">

function selesai(){
    var answer = 'anda yakin menyimpan perubahan?'
    
    if(confirm(answer)){
        return true;
    }else{
        return false;
    }
}


</script>
