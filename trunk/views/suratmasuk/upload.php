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
        <p id="f1_upload_process">Loading...<br/><img src="loader.gif" /><br/></p>
        <p id="f1_upload_form" align="center"><br/>
        <input type="hidden" name="id" value="<?php echo $this->id;?>">
        <input type="hidden" name="nomor" value="<?php echo $this->no_surat;?>">
        <input type="hidden" name="satker" value="<?php echo $this->satker;?>">
        <label>PILIH FILE</label><input type ="file" name="upload"><input type="submit" name="submit" value="UPLOAD">
        </p>
        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
    </form>
</div>

<script language="javascript" type="text/javascript">
<!--
function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
      }
      else {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Upload" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
}
//-->
</script> 