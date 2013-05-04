<h2>Catatan Revisi</h2>
<hr>
</br>
<div id="table-wrapper"><table class="CSSTableGenerator">
        <tr><td></td><td></td></tr>
    <?php 
    $id = 0;
//    foreach ($this->data as $val) { 
        $id = $this->data->getId();
        ?>    
    <tr><td>TANGGAL SURAT</td><td><?php echo $this->data->getTglSurat();?></td></tr>
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
<div id="form-wrapper">
    <form id="form-rekam" name="form_rekam" method="POST" action="#" enctype="multipart/form-data" >
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
        <table>
            <tr><td valign="top"><label>CATATAN REVISI</label></td><td><textarea id="input" class="required" name="catatan" cols="60" rows="20"></textarea><div id="errinput"></div></td></tr>
            <tr><td><label>UPLOAD</label></td><td><input id="file" class="required" type="file" name="upload"><div id="errfile"></div></td></tr>
            <tr><td></td><td><input type="submit" name="submit" value="SIMPAN" ></td></tr>
        </table>
    </form>
</div>
<div id="table-wrapper" style="overflow:scroll; height:400px;">
    <table class="CSSTableGenerator">
        <tr><td>REV</td><td>CATATAN</td><td>DOWNLOAD</td></tr>
        
        <?php
        $no=1;
            foreach ($this->datar as $val){
                echo "<tr><td>$no</td><td>$val[time] [$val[user]]</br><p>$val[catatan]</p></td>
                    <td><a href=".URL."suratkeluar/downloadrev/".$val['id_revisi']."><input class=btn type=button value=Download></a></td></tr>";
                $no++;
                
            }
        ?>
    </table>
    
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#errinput').fadeOut();
        $('#errfile').fadeOut();
         
    });
    
    function cekInput(){
        var txt = document.form_rekam.catatan.value;
        var file = document.form_rekam.upload.value;
        var pesan = '';
        if(txt==""){
            pesan = 'kolom catatan belum diisi!';
            alert(pesan);
            return false;
            $('#errinput').fadeIn(500);
            $('#errinput').html(pesan);
            
        }
        
        if(file==""){
            pesan = 'file revisi belum dipilih!';
            alert(pesan);
            return false;
            $('#errfile').fadeIn(500);
            $('#errfile').html(pesan);
            
        }       
        
        
    }

</script>