<h2>Pengaturan Kantor</h2>            
        <hr>
<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php if($this->cek>0): 
        echo URL.'admin/updateRekamKantor'; else: echo URL.'admin/inputRekamKantor'; endif; ?>">
      
    <?php if($this->cek>0)  ?><input type="hidden" name="id" value="<?php echo $this->id;  ?>">
    <label>BAGIAN ANGGARAN</label><input class="required" type="text" name="ba" value="<?php if($this->cek>0) echo $this->ba;?>"></br>
    <label>ESELON I</label><input class="required" type="text" name="es1" value="<?php if($this->cek>0) echo $this->es1;?>"></br>
    <label>ESELON II</label><input class="required" type="text" name="es2" value="<?php if($this->cek>0) echo $this->es2;?>"></br>
    <label>NAMA KANTOR</label><input class="required" type="text" name="satker" value="<?php if($this->cek>0) echo $this->satker;?>"></br>
    <label>SINGKATAN</label><input class="required" type="text" name="singkatan" value="<?php if($this->cek>0) echo $this->singkatan;?>"></br>
    <label>ALAMAT</label><input class="required" type="text" name="alamat" value="<?php if($this->cek>0) echo $this->alamat;?>"></br>
    <label>TELEPON</label><input class="required" type="text" name="telepon" value="<?php if($this->cek>0) echo $this->telepon;?>"></br>
    <label>EMAIL</label><input class="required" type="text" name="email" value="<?php if($this->cek>0) echo $this->email;?>"></br>
    <label>LOGO</label><input type="file" name="logo" value="<?php if($this->cek>0) echo $this->logo;?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>
</div>