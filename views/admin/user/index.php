<div class="divleft"><h2>Pengaturan Pengguna</h2><hr></div>
<div id="pesan"></div>
<div class="divleft"><div id="btn-show"></br><input  class="btn write" type="button" name="submit" value="REKAM" onclick="displayform()"></div></div>
<div id="form-wrapper"><h1>REKAM PENGGUNA</h1>
<form id="form-rekam" >
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamUser">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <div id="wnama"></div>
    <label>NAMA PEGAWAI</label><input id="nama" type="text" size="50" name="namaPegawai" onkeyup="cekemptyfield(1,this.value)"></br>
    <div id="wnip"></div>
    <label>NIP</label><input id="nip"  type="text" size="18" name="NIP" onkeyup="cekemptyfield(2,this.value)"></br>
    <div id="wuser"></div>
    <div><label>NAMA USER</label><input id="usern"  type="text" size="15" name="username" onkeyup="cekemptyfield(3,this.value)"></br>
    </div><div id="wpass"></div>
    <div><label>PASSWORD</label><input id="pass"  type="text" size="20" name="password" onkeyup="cekemptyfield(4,this.value)"></br>
    </div><div id="wbag"></div>
    <label>BAGIAN</label><select id="bag"  name="bagian" onchange="cekemptyfield(5,this.value)">
        <option value="">--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value){
                echo '<option value='.$value['id_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></br>
    <div id="wjabatan"></div>
    <label>JABATAN</label><select id="jabatan"  name="jabatan" onchange="cekemptyfield(6,this.value)">
        <option value="">--PILIH JABATAN--</option>
        <?php foreach($this->jabatan as $key=>$value){
                echo '<option value='.$value['id_jabatan'].'>'.strtoupper($value['nama_jabatan']).'</option>';
            }
        ?>
    </select></br>
    <div id="wrole"></div>
    <label>ROLE</label><select id="role"  name="role" onchange="cekemptyfield(7,this.value)">
        <option value="">--PILIH ROLE--</option>
        <?php foreach($this->role as $key=>$value){
                echo '<option value='.$value['id_role'].'>'.strtoupper($value['role']).'</option>';
            }
        ?>
    </select></br>   
    <label></label><input class="btn reset" type="reset" name="submit" value="RESET"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="cek()">
</form></div>
</br>
<hr>
</br>
<div id="pesan"></div>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>NAMA PEGAWAI</td><td>NAMA USER</td><td>AKSI</td><td>AKTIF</td></tr>
    <?php foreach($this->user as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['namaPegawai']; ?></td>
        <td><?php echo $value['username']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahUser/<?php echo $value['id_user'];?>"><input class="btn edit" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusUser/<?php echo $value['id_user'];?>"><input class="btn btn-danger" type="button" value="HAPUS" onclick="return selesai('<?php echo $value['username'];?>');"></a></td>
        <td><a ><input class="btn" type="button" value="<?php echo $value['active']; ?>" onclick="return setaktifuser('<?php echo $value['id_user'].'-'.$value['active'];?>',<?php echo $value['bagian']; ?>,<?php echo $value['role']; ?>); "></a></td></tr>
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
    
    function setaktifuser(id, bagian, jabatan){
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
    
    $(document).ready(function(){
        $('#form-wrapper').fadeOut(0);
    });
    
    function displayform(){
        $('#btn-show').fadeOut(500);
        $('#form-wrapper').fadeIn(500);
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
                        data:'nip='+nip,
                        dataType:'json',
                        success:function(data){
                            if(data.hasil==1){
                                var walamat = '<div id=warning>Pegawai ini telah memiliki akun user!</div>'
                                $('#wnip').fadeIn(500);
                                $('#wnip').html(walamat);
                                return false;
                            }else{
                                $('#wnip').fadeOut(500);
                            }
                        }
                    });
                }else{
                    jml++;
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