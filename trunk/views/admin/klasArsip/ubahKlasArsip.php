<div class="divleft"><h2>Ubah Klasifikasi Arsip</h2></div>
<hr>
<table><tr><td width="50%" valign="top">
<div id="pesan"></div>
<div id="form-wrapper">
<form id="form-rekam" >
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/updateRekamKlasArsip">-->
    <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error<?div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
    <input id="id" type="hidden" name="id" value="<?php echo $this->data[0];?>">
    <div id="wkode"></div>
    <label>KODE KLASIFIKASI</label><input id="kode"  type="text" name="kode" value="<?php echo $this->data[1];?>" onkeyup="cekemptyfield(1,this.value)"></br>
    <div id="wklas"></div>
    <label>KLASIFIKASI</label><input id="klas"  type="text" name="klasifikasi" value="<?php echo $this->data[2];?>" onkeyup="cekemptyfield(2,this.value)"></br>
    <label></label><input class="btn cancel" type="button" onclick="location.href='<?php echo URL;?>admin/rekamKlasifikasiArsip'" value="BATAL"><input class="btn save" type="button" name="submit" value="SIMPAN" onclick="return selesai(1,'<?php echo $this->data[2];?>');">
</form></div>

</br>
<hr>
</br>
</td><td width="50%">
<div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
    <tr><td>NO</td><td>KODE</td><td>KLASIFIKASI</td><td>AKSI</td></tr>
    <?php $no=1; foreach($this->klasArsip as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['kode']; ?></td>
        <td><?php echo $value['klasifikasi']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn edit" type="button" value="UBAH"></a> | 
            <a href="#"><input class="btn btn-danger" type="button" value="HAPUS" onclick="return selesai(2,'<?php echo $value['klasifikasi']?>');"></a></td></tr>
    <?php $no++; }?>
</table></div>
</td></tr></table>
<script type="text/javascript">
    
    function selesai(num,klas)
    {
        if(num==1){
            var answer = confirm ("Yakin menyimpan perubahan data klasifikasi : "+klas+"?");
        }else if(num==2){
            var answer = confirm ("Klasifikasi arsip : "+klas+" akan dihapus?");
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
                    var walamat = '<div id=warning>Kode klasifikasi harus diisi!</div>'
                    $('#wkode').fadeIn(500);
                    $('#wkode').html(walamat);
                }else{
                    $('#wkode').fadeOut(500);
                } 
                break;
            case 2:
                if(content==''){
                    var wtgl = '<div id=warning>Nama Klasifikasi harus diisi!</div>'
                    $('#wklas').fadeIn(500);
                    $('#wklas').html(wtgl);
                }else{
                    $('#wklas').fadeOut(500);
                } 
                break;
        }
    }
    
    function cek(){
        var kode = document.getElementById('kode').value;
        var klas = document.getElementById('klas').value;
        var jml = 0;
        if(kode==''){
            jml++;
            var wtgl = '<div id=warning>Kode klasifikasi harus diisi!</div>'
            $('#wkode').fadeIn(500);
            $('#wkode').html(wtgl);
        }
        
        if(klas==''){
            jml++;
            var walamat = '<div id=warning>Nama Klasifikasi harus diisi!</div>'
            $('#wklas').fadeIn(500);
            $('#wklas').html(walamat);
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
        var kode = document.getElementById('kode').value;
        var klas = document.getElementById('klas').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/updateRekamKlasArsip',
            data:'id='+id+
                '&kode='+kode+
                '&klasifikasi='+klas,
            success:function(data){
//                location.reload();
//                $('#form-wrapper').fadeOut(0);
                $('#pesan').fadeIn();
                $('#pesan').html(data);
                window.setTimeout(function(){
                    location.reload(500)
                }
                ,3000);
            }
        });
    }
    

</script>
