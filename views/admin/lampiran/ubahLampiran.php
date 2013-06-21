<div class="divleft"><h2>Pengaturan Tipe Naskah</h2></div>
<hr>
<!--<table><tr><td width="50%" valign="top">-->
<div id="pesan"></div>
<div id="form-wrapper"><h1>UBAH TIPE NASKAH DINAS</h1>
<form id="form-rekam" >
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamLampiran">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input id="id" type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <div id="wtipe"></div>
    <div><label>TIPE NASKAH DINAS</label><input id="tipe"  type="text" size="40" name="tipe_naskah" value="<?php echo $this->data[1];?>" onkeyup="cekemptyfield(1,this.value)"></br>
    </div><div id="wkdsurat"></div>
    <div><label>KODE SURAT</label><input id="kdsurat"  type="text" size="10" name="kode_naskah" value="<?php echo $this->data[2];?>" onkeyup="cekemptyfield(2,this.value)"></br>
    </div><label></label><input class="btn cancel" type="button" value="BATAL" onclick="location.href='<?php echo URL;?>admin/rekamJenisLampiran';"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="return selesai(1,'<?php echo $this->data[2];?>');">
</form></div>

</br>
<hr>
</br>
<!--</td><td width="50%">-->
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>TIPE NASKAH</td><td>AKSI</td></tr>
    <?php $no=1; foreach($this->lampiran as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>        
        <td><?php echo $value['tipe_naskah']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahLampiran/<?php echo $value['id_tipe'];?>"><input class="btn edit" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusLampiran/<?php echo $value['id_tipe'];?>"><input class="btn btn-danger" type="button" value="HAPUS" onclick="return selesai(2,'<?php echo $value['tipe_naskah']; ?>');" ></a></td></tr>
    <?php $no++; }?>
</table></div>
<!--</td></tr></table>-->
<script type="text/javascript">

    function selesai(num,lamp)
    {
        if(num==1){
            var answer = confirm('Yakin menyimpan perubahan tipe naskah dinas : '+lamp+"?")
        }else if(num==2){
            var answer = confirm('Tipe naskah dinas : '+lamp+" akan dihapus?")
        }
        
        if (answer){
            if(num==1){
                cek();
            }
            
            return true;
        }else{
            //window.location='<?php echo URL; ?>admin/ubahLokasi/<?php echo $this->data[0]; ?>';
            return false; 
        }
    }
    
    function cekemptyfield(num, content){
        switch (num) {
            case 1:
                if(content==''){
                    var walamat = '<div id=warning>Tipe naskah dinas harus diisi!</div>'
                    $('#wtipe').fadeIn(500);
                    $('#wtipe').html(walamat);
                }else{
                    $('#wtipe').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Kode nomor surat harus diisi!</div>'
                    $('#wkdsurat').fadeIn(500);
                    $('#wkdsurat').html(wtgl);
                }else{
                    if(content.length>5){
                        var wtgl = '<div id=warning>Kode nomor surat harus tidak lebih dari 5 karakter!</div>'
                        $('#wkdsurat').fadeIn(500);
                        $('#wkdsurat').html(wtgl);
                    }else{
                        $('#wkdsurat').fadeOut(500);
                    }
                } 
                break;
        }
    }
    
    function cek(){
        var tipe = document.getElementById('tipe').value;
        var kode = document.getElementById('kdsurat').value;
        var jml = 0;
        if(tipe==''){
            jml++;
            var walamat = '<div id=warning>Tipe naskah dinas harus diisi!</div>'
            $('#wtipe').fadeIn(500);
            $('#wtipe').html(walamat);
        }
        
        if(kode==''){
            jml++;
            var wtgl = '<div id=warning>Kode nomor surat harus diisi!</div>'
            $('#wkdsurat').fadeIn(500);
            $('#wkdsurat').html(wtgl);
        }else{
            if(kode.length>5){
                var wtgl = '<div id=warning>Kode nomor surat harus tidak lebih dari 5 karakter!</div>'
                $('#wkdsurat').fadeIn(500);
                $('#wkdsurat').html(wtgl);
            }else{
                $('#wkdsurat').fadeOut(500);
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
        var tipe = document.getElementById('tipe').value;
        var kode = document.getElementById('kdsurat').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL; ?>admin/updateRekamLampiran',
            data:'id='+id+
                '&tipe_naskah='+tipe+
                '&kode_naskah='+kode,
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