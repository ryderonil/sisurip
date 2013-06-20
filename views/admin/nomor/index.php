<div class="divleft"><h2>Tambah Format Nomor Surat</h2></div>
<hr>
<!--<table><tr><td width="50%" valign="top">-->
<div id="pesan"></div>
<div class="divleft"><div id="btn-show"></br><input  class="btn save" type="button" name="submit" value="REKAM" onclick="displayform()"></div>
</div><div id="form-wrapper">
<form id="form-rekam" >
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamNomor">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <div id="wnomor"></div>   
    <label>FORMAT NOMOR</label><input id="nomor"  type="text" size="30" name="nomor" onkeyup="cekemptyfield(1,this.value);"></br>
    <div id="wbagian"></div> 
    <label>BAGIAN</label><select id="bagian"  name="bagian" onchange="cekemptyfield(2,this.value);">
        <option name="" value="" selected>--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value) { ?>
        <option value="<?php echo $value['kd_bagian'];?>"> <?php echo strtoupper($value['bagian']);?></option>
        <?php } ?>
    </select></br>
    <label></label><input class="btn reset" type="reset" value="RESET"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="cek()">
</form></div>
</br>
<hr>
</br>
<!--</td><td width="50%">-->
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>BAGIAN</td><td>KODE NOMOR</td><td>AKSI</td></tr>
    <?php foreach($this->nomor as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['bagian']; ?></td>
        <td><?php echo $value['kd_nomor']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahNomor/<?php echo $value['id_nomor'];?>"><input class="btn edit" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusNomor/<?php echo $value['id_nomor'];?>"><input class="btn btn-danger" type="button" value="HAPUS" onclick="return selesai();"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>
<!--</td></tr></table>-->
<script type="text/javascript">
    
    function selesai()
{
    
        var answer = confirm ("Anda yakin data ini akan dihapus?")
   
  
    if (answer){
        return true;
    }else{
        
        return false;
    }
    
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
                    var walamat = '<div id=warning>Format nomor harus diisi!</div>'
                    $('#wnomor').fadeIn(500);
                    $('#wnomor').html(walamat);
                }else{
                    $('#wnomor').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Bagian belum dipilih!</div>'
                    $('#wbagian').fadeIn(500);
                    $('#wbagian').html(wtgl);
                }else{
                    $('#wbagian').fadeOut(500);
                    
                } 
                break;
        }
    }
    
    function cek(){
        var nomor = document.getElementById('nomor').value;
        var bagian = document.getElementById('bagian').value;
        var jml = 0;
        if(nomor==''){
            jml++;
            var walamat = '<div id=warning>Format nomor harus diisi!</div>'
            $('#wnomor').fadeIn(500);
            $('#wnomor').html(walamat);
        }
        
        if(bagian==''){
            jml++;
            var wtgl = '<div id=warning>Bagian belum dipilih!</div>'
            $('#wbagian').fadeIn(500);
            $('#wbagian').html(wtgl);
        }
        
        if(jml>0){
            return false;
        }else{
            rekam();
            return true;
        }
    }
    
    function rekam(){
        var bagian = document.getElementById('bagian').value;
        var nomor = document.getElementById('nomor').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/inputRekamNomor',
            data:'bagian='+bagian+
                '&nomor='+nomor,
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
