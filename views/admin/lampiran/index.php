<div class="divleft"><h2>Pengaturan Tipe Naskah</h2><hr></div>
<!--<table><tr><td width="50%" valign="top">-->
<div id="pesan"></div>
<div class="divleft"><div id="btn-show"></br><input  class="btn write" type="button" name="submit" value="REKAM" onclick="displayform()"></div>
</div><div id="form-wrapper"><h1>REKAM TIPE NASKAH DINAS</h1>
<form id="form-rekam" >    
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamLampiran">    -->
     <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>           
    <div id="wtipe"></div>    
    <div><label>TIPE NASKAH DINAS</label><input id="tipe"  type="text" size="40" name="tipe_naskah" onkeyup="cekemptyfield(1,this.value)"></br>
    </div><div id="wkdsurat"></div>
    <div><label>KODE SURAT</label><input id="kdsurat"  type="text" size="10" name="kode_naskah" onkeyup="cekemptyfield(2,this.value)"></br>
    </div><label></label><input class="btn reset" type="reset" name="submit" value="RESET"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="cek()">
</form></div>
</br>
<hr>
</br>
<!--        </td><td width="50%">-->
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>TIPE NASKAH</td><td>AKSI</td></tr>
    <?php foreach($this->lampiran as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>        
        <td><?php echo $value['tipe_naskah']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahLampiran/<?php echo $value['id_tipe'];?>"><input class="btn edit" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusLampiran/<?php echo $value['id_tipe'];?>"><input class="btn btn-danger" type="button" value="HAPUS" onclick="return selesai('<?php echo $value['tipe_naskah']; ?>');"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>
<!--        </td></tr></table>-->
<script type="text/javascript">

$(document).ready(function(){
        $('#form-wrapper').fadeOut(0);
    });
    
    function displayform(){
        $('#btn-show').fadeOut(500);
        $('#form-wrapper').fadeIn(500);
    }
    
function selesai(lamp){
    
    var answer = 'Tipe naskah dinas : '+lamp+" akan dihapus?"
    
    if(confirm(answer)){
        return true;
    }else{
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
            rekam();
            return true;
        }
    }
    
    function rekam(){
        var tipe = document.getElementById('tipe').value;
        var kode = document.getElementById('kdsurat').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/inputRekamLampiran',
            data:'tipe_naskah='+tipe+
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