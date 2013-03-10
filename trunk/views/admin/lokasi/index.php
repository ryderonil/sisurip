<form method="POST" action="<?php echo URL;?>admin/inputRekamLokasi">
    <h2>Pengaturan Lokasi Penyimpanan Arsip</h2>            
        <hr>
    <label>BAGIAN</label><select name="bagian">
        <option value="0">--PILIH BAGIAN--</option>
        <?php 
            foreach($this->bagian as $value){
                echo '<option value='.$value['id_bagian'].'>'.strtoupper($value['bagian']).'</option>';
            }
        ?>
    </select></br>
    <label>FILLING/RAK</label><select name="rak">
        <option value="0">--PILIH FILLING/RAK--</option>
        <?php 
            foreach($this->rak as $value){
                echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            }
        ?>
    </select></br>
    <label>BARIS</label><select name="baris">
        <option value="0">--PILIH BARIS--</option>
        <?php 
            foreach($this->baris as $value){
                echo '<option value='.$value['id_lokasi'].'>'.$value['lokasi'].'</option>';
            }
        ?>
    </select></br>
    <label>LABEL</label><input type="text" name="nama"></br>
    <!--<label>KETERANGAN</label><input type="text" name="keterangan" width="40"></textarea></br>-->
    <label></label><input type="submit" name="simpan" value="SIMPAN"></br>
    <p>Jika filling tidak dipilih, baris tidak dipilih->rekam filling</p>
    <p>Jika filling dipilih, baris tidak dipilih->rekam baris</p>
    <p>Jika filling dipilih, baris dipilih->rekam box</p>
    <p>bagian harus dipilih</p>
</form>

<table border="0">
    <tr><th>NO</th><th>BAGIAN</th><th>RAK</th><th>BARIS</th><th>BOX</th><th>STATUS</th><th>AKSI</th></tr>
    <?php 
        foreach($this->lokasi as $data){            
            echo "<tr><td>$data[0]</td>
            <td>$data[1]</td>
            <td>$data[2]</td>
            <td>$data[3]</td>
            <td>$data[4]</td>
            <td>$data[5]</td>
            <td><a href=".URL."admin/ubahLokasi/".$data[6].">UBAH</a> | <a href=>STATUS</a></td></tr>";
        }
    ?>
</table>