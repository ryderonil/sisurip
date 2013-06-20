<div class="divleft"><h2>Ubah Alamat Surat</h2></div>            
<hr>
<div id="pesan"></div>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">
<!--        <form id="form-rekam" method="POST" action="<?php echo URL;?>admin/updateRekamAlamat">-->
        
        <input id="id" type="hidden" name="id" value="<?php echo $this->id;?>">
        <!--<label>KEMENTERIAN/LEMBAGA</label><select></select></br>
        <label>UNIT</label><select></select></br>-->
        <div><label>TIPE ALAMAT</label><select id="tipe" name="tipe" >
                <option value="A" <?php if($this->tipe == 'A') echo 'selected';?>>KANTOR PEMERINTAH</option>
                <option value="B" <?php if($this->tipe == 'B') echo 'selected'; ?>>NON PEMERINTAH</option>
            </select></div>
        <div id="wkode"></div>
        <div><label>KODE ALAMAT</label><input type="text" id="kdsatker" name="kode_satker" 
                                         value="<?php echo isset($this->satker)?$this->satker:$this->kode_satker;?>" size="8" onkeyup="cekemptyfield(1,this.value)">
        <a href="<?php echo URL;?>helper/pilihsatker/<?php echo $this->id;?>"><input type="button" value="+"></a></br>
        </div><div id="wnama"></div>
        <label>NAMA ALAMAT</label><input  type="text" id="nmsatker" name="nama_satker" 
                                         size="40" value="<?php echo isset($this->nm_satker)?$this->nm_satker :$this->nama_satker;?>" size="40" onkeyup="cekemptyfield(2,this.value)">
        <!--<div id="nmsatker"></div>--></br>
        <label>JABATAN</label><input id="jabatan" type="text" size="30" name="jabatan" value="<?php echo $this->jabatan;?>"></br>
        <div id="walamat"></div>
        <label>ALAMAT</label><input id="alamat"  type="text" name="alamat" size="60" value="<?php echo $this->alamat;?>" onkeyup="cekemptyfield(3,this.value)"></br>
        <div id="wtelp"></div>
        <label>TELEPON</label><input id="telp" type="text" name="telepon" value="<?php echo $this->telepon;?>" onkeyup="cekemptyfield(4,this.value)"></br>
        <div id="wemail"></div>
        <label>EMAIL</label><input id="email" type="text" name="email" size="25" value="<?php echo $this->email;?>" onkeyup="cekemptyfield(5,this.value)"></br>
        <label></label><input class="btn cancel" type="button" value="BATAL" onclick="location.href='<?php echo URL;?>admin/rekamAlamat'"><input type="submit" class="btn save" name="submit" value="SIMPAN" onclick="return selesai()">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
