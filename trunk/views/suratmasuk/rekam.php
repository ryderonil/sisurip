<h2>Rekam Surat Masuk</h2>            
<hr>
<script type="text/javascript">
  
    $(document).ready(function(){
        $("input").blur(function(){
            $('#result').fadeOut()
        }); 
    });
    
    function lookup(alamat){
        if(alamat.length == 0){
            $('#result').fadeOut();
        }else{
            $.post("<?php echo URL;?>helper/alamat", {queryString:""+alamat+""},
            function(data){
                $('#result').fadeIn();
                $('#result').html(data);
            });
        }
    }
    
    
    //$(document).ready(function(){
			//$('#alamat').autocomplete({source:'<?php echo URL; ?>helper/alamat', minLength:1});
		//});
    
</script>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL; ?>suratmasuk/input">
        
        <label>AGENDA</label><input type="text" name="no_agenda" value="<?php echo $this->agenda; ?>" readonly></br>
        <!--<label>TANGGAL TERIMA</label><input type="text" name="tgl_terima"></br>-->
        <label>TANGGAL SURAT</label><input type="text" id="datepicker" name="tgl_surat" class="required" ></br>
        <label>NOMOR SURAT</label><input class="required" type="text" name="no_surat"></br>
        <label>ASAL</label><input class="required"  id="alamat" type="text" name="asal_surat" 
                                  value="<?php if(isset($this->alamat)) echo $this->alamat; ?>" onkeyup="lookup(this.value);">
        <a href="<?php echo URL;?>helper/pilihalamat/1"><input type="button" name="" value="+"></a></br>
        <div id="result"></div>
        
        <label>PERIHAL</label><input class="required" type="" name="perihal"></br>
        <label>STATUS</label><input type="text" name="status"></br>
        <label>SIFAT</label><select>
            <?php
            var_dump($this->sifat);
                foreach($this->sifat as $value){
                    if($value[kode_sifat]=='BS') {
                        echo "<option value=$value[kode_sifat] selected>$value[sifat_surat]</option>";
                    }else{
                        echo "<option value=$value[kode_sifat]>$value[sifat_surat]</option>";
                    }
                    
                }
            ?>
        </select></br>
        <label>JENIS</label><select>
            <?php 
                foreach($this->jenis as $value){
                    if($value[kode_klassurat]=='BS') {
                        echo "<option value=$value[kode_klassurat] selected>$value[klasifikasi]</option>";
                    }else{
                        echo "<option value=$value[kode_klassurat]>$value[klasifikasi]</option>";
                    }
                    
                }
            ?>
        </select></br>
        <label>LAMPIRAN</label><input type="text" name="lampiran"></br>    
        <label></label><input type="submit" name="submit" value="SIMPAN">
    </form></div>
