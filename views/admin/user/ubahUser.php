<div class="divleft"><h2>Pengaturan Pengguna</h2><hr></div>
<div id="pesan"></div>
<div id="form-wrapper"><h1>UBAH PENGGUNA</h1>
<form id="form-rekam">
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamUser">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input id="id" type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <div id="wnama"></div>
    <label>NAMA PEGAWAI</label><input id="nama"  type="text" size="50" name="namaPegawai" value="<?php echo $this->data[3]; ?>" onkeyup="cekemptyfield(1,this.value)"></br>
    <div id="wnip"></div>
    <label>NIP</label><input id="nip"  type="text" size="18" name="NIP" value="<?php echo $this->data[4]; ?>" onkeyup="cekemptyfield(2,this.value)"></br>
    <div id="wuser"></div>
    <label>NAMA USER</label><input id="usern"  type="text" size="15" name="username" value="<?php echo $this->data[1]; ?>" onkeyup="cekemptyfield(3,this.value)"></br>
    <div id="wpass"></div>
    <label>PASSWORD</label><input id="pass"  type="text" size="20" name="password" value="<?php //echo $this->data[2]; ?>"></br>
    <div id="wbag"></div>
    <label>BAGIAN</label><select id="bag"  name="bagian" onchange="cekemptyfield(5,this.value)">
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
    <div id="wjabatan"></div>
    <label>JABATAN</label><select id="jabatan"  name="jabatan" onchange="cekemptyfield(6,this.value)">
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
    <div id="wrole"></div>
    <label>ROLE</label><select id="role"  name="role" onchange="cekemptyfield(7,this.value)">
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
    <label></label><input class="btn cancel" type="button" onclick="location.href='<?php echo URL;?>admin/rekamUser'" value="BATAL" ><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="return selesai(1,'<?php echo $this->data[3];?>');">
                    <input class="btn write" type="button" onclick="location.href='<?php echo URL;?>admin/rekamPjs/<?php echo $this->data[1];?>'" value="PENGGANTI">
</form></div>
</br>
<hr>
</br>
<div id="table-wrapper" style="overflow:auto; height:400px;"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>NAMA PEGAWAI</td><td>NAMA USER</td><td>AKSI</td><td>AKTIF</td></tr>
    <?php $no=1; foreach($this->user as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['namaPegawai']; ?></td>
        <td><?php echo $value['username']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahUser/<?php echo $value['id_user'];?>"><input class="btn edit" type="button" value="UBAH"></a> | 
            <a ><input class="btn btn-danger" type="button" value="HAPUS" onclick="return selesai(2,'<?php echo $value['namaPegawai'];?>',<?php echo $value['id_user'];?>);"></a></td>
        <td><a ><input class="btn" type="button" value="<?php echo $value['active']; ?>" onclick="setaktifuser('<?php echo $value['id_user'].'-'.$value['active'];?>');"></a></td></tr>
    <?php $no++; }?>
</table></div>

<script type="text/javascript">

function selesai(num,usern, id)
    {
        if(num==1){
            var answer = confirm('Yakin menyimpan perubahan pengguna atas nama : '+usern+"?")
        }else if(num==2){
            var answer = confirm('Pengguna atas nama : '+usern+" akan dihapus?")
        }
        
        if (answer){
            if(num==1){
                cek();
            }else{
                $.ajax({
                type:'post',
                url:'<? echo URL; ?>admin/hapusUser',
                data:'id='+id,
                success:function(){
                    window.location.href='<?php echo URL; ?>admin/rekamUser';
                }
            })
            }
            
            return true;
        }else{
            //window.location='<?php echo URL; ?>admin/ubahLokasi/<?php echo $this->data[0]; ?>';
            return false; 
        }
    }

