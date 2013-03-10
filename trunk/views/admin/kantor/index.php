
<div id="form-wrapper"><form method="POST" action="<?php if($this->cek>0): 
        echo URL.'admin/updateRekamKantor'; else: echo URL.'admin/inputRekamKantor'; endif; ?>">
    <h2>Pengaturan Kantor</h2>            
        <hr>    
    <?php if($this->cek>0)  ?><input type="hidden" name="id" value="<?php echo $this->id;  ?>">
    <label>BAGIAN ANGGARAN</label><input type="text" name="ba" value="<?php if($this->cek>0) echo $this->ba;?>"></br>
    <label>ESELON I</label><input type="text" name="es1" value="<?php if($this->cek>0) echo $this->es1;?>"></br>
    <label>ESELON II</label><input type="text" name="es2" value="<?php if($this->cek>0) echo $this->es2;?>"></br>
    <label>NAMA KANTOR</label><input type="text" name="satker" value="<?php if($this->cek>0) echo $this->satker;?>"></br>
    <label>SINGKATAN</label><input type="text" name="singkatan" value="<?php if($this->cek>0) echo $this->singkatan;?>"></br>
    <label>ALAMAT</label><input type="text" name="alamat" value="<?php if($this->cek>0) echo $this->alamat;?>"></br>
    <label>TELEPON</label><input type="text" name="telepon" value="<?php if($this->cek>0) echo $this->telepon;?>"></br>
    <label>EMAIL</label><input type="text" name="email" value="<?php if($this->cek>0) echo $this->email;?>"></br>
    <label>LOGO</label><input type="file" name="logo" value="<?php if($this->cek>0) echo $this->logo;?>"></br>
    <label></label><input type="submit" name="submit" value="SIMPAN">
</form>
</div>