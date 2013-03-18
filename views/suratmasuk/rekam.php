<h2>Rekam Surat Masuk</h2>            
<hr>
<script type="text/javascript">
  
    
    $(document).ready(function(){
			$('#alamat').autocomplete({source:'<?php echo URL; ?>helper/alamat', minLength:1});
		});
    
</script>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL; ?>suratmasuk/input">
        
        <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $this->agenda; ?>" readonly></br>
        <!--<label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
        <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" class="required" ></br>
        <label>NOMOR SURAT</label><input class="required" type="text" name="no_surat"></br>
        <label>ASAL</label><input class="required"  id="alamat" type="text" name="asal_surat" 
                                  value="<?php if(isset($this->alamat)) echo $this->alamat; ?>">
        <a href="<?php echo URL;?>helper/pilihalamat/1"><input type="button" name="" value="+"></a></br>
        <div id="result"></div>
        
        <label>PERIHAL</label><input class="required" type="" name="perihal"></br>
        <label>STATUS</label><input type="" name="status"></br>
        <label>SIFAT</label><input type="" name="sifat"></br>
        <label>JENIS</label><input type="" name="jenis"></br>
        <label>LAMPIRAN</label><input type="" name="lampiran"></br>    
        <label></label><input type="submit" name="submit" value="SIMPAN">
    </form></div>
