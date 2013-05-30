<h2>Ubah Format Nomor Surat</h2><hr>
<div id="pesan"></div>
<div id="form-wrapper">
<form id="form-rekam" >
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamNomor">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    
    <input id="id" type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <div id="wnomor"></div>
    <label>FORMAT NOMOR</label><input id="nomor"  type="text" name="nomor" value="<?php echo $this->data[2]; ?>" onkeyup="cekemptyfield(1,this.value)"></br>
    <div id="wbagian"></div>
    <label>BAGIAN</label><select id="bagian"  name="bagian" onchange="cekemptyfield(2,this.value)">
        <option value="" name="" selected>--PILIH BAGIAN--</option>
        <?php foreach($this->bagian as $key=>$value) { ?>
        <option value="<?php echo $value['kd_bagian'];?>" <?php if($value['kd_bagian']==$this->data[1]) echo 'selected'; ?>> 
            <?php echo strtoupper($value['bagian']);?></option>
        <?php } ?>
    </select></br>
    <label></label><input type="button" onclick="location.href='<?php echo URL;?>admin/rekamNomor'" value="BATAL"><input type="button" name="submit" value="SIMPAN" onclick="return selesai(1);">
</form></div>

</br>
<hr>
</br>
<div id="table-wrapper"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>BAGIAN</th><th>KODE NOMOR</th><th>AKSI</th></tr>
    <?php $no=1; foreach($this->nomor as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['bagian']; ?></td>
        <td><?php echo $value['kd_nomor']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusNomor/<?php echo $value['id_nomor'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai(2);"></a></td></tr>
    <?php $no++; }?>
</table></div>

<script type="text/javascript">
    
    function selesai(num)
    {
        if(num==1){
            var answer = confirm ("Anda yakin menyimpan perubahan?")
        }else if(num==2){
            var answer = confirm ("Anda yakin data ini akan dihapus?")
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
            ubah();
            return true;
        }
    }
    
    function ubah(){
        var id = document.getElementById('id').value;
        var bagian = document.getElementById('bagian').value;
        var nomor = document.getElementById('nomor').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/updateRekamNomor',
            data:'bagian='+bagian+
                '&nomor='+nomor+
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