function setaktifuser(id){
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
    
    function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Nama pegawai harus diisi!</div>'
                    $('#wnama').fadeIn(500);
                    $('#wnama').html(walamat);
                }else{
                    $('#wnama').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>NIP pegawai harus diisi!</div>'
                    $('#wnip').fadeIn(500);
                    $('#wnip').html(wtgl);
                }else{
                    var pola = /^[0-9]*$/;
                    if(pola.test(content)==false){
                        var walamat = '<div id=warning>NIP harus terdiri dari angka!</div>'
                        $('#wnip').fadeIn(500);
                        $('#wnip').html(walamat);
                    }else{
                        if(content.length==9 || content.length==18){
                            $.ajax({
                                type:'post',
                                url:'<?php echo URL; ?>admin/cekUser',
                                data:'nip='+content,
                                dataType:'json',
                                success:function(data){
                                    if(data.hasil==1){
                                        var walamat = '<div id=warning>Pegawai ini telah memiliki akun user!</div>'
                                        $('#wnip').fadeIn(500);
                                        $('#wnip').html(walamat);
                                    }else{
                                        $('#wnip').fadeOut(500);
                                    }
                                }
                            });
                        }else{
                            var walamat = '<div id=warning>NIP tidak valid!</div>'
                            $('#wnip').fadeIn(500);
                            $('#wnip').html(walamat);
                        }
                    }
                    
                    
                } 
                break;
            case 3:
                if(content==''){
                    var walamat = '<div id=warning>Nama user harus diisi!</div>'
                    $('#wuser').fadeIn(500);
                    $('#wuser').html(walamat);
                }else{
                    $.ajax({
                        type:'post',
                        url:'<?php echo URL; ?>admin/cekUser',
                        data:'user='+content,
                        dataType:'json',
                        success:function(data){
                            if(data.hasil==1){
                                var walamat = '<div id=warning>Nama user ini telah dipakai!</div>'
                                $('#wuser').fadeIn(500);
                                $('#wuser').html(walamat);
                            }else{
                                $('#wuser').fadeOut(500);
                            }
                        }
                    });
                    
                } 
                break;
            case 4:
                if(content==''){
                    var wtgl = '<div id=warning>Password harus diisi!</div>'
                    $('#wpass').fadeIn(500);
                    $('#wpass').html(wtgl);
                }else{
                    $('#wpass').fadeOut(500);
                    
                } 
                break;
            case 5:
                if(content==''){
                    var wtgl = '<div id=warning>Bagian belum dipilih!</div>'
                    $('#wbag').fadeIn(500);
                    $('#wbag').html(wtgl);
                }else{
                    $('#wbag').fadeOut(500);
                    
                } 
                break;
            case 6:
                if(content==''){
                    var walamat = '<div id=warning>Jabatan belum dipilih!</div>'
                    $('#wjabatan').fadeIn(500);
                    $('#wjabatan').html(walamat);
                }else{
                    $('#wjabatan').fadeOut(500);
                } 
                break;
            case 7:
                if(content==''){
                    var wtgl = '<div id=warning>Role pegawai belum dipilih!</div>'
                    $('#wrole').fadeIn(500);
                    $('#wrole').html(wtgl);
                }else{
                    $('#wrole').fadeOut(500);
                    
                } 
                break;
        }
    }
    
    function cek(){
        var nama = document.getElementById('nama').value;
        var nip = document.getElementById('nip').value;
        var user = document.getElementById('usern').value;
        var pass = document.getElementById('pass').value;
        var bagian = document.getElementById('bag').value;
        var jabatan = document.getElementById('jabatan').value;
        var role = document.getElementById('role').value;
        var jml = 0;
        if(nama==''){
            jml++;
            var walamat = '<div id=warning>Nama pegawai harus diisi!</div>'
            $('#wnama').fadeIn(500);
            $('#wnama').html(walamat);
        }
        
        if(nip==''){
            jml++;
            var wtgl = '<div id=warning>NIP pegawai harus diisi!</div>'
            $('#wnip').fadeIn(500);
            $('#wnip').html(wtgl);
        }else{
            var pola = /^[0-9]*$/;
            if(pola.test(nip)==false){
                var walamat = '<div id=warning>NIP harus terdiri dari angka!</div>'
                $('#wnip').fadeIn(500);
                $('#wnip').html(walamat);
            }else{
                if(nip.length==9 || nip.length==18){
                    $.ajax({
                        type:'post',
                        url:'<?php echo URL; ?>admin/cekUser',
                        data:'nip='+content,
                        dataType:'json',
                        success:function(data){
                            if(data.hasil==1){
                                var walamat = '<div id=warning>Pegawai ini telah memiliki akun user!</div>'
                                $('#wnip').fadeIn(500);
                                $('#wnip').html(walamat);
                            }else{
                                $('#wnip').fadeOut(500);
                            }
                        }
                    });
                }else{
                    var walamat = '<div id=warning>NIP tidak valid!</div>'
                    $('#wnip').fadeIn(500);
                    $('#wnip').html(walamat);
                }
            }
            
        }
        
        if(user==''){
            jml++;
            var walamat = '<div id=warning>Nama user harus diisi!</div>'
            $('#wuser').fadeIn(500);
            $('#wuser').html(walamat);
        }else{
            $.ajax({
                type:'post',
                url:'<?php echo URL; ?>admin/cekUser',
                data:'user='+user,
                dataType:'json',
                success:function(data){
                    if(data.hasil==1){
                        jml++;
                        var walamat = '<div id=warning>Nama user ini telah dipakai!</div>'
                        $('#wuser').fadeIn(500);
                        $('#wuser').html(walamat);
                        return false;
                    }
                }
            });
        }
        
        if(pass==''){
            jml++;
            var wtgl = '<div id=warning>Password harus diisi!</div>'
            $('#wpass').fadeIn(500);
            $('#wpass').html(wtgl);
        }
        
        if(bagian==''){
            jml++;
            var wtgl = '<div id=warning>Bagian belum dipilih!</div>'
            $('#wbag').fadeIn(500);
            $('#wbag').html(wtgl);
        }
        
        if(jabatan==''){
            jml++;
            var walamat = '<div id=warning>Jabatan belum dipilih!</div>'
            $('#wjabatan').fadeIn(500);
            $('#wjabatan').html(walamat);
        }
        
        if(role==''){
            jml++;
            var wtgl = '<div id=warning>Role pegawai belum dipilih!</div>'
            $('#wrole').fadeIn(500);
            $('#wrole').html(wtgl);
        }
        
        if(jml>0){
            return false;
        }else{
            rekam();
            return true;
        }
    }
    
    function rekam(){
        var id = document.getElementById('id').value;
        var nama = document.getElementById('nama').value;
        var nip = document.getElementById('nip').value;
        var user = document.getElementById('usern').value;
        var pass = document.getElementById('pass').value;
        var bagian = document.getElementById('bag').value;
        var jabatan = document.getElementById('jabatan').value;
        var role = document.getElementById('role').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL; ?>admin/inputRekamUser',
            data:'namaPegawai='+nama+
                '&id='+id+
                '&NIP='+nip+
                '&username='+user+
                '&password='+pass+
                '&bagian='+bagian+
                '&jabatan='+jabatan+
                '&role='+role,
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