</form>
</div>
</br>
<hr>
</br>
<?php if(!is_null($this->data)){?>
<div id="table-wrapper" style="overflow:scroll; height:400px;">
<table class="CSSTableGenerator">
    <tr><td>NO</td><td>NAMA ALAMAT</td><td>ALAMAT</td></tr>
    <?php
        $no=1;
        foreach($this->data as $value){
            echo "<tr><td valign=top halign=center>$no</td>
                    <td><a href=".URL."admin/ubahAlamat/$value[id_alamat]>$value[kode_satker]</br> ".  strtoupper($value['jabatan'])." $value[nama_satker]</a></td>
                    <td>$value[alamat]</br>Telp.$value[telepon], Email $value[email]</td></tr>";
            $no++;
        }
    ?>
</table>
</div>
<?php } ?>
    <script type="text/javascript">
    
    $(document).ready(function(){
        $("input").blur(function(){
            $('#nmsatke').fadeOut()
        }); 
    });
    
    function lookup(alamat){
        if(alamat.length == 0){
            $('#nmsatke').fadeOut();
        }else{
            $.post("<?php echo URL;?>helper/cekalamat", {queryString:""+alamat+""},
            function(data){
                $('#nmsatke').fadeIn();
                $('#nmsatke').html(data);
            });
        }
    }
    
    function selesai(){
        var answer = "Anda yakin merubah data alamat ini?";
        if(confirm(answer)){
            cek();
            return true;
        }else{
            return false;
        }
    }
    function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Kode alamat belum diisi, Pilih kode satker/alamat, atau buat kode sendiri!</div>'
                    $('#wkode').fadeIn(500);
                    $('#wkode').html(walamat);
                }else{
                    var pola = /^[0-9]{5}$/;
                    if(pola.test(content)==false){
                        var walamat = '<div id=warning>Kode alamat harus 5 digit angka!</div>'
                        $('#wkode').fadeIn(500);
                        $('#wkode').html(walamat);
                    }else{
                        $('#wkode').fadeOut(500);
                    }
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Nama alamat belum diisi!</div>'
                    $('#wnama').fadeIn(500);
                    $('#wnama').html(wtgl);
                }else{
                    $('#wnama').fadeOut(500);
                } 
                break;
            case 3:
                if(content==''){
                    var wtgl = '<div id=warning>Alamat belum diisi! [nama jalan, kota dsb]</div>'
                    $('#walamat').fadeIn(500);
                    $('#walamat').html(wtgl);
                }else{
                    $('#walamat').fadeOut(500);
                } 
                break;
            case 4:
                if(content!=''){
                    var pola = /^0([1-9]{2,3})[-. ]([0-9]{5,7})$/;
                    if(pola.test(content)==false){
                        var wtgl = '<div id=warning>Isikan format telepon yang benar (kode area-nomor telepon)!</div>'
                        $('#wtelp').fadeIn(500);
                        $('#wtelp').html(wtgl);
                    }else{
                        $('#wtelp').fadeOut(500);
                    }
                    
                }else{
                    $('#wtelp').fadeOut(500);
                } 
                break;
            case 5:
                if(content!=''){
                    var pola = /^[a-zA-Z0-9]*(|[-._][a-zA-Z0-9]*)\@([a-z]*)[.]([a-z]{3,4})/;
                    if(pola.test(content)==false){
                        var wtgl = '<div id=warning>Isikan format email yang benar!</div>'
                        $('#wemail').fadeIn(500);
                        $('#wemail').html(wtgl);
                    }else{
                        $('#wemail').fadeOut(500);
                    }
                    
                }else{
                    $('#wemail').fadeOut(500);
                } 
                break;
        }
    }
    
    function cek(){
        var kode = document.getElementById('kdsatker').value;
        var nama = document.getElementById('nmsatker').value;
        var alamat = document.getElementById('alamat').value;
        var telp = document.getElementById('telp').value;
        var email = document.getElementById('email').value;
        var jml = 0;
        if(kode==''){
            jml++;
            var wtgl = '<div id=warning>Kode alamat belum diisi, Pilih kode satker/alamat, atau buat kode sendiri!</div>'
            $('#wkode').fadeIn(500);
            $('#wkode').html(wtgl);
        }
        
        if(nama==''){
            jml++;
            var walamat = '<div id=warning>Nama alamat belum diisi!</div>'
            $('#wnama').fadeIn(500);
            $('#wnama').html(walamat);
        }
        
        if(alamat==''){
            jml++;
            var wtgl = '<div id=warning>Alamat belum diisi! [nama jalan, kota dsb]</div>'
            $('#walamat').fadeIn(500);
            $('#walamat').html(wtgl);
        }
        
        if(telp!=''){
            jml++;
            var pola = /^0([1-9]{2,3})[-. ]([0-9]{5,7})$/;
            if(pola.test(content)==false){
                var wtgl = '<div id=warning>Isikan format telepon yang benar (kode area-nomor telepon)!</div>'
                $('#wtelp').fadeIn(500);
                $('#wtelp').html(wtgl);
            }else{
                $('#wtelp').fadeOut(500);
            }
        }
        
        if(email!=''){
            jml++;
            var pola = /^[a-zA-Z0-9]*(|[-._][a-zA-Z0-9]*)\@([a-z]*)[.]([a-z]{3,4})/;
            if(pola.test(content)==false){
                var wtgl = '<div id=warning>Isikan format email yang benar!</div>'
                $('#wemail').fadeIn(500);
                $('#wemail').html(wtgl);
            }else{
                $('#wemail').fadeOut(500);
            }
        }
        
        if(jml>0){
            return false;
        }else{
            ubah();
            return true;
        }
    }
    
    function ubah(){
        var id = document.getElementById('id').value;
        var kode = document.getElementById('kdsatker').value;
        var nama = document.getElementById('nmsatker').value;
        var jabatan = document.getElementById('jabatan').value;
        var alamat = document.getElementById('alamat').value;
        var telp = document.getElementById('telp').value;
        var email = document.getElementById('email').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/updateRekamAlamat',
            data:'id_alamat='+id+
                '&kode_satker='+kode+
                '&nama_satker='+nama+
                '&jabatan='+jabatan+
                '&alamat='+alamat+
                '&telepon='+telp+
                '&email='+email,
            success:function(data){
                $('#pesan').fadeIn();
                $('#pesan').html(data);
            }
        });
    }

    </script>