<h2>Pengaturan Kantor</h2>            
<hr>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">

<?php if ($this->cek > 0)  ?><input type="hidden" name="id" value="<?php echo $this->id; ?>">
        <!--<label>BAGIAN ANGGARAN</label><input class="required" type="text" name="ba" value="<?php if ($this->cek > 0) echo $this->ba; ?>"></br>
        <label>ESELON I</label><input class="required" type="text" name="es1" value="<?php if ($this->cek > 0) echo $this->es1; ?>"></br>-->
        <label>WILAYAH</label><!--<input class="required" type="text" name="es2" value="<?php if ($this->cek > 0) echo $this->es2; ?>">-->
            <select id="wilayah" name="es2" onchange="pilihkppn(this.value);">
                <option value="">-- PILIH KANWIL DJPBN --</option>
                <?php 
                    foreach($this->kanwil as $value){
                        if($this->cek>0){
                            if($this->es2==$value[kdkanwil]){
                                echo "<option value=$value[kdkanwil] selected>$value[nmkanwil]</option>";
                            }else{
                                echo "<option value=$value[kdkanwil]>$value[nmkanwil]</option>";
                            }
                        }else{
                             echo "<option value=$value[kdkanwil]>$value[nmkanwil]</option>";
                        }
                       
                    }
                ?>
            </select></br>
        <label>NAMA KANTOR</label><!--<input class="required" type="text" name="satker" value="<?php if ($this->cek > 0) echo $this->satker; ?>">-->
            <select name="satker" id="kppn" onchange="getnamakppn(this.value);">
                <option value="">-- PILIH KPPN --</option>
                <?php 
                    foreach($this->kppn as $value){
                        if($this->cek>0){
                            if($this->satker==$value[kdkppn]){
                                echo "<option value=$value[kdkppn] selected>Kantor Pelayanan Perbendaharaan Negara $value[nmkppn]</option>";
                            }else{
                                echo "<option value=$value[kdkppn]>Kantor Pelayanan Perbendaharaan Negara $value[nmkppn]</option>";
                            }
                        }else{
                             echo "<option value=$value[kdkppn]>Kantor Pelayanan Perbendaharaan Negara $value[nmkppn]</option>";
                        }
                       
                    }
                ?>
            </select><div id="namakppn"></div></br>
        <label>SINGKATAN</label><input class="required" type="text" name="singkatan" value="<?php if ($this->cek > 0) echo $this->singkatan; ?>"></br>
        <label>ALAMAT</label><input class="required" type="text" name="alamat" value="<?php if ($this->cek > 0) echo $this->alamat; ?>"></br>
        <label>TELEPON</label><input class="required" type="text" name="telepon" value="<?php if ($this->cek > 0) echo $this->telepon; ?>"></br>
        <label>FAKSIMILE</label><input class="required" type="text" name="faksimile" value="<?php if ($this->cek > 0) echo $this->faksimile; ?>"></br>
        <label>EMAIL</label><input class="required email" type="text" name="email" value="<?php if ($this->cek > 0) echo $this->email; ?>"></br>
        <label>WEBSITE</label><input class="required url" type="text" name="website" value="<?php if ($this->cek > 0) echo $this->website; ?>"></br>
        <label>SMS GATEWAY</label><input class="required" type="text" name="sms" value="<?php if ($this->cek > 0) echo $this->sms; ?>"></br>
        <label>LOGO</label><input type="file" name="logo" value="<?php if ($this->cek > 0) echo $this->logo; ?>"></br>
        <label></label><input type="button" class="btn cancel" onclick="location.href='<?php echo URL;?>admin/rekamKantor'" value="BATAL"><input class="btn save" type="submit" <?php if ($this->cek > 0) { echo "name=update_submit"; }else{ echo "name=input_submit";} ?> value="SIMPAN">
    </form>
</div>

<script type="text/javascript">
   
   function pilihkppn(kanwil){
       $.post("<?php echo URL;?>helper/pilihkppn", {queryString:""+kanwil+""},
            function(data){                
                $('#kppn').html(data);
            });
   }
    
</script>