<h2>Upload File Surat</h2>
<hr>
</br>
<div id="form-wrapper"><table class="CSSTableGenerator">
    <tr><th></th><th></th></tr>
    <tr><td>Nomor Agenda</td><td><?php echo $this->no_agenda;?></td></tr>
    <tr><td>Nomor Surat</td><td><?php echo $this->no_surat;?></td></tr>
    <tr><td>Tanggal Surat</td><td><?php echo $this->tgl_surat;?></td></tr>
</table></div>
</br>
<hr>
</br>
<div id="form-wrapper">
    <form id="form-rekam" method="POST" action="#" enctype="multipart/form-data">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
        <input type="hidden" name="id" value="<?php echo $this->id;?>">
        <input type="hidden" name="nomor" value="<?php echo $this->no_surat;?>">
        <input type="hidden" name="satker" value="<?php echo $this->satker;?>">
        <label>PILIH FILE</label><input type ="file" name="upload"><input type="submit" name="submit" value="UPLOAD">
    
    </form>
</div>
