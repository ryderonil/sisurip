<h2>Beranda Pengguna</h2><hr>
<div id="pesan"></div>
<table><tr><td width="50%" valign="top">
            <h3>Informasi Pengguna</h3><hr>
            <div id="table-wrapper" ><table class="CSSTableGenerator">
                <tr><td></td><td></td></tr>
                <tr><td>NAMA PEGAWAI</td><td><?php echo $this->data[3]; ?></td></tr>
                <tr><td>NIP</td><td><?php echo $this->data[4]; ?></td></tr>
                <tr><td>NAMA USER</td><td><?php echo $this->data[1]; ?></td></tr>
                <tr><td>JABATAN</td><td>
                        <?php
                            echo Admin_Model::getJabatanUser($this->data[5],$this->data[6]);
                        ?>
                    </td></tr>
                <form id="form-rekam">
                <input id="id" type="hidden" name="id" value="<?php echo $this->data[0];?>">
                <tr><td colspan="2" halign="center">UBAH PASSWORD</td></tr>
                <tr><td>PASSWORD LAMA</td><td><input id="pwlama" type="password" ></td></tr>
                <tr><td>PASSWORD BARU</td><td><input id="pwbaru1" type="password"></td></tr>
                <tr><td>ULANGI PASSWORD BARU</td><td><input id="pwbaru2" type="password"></td></tr>
                <tr><td>STATUS AKTIF</td><td><a ><input class="btn" type="button" value="<?php echo $this->data[8]; ?>" onclick="return setaktifuser('<?php echo $this->data[0].'-'.$this->data[8];?>',<?php echo $this->data[0];?>,<?php echo $this->data[6];?>,<?php echo $this->data[7];?>);"></a></td></tr>
                <tr><td></td><td><input type="button" class="btn"name="submit" value="SIMPAN" onclick="return cek()"></td></tr>
                </form>
            </table></div>
</br>
</td><td width="50%">
<h3>Rekam Pengganti</h3><hr>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>NAMA PEGAWAI</th><th>PILIH PJS</th></tr>
    <?php foreach($this->user as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['namaPegawai']; ?></td>
        <td><a ><input class="btn" type="button" value="Pilih" onclick="return cekrole(<?php echo $role;?>,'<?php echo $value['username'];?>',<?php echo $this->data[6];?>,<?php echo $this->data[7];?>)"></td>
    <?php $no++; }?>
<!--                href="<?php echo URL;?>admin/rekamPjs/<?php echo $value['username'];?>"-->
</table></div>
<?php } ?>

</td></tr></table>

<script type="text/javascript">
    function cekrole(roleu, id, bagian, rolep){
        if(roleu==3){
            alert('Anda tidak bisa mengakses fasilitas ini');
            return false;
        }else{
            return cekexistpjs(id, bagian, rolep);
            return true;
        }
    }
    
    function cekexistpjs(id,bagian, jabatan){
        var jml = 0;
        $.ajax({
            type:'post',
            url:'<?php echo URL?>admin/cekPejabat',
            data:'bagian='+bagian+
                '&jabatan='+jabatan,
            dataType:'json',
            success:function(data){
                if(data.hasil>=1){
                    jml+=data.hasil;
                    var walamat = '<div id=warning>Non aktifkan pejabat definitif terlebih dahulu!</div>';
                    $('#pesan').fadeIn(500);
                    $('#pesan').html(walamat);
                    return false;
                }else{
                    $.ajax({
                    type:'post',
                    url:'<?php echo URL?>admin/cekExistPjs',
                    data:'bagian='+bagian+
                        '&jabatan='+jabatan,
                    dataType:'json',
                    success:function(data){
                        if(data.pjs>=1){
                            jml+=data.pjs;
                            var walamat = '<div id=warning>Pejabat sementara Jabatan ini telah ada, hubungi Admin untuk menghapusnya!</div>';
                            $('#pesan').fadeIn(500);
                            $('#pesan').html(walamat);
                            return false
                        }else{
                            $.ajax({ //bagian ini kayaknya gak perlu
                            type:'post',
                            url:'<?php echo URL?>admin/cekExistPjs',
                            data:'bagian='+bagian+
                                '&id='+id+
                                '&jabatan='+jabatan,
                            dataType:'json',
                            success:function(data){
                                if(data.pjs>=1){
                                    jml+=data.pjs;
                                    var walamat = '<div id=warning>Pegawai bersangkutan telah tercatat sebagai Pjs Jabatan ini!</div>';
                                    $('#pesan').fadeIn(500);
                                    $('#pesan').html(walamat);
                                    return false
                                }else{
                                    rekam(id,bagian,jabatan);
                                }
                            }
                        });
                        }
                    }
                });
                
                }
            }
        });
//        document.write(jml);
        
        
    }
    
    function setaktifuser(id,id_user, bagian, jabatan){
        $.ajax({
            type:'post',
            url:'<?php echo URL?>admin/cekExistPjs',
            data:'bagian='+bagian+
                '&jabatan='+jabatan,
            dataType:'json',
            success:function(data){
                if(data.pjs>=1){
                    var walamat = '<div id=warning>Pejabat sementara Jabatan ini masih ada, hubungi Admin untuk menghapusnya!</div>';
                    $('#pesan').fadeIn(500);
                    $('#pesan').html(walamat);
                    return false;
                }else{
                    $.post("<?php echo URL; ?>admin/setAktiveUser", {queryString:""+id+""},
                        function(data){
                            $('#pesan').fadeIn(500);
                            $('#pesan').html(data);
                            window.setTimeout(function(){
                                location.reload(500)
                            }
                            ,5000);
                        });
                }
            }
        });
        
        
    }
    
    function cek(){
        var id = document.getElementById('id').value;
        var pwlama = document.getElementById('pwlama').value;
        var pwbaru1 = document.getElementById('pwbaru1').value;
        var pwbaru2 = document.getElementById('pwbaru2').value;
        if(pwlama==''){
            var data = '<div id=error>Password lama harus diisi!</div>'
            $('#pesan').fadeIn(200);
            $('#pesan').html(data);
            return false;
        }else if(pwbaru1=='' || pwbaru2==''){
            var data = '<div id=error>Password baru harus diisi!</div>'
            $('#pesan').fadeIn(200);
            $('#pesan').html(data);
            return false;
        }else if(pwbaru1!=pwbaru2){
            var data = '<div id=error>Password baru tidak sama!</div>'
            $('#pesan').fadeIn(200);
            $('#pesan').html(data);
            return false;
        }else{
            $('#pesan').fadeOut(500);
            $.ajax({
                type:'post',
                url:'<?php echo URL;?>admin/cekUserPassword',
                data:'id='+id+
                    '&password='+pwlama,
                dataType:'json',
                success:function(data){
                    if(data.hasil==0){
                        var pesan = '<div id=error>Password lama tidak sama dengan database!</div>'
                        $('#pesan').fadeIn();
                        $('#pesan').html(pesan);
                        return false;
                    }
                }
            });
        }
        
        
        
    }
    
    function rekam(id, bagian, role){
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/inputRekamPjs',
            data:'bagian='+bagian+
                '&jabatan='+role+
                '&id='+id,
            dataType:'json',
            success:function(data){
                if(data.status=='success'){
                    $('#pesan').fadeIn();
                    $('#pesan').html(data.message);
                    window.setTimeout(function(){
                        location.reload(500)
                    }
                    ,3000);
                }else if(data.status=='error'){
                    $('#pesan').fadeIn();
                    $('#pesan').html(data.message);
                }
                
            }
        });
    }
</script>