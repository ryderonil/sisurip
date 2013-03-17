<div id="form-wrapper"><form id="form-rekam" method="POST" action="<?php echo URL;?>suratmasuk/rekamDistribusi">
        <input type="hidden" name="id" value="<?php echo @$this->data[0]; ?>">
        <label>NOMOR SURAT</label><input type="text" value="<?php echo @$this->data[1]; ?>" readonly></br>
        <label>PERIHAL</label><input class="float-input" type="text" value="<?php echo @$this->data[2]; ?>" readonly></br>
        <label>ASAL SURAT</label><input type="text" value="<?php echo @$this->data[3]; ?>" readonly></br>
        <hr>        
        <label>BAGIAN</label></br>

            <?php
            foreach ($this->bagian as $value) {
                echo '<label></label><input type=checkbox name=bagian[] value=' . $value['kd_bagian'] . '> Kepala ' . $value['bagian'] . '</br>';
            }
            ?>

        
        <label></label><input type="submit" name="submit" value="SIMPAN">
    </form></div>