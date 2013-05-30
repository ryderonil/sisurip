<h2>Tambah Klasifikasi Arsip</h2>
 <hr>
 <div id="pesan"></div>
 <div id="btn-show"></br><input  type="button" name="submit" value="REKAM" onclick="displayform()"></div>
<div id="form-wrapper">
<form id="form-rekam" >
<!--    <form id="form-rekam" method="POST" action="<?php echo URL; ?>admin/inputRekamKlasArsip">-->
    <?php 
            if (isset($this->error)) {
        echo "<div id=error>$this->error</div>";
    } elseif (isset($this->success)) {
        echo "<div id=success>$this->success</div>";
    }
    ?>
    <div id="wkode"></div>   
    <label>KODE KLASIFIKASI</label><input id="kode"  type="text" name="kode" onkeyup="cekemptyfield(1,this.value)"></br>
    <div id="wklas"></div>
    <label>KLASIFIKASI</label><input id="klas"  type="text" name="klasifikasi" onkeyup="cekemptyfield(2,this.value)"></br>
    <label></label><input type="reset" value="RESET"><input type="button" name="submit" value="SIMPAN" onclick="cek()">
</form>
</div>
</br>
<hr>
</br>
<?php if($this->count>0) { $no=1;?>
<div id="table-wrapper" style="overflow:scroll; height:400px;"><table class="CSSTableGenerator">
    <tr><th>NO</th><th>KODE</th><th>KLASIFIKASI</th><th>AKSI</th></tr>
    <?php foreach($this->klasArsip as $key=>$value) {?>
    <tr><td><?php echo $no; ?></td>
        <td><?php echo $value['kode']; ?></td>
        <td><?php echo $value['klasifikasi']; ?></td>
        <td><a href="<?php echo URL;?>admin/ubahKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn" type="button" value="UBAH"></a> | 
            <a href="<?php echo URL;?>admin/hapusKlasifikasiArsip/<?php echo $value['id_klasarsip'];?>"><input class="btn" type="button" value="HAPUS" onclick="return selesai('<?php echo $value['klasifikasi'];?>');"></a></td></tr>
    <?php $no++; }?>
</table></div>
<?php } ?>

<script type="text/javascript">
    
    $(document).ready(function(){
        $('#form-wrapper').fadeOut(0);
    });
    
    function displayform(){
        $('#btn-show').fadeOut(500);
        $('#form-wrapper').fadeIn(500);
    }
    
    function selesai(klas)
    {
        var answer = confirm ("Klasifikasi arsip : "+klas+" akan dihapus?");
        if (answer){
            return true;
        }else{
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
            rekam();
            return true;
        }
    }
    
    function rekam(){
        var kode = document.getElementById('kode').value;
        var klas = document.getElementById('klas').value;
        $.ajax({
            type:'post',
            url:'<?php echo URL;?>admin/inputRekamKlasArsip',
            data:'kode='+kode+
                '&klasifikasi='+klas,
            dataType:'json',
            success:function(data){
                if(data.status=='success'){
                    $('#pesan').fadeIn();
                    $('#pesan').html(data.message);
                }
                window.setTimeout(function(){
                    location.reload(500)
                }
                ,3000);
            }
        });
    }
</script>