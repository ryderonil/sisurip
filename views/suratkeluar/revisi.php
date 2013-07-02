<div class="divleft"><h2>Catatan Revisi</h2></div>
<hr>
<?php if(end(explode('.', $this->data->getFile()))=='pdf'){
    echo "<div id=warning>File surat berekstensi pdf, tidak dapat direvisi!</div>";
}else{ ?>
<div id="pesan"></div>
</br>
<table><tr><td width="40%" valign="top" align="right">
<div id="table-wrapper"><table class="tableinfo">
        <tr><td width="30%"></td><td></td></tr>
    <?php 
    $id = 0;
//    foreach ($this->data as $val) { 
        $id = $this->data->getId();
        ?>    
        <tr><td>TANGGAL SURAT</td><td><?php echo Tanggal::tgl_indo($this->data->getTglSurat());?></td></tr>
    <tr><td>TUJUAN</td><td><?php echo $this->data->getAlamat();?></td></tr>
    <tr><td>PERIHAL</td><td><?php echo $this->data->getPerihal();?></td></tr>
    <tr><td>SIFAT</td><td><?php echo $this->data->getSifat();?></td></tr>
    <tr><td>JENIS</td><td><?php echo $this->data->getJenis();?></td></tr>
    <tr><td>TIPE SURAT</td><td><?php echo $this->data->getTipeSurat();?></td></tr>
    <?php // } ?>
</table></div>
</br>
<hr>
</br>
        </td><td width="60%" align="left">
<div id="form-wrapper">
    <form id="form-rekam"   >
        <p><b>REVISI KE : <?php echo $this->jmlrev+1;?></b></p>
<!--        <form method="POST" action="<?php echo URL; ?>suratkeluar/uploadrev" enctype="multipart/form-data">-->
        <?php
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="user" value="<?php echo $user;?>">       
        <div id="winput"></div>
        <label>CATATAN REVISI</label><br><textarea id="catatan" name="catatan" cols="60" rows="10" onkeyup="cekemptyfield(1,this.value)"></textarea></br>
        <div id="wfile"></div>
        <label>UPLOAD</label><br><input id="sfile"  type="file" name="upload" onchange="cekemptyfield(2,this.value)"></br>
        <label></label><input type="button" class="btn save" name="submit" value="SIMPAN" onclick="return cekinput()">
    </form>
</div></td></tr></table></br>
<div id="table-wrapper" style="overflow:scroll; max-height:400px;">
    <table class="CSSTableGenerator">
        <tr><td>REV</td><td>CATATAN</td><td>DOWNLOAD</td></tr>
        
        <?php
        $no=1;
            foreach ($this->datar as $val){
                $time = explode(' ', $val['time']);
                echo "<tr><td>$no</td><td>".Tanggal::tgl_indo($time[0])." ".$time[1]." [$val[user]]</br><p>$val[catatan]</p></td>
                    <td><a href=".URL."suratkeluar/downloadrev/".$val['id_revisi']."><input class='btn download' type=button value=Download></a></td></tr>";
                $no++;
                
            }
        ?>
    </table>
    
</div>
<?php }?>
<script type="text/javascript">

    $(document).ready(function(){
        $('#winput').fadeOut();
        $('#wfile').fadeOut();
         
    });
    
    function cekemptyfield(num, content){
        switch(num){
            case 1:
                if(content==''){
                    var winput = '<div id=warning>kolom catatan belum diisi!</div>';
                    $('#winput').fadeIn(500);
                    $('#winput').html(winput);
                }else{
                    $('#winput').fadeOut(200);
                }
                break;
            case 2:
                if(content==''){
                    var wfile = '<div id=warning>file revisi belum dipilih!</div>';
                    $('#wfile').fadeIn(500);
                    $('#wfile').html(wfile);
                }else{
                    var x = content.split(".");
                    var ext = x[x.length-1];
                    if(ext!='docx' && ext!='doc'){
                        var wfile = '<div id=warning>file revisi harus dalam format doc/docx!</div>';
                        $('#wfile').fadeIn(200);
                        $('#wfile').html(wfile);
                    }else{
                        $('#wfile').fadeOut(200);
                    }
                }
                break;
        }
    }
    
    function cekinput(){
        var txt = document.getElementById('catatan').value;
        var file = document.getElementById('sfile').value;
        var jml = 0;
        if(txt==""){
            jml++;
            var winput = '<div id=warning>kolom catatan belum diisi!</div>';
            $('#winput').fadeIn(500);
            $('#winput').html(winput);
            
        }
        
        if(file==""){
            jml++;
            var wfile = '<div id=warning>file revisi belum dipilih!</div>';
            $('#wfile').fadeIn(500);
            $('#wfile').html(wfile);
        }else{
            var content = file.split(".");
            var ext = content[content.length-1];
            if(ext!='doc' && ext!='docx'){
                jml++;
                var wfile = '<div id=warning>file revisi harus dalam format doc/docx!</div>';
                $('#wfile').fadeIn(500);
                $('#wfile').html(wfile);
            }
        }
        
        if(jml>0){
            return false;
        }else{
            uploaddata();
            return true;
        }
        
        
    }
    
    function uploaddata(){
        var formData = new FormData($('#form-rekam')[0]);
        
        $.ajax({
            url: '<?php echo URL; ?>suratkeluar/uploadrev',
            type: 'POST',
            data: formData,
            async: false,
            success: function (data) {
                $('#pesan').html(data)
                window.setTimeout(function(){
                        location.reload(500)
                    }
                    ,3000);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        return false;
    }

</script>