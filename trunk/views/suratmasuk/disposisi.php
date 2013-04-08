<div id="form-wrapper"><form method="POST" action="<?php echo URL ?>suratmasuk/rekamdisposisi">
        <h1 align="center">Catat Disposisi</h1>
        <h2>Informasi Surat :</h2></br>
        <?php //foreach($this->data as $value) { ?>
        <input type="hidden" name="id_surat" value="<?php echo $this->data['id_suratmasuk']; ?>">
        <table class="CSSTableGenerator">
            <tr><td colspan="9"></td></tr>
            <tr><td>No Surat </td><td> : </td><td><b><?php echo $this->data['no_surat']; ?></b> </td>
                <td>Status </td><td> : </td><td><b><?php echo $this->data['status']; ?></b> </td>
                <td>Diterima Tgl </td><td> : </td><td><b><?php echo $this->data['tgl_terima']; ?> </b></td></tr>   
            <tr><td>Tgl Surat </td><td> : </td><td><b><?php echo $this->data['tgl_surat']; ?></b> </td>
                <td>Sifat </td><td> : </td><td><b><?php echo $this->data['sifat']; ?></b> </td>
                <td>no Agenda </td><td> : </td><td><b><?php echo $this->data['no_agenda']; ?></b> </td></tr>
            <tr><td>Lampiran </td><td> : </td><td><b><?php echo $this->data['lampiran']; ?></b> </td>
                <td>Jenis </td><td> : </td><td><b><?php echo $this->data['jenis']; ?></b></td><td></td><td></td></tr>
            <tr><td>Dari </td><td> : </td><td colspan="7"><b><?php echo @$this->data['asal_surat']; ?></b></td></tr>
            <tr><td>Perihal </td><td> : </td><td colspan="7"><b><?php echo $this->data['perihal']; ?></b></td></tr>
        </table> 
        <?php //} ?>
        <hr>
        <h2>Sifat :</h2>
        <input type="radio" name="sifat" value="SS"<?php if($this->count > 0) if($this->disp[2]=='SS') echo ' checked' ?>> SANGAT SEGERA 
        <input type="radio" name="sifat" value="S"<?php if($this->count > 0) if($this->disp[2]=='S') echo 'checked' ?>> SEGERA
        <hr>
        <h2>Disposisi Kepada :</h2>  
        <?php
        if ($this->count > 0) {
            $si = 0;
            $length3 = count($this->disposisi);
            foreach ($this->seksi as $value) {
                if ($si < $length3) {
                    if ($this->disposisi[$si] == $value['kd_bagian']) {
                        echo '<input type=checkbox name=disposisi[] value=' . $value['kd_bagian'] . ' checked> Kepala ' . $value['bagian'] . '</br>';
                        $si++;
                    } else {
                        echo '<input type=checkbox name=disposisi[] value=' . $value['kd_bagian'] . ' > Kepala ' . $value['bagian'] . '</br>';
                    }
                } else {
                    echo '<input type=checkbox name=disposisi[] value=' . $value['kd_bagian'] . ' > Kepala ' . $value['bagian'] . '</br>';
                }
            }
        } else {
            foreach ($this->seksi as $value) {
                echo '<input type=checkbox name=disposisi[] value=' . $value['kd_bagian'] . ' > Kepala ' . $value['bagian'] . '</br>';
            }
        }
        ?>
        <hr>
        <h2>Petunjuk :</h2>
        <table>
            <tr><td>
<?php
$length = count($this->petunjuk);
$length = ceil($length / 2);
$row = 1;
if ($this->count > 0) {
    $pt = 0;
    $length2 = count($this->petunjuk2);
    foreach ($this->petunjuk as $value) {

        if ($pt < $length2) {
            if ($this->petunjuk2[$pt] == $value['id_petunjuk']) {
                echo "<input type=checkbox name=petunjuk[] value=$value[id_petunjuk] checked> $value[petunjuk]</br>";
                $pt++;
            } else {
                echo "<input type=checkbox name=petunjuk[] value=$value[id_petunjuk]> $value[petunjuk]</br>";
            }
        } else {
            echo "<input type=checkbox name=petunjuk[] value=$value[id_petunjuk] > $value[petunjuk]</br>";
        }


        if ($row == $length) {
            echo "</td><td>";
        }
        $row++;
    }
} else {
    foreach ($this->petunjuk as $value) {
        echo "<input type=checkbox name=petunjuk[] value=$value[id_petunjuk] > $value[petunjuk]</br>";
        if ($row == $length) {
            echo "</td><td>";
        }
        $row++;
    }
}
?>
                </td></tr>
        </table>    
        <hr>
        <h2>Catatan :</h2></br>
        <textarea id="input" name="catatan" rows="10" cols="60"><?php if($this->count > 0) echo $this->disp[5];?></textarea>
        <hr>
        <!--<table>
            <tr><td>Tgl Penyelesaian :</td><td><input type="text" name="" value=""></td>
                <td>Diajukan kembali tgl :</td><td><input type="text" name="" value=""></td></tr>
            <tr><td>Penerima :</td><td><input type="text" name="" value=""></td>
                <td>Penerima :</td><td><input type="text" name="" value=""></td></tr>
            <tr><td></td><td></td><td></td><td></td></tr>
            <tr><td>Tgl Penyelesaian :</td><td><input type="text" name="" value=""></td>
                <td>Tgl Penyelesaian :</td><td><input type="text" name="" value=""></td></tr>
            <tr><td>Penerima :</td><td><input type="text" name="" value=""></td>
                <td>Penerima :</td><td><input type="text" name="" value=""></td></tr>
        </table> -->   
        <input type="submit" name="submit" value="SIMPAN">
    </form>
</div>