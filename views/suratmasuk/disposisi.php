<div id="pesan"></div>
<div id="form-wrapper"><form id="form-rekam">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
        ?>
        <h1 align="center">Catat Disposisi</h1>
        <h2>Informasi Surat :</h2></br>
        <?php //foreach($this->data as $value) { ?>
        <?php if($this->count>0){?>
        <input id="id_disp" type="hidden" name="id_disp" value="<?php echo $this->disp[0]; ?>">
        <?php } ?>
        <input id="id_surat" type="hidden" name="id_surat" value="<?php echo $this->data['id_suratmasuk']; ?>">
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
        <input id="sifat" type="radio" name="sifat" value="SS"<?php if($this->count > 0) if($this->disp[2]=='SS') echo ' checked' ?>> SANGAT SEGERA 
        <input id="sifat" type="radio" name="sifat" value="S"<?php if($this->count > 0) if($this->disp[2]=='S') echo 'checked' ?>> SEGERA
        <div id="wsifat"></div>
        <hr>
        <h2>Disposisi Kepada :</h2>  
        <?php
        if ($this->count > 0) {
            $si = 0;
            $length3 = count($this->disposisi);
            foreach ($this->seksi as $value) {
                if ($si < $length3) {
                    if ($this->disposisi[$si] == $value['kd_bagian']) {
                        echo '<input id=disposisi type=checkbox name=disposisi value=' . $value['kd_bagian'] . ' checked> Kepala ' . $value['bagian'] . '</br>';
                        $si++;
                    } else {
                        echo '<input id=disposisi type=checkbox name=disposisi value=' . $value['kd_bagian'] . ' > Kepala ' . $value['bagian'] . '</br>';
                    }
                } else {
                    echo '<input id=disposisi type=checkbox name=disposisi value=' . $value['kd_bagian'] . ' > Kepala ' . $value['bagian'] . '</br>';
                }
            }
        } else {
            foreach ($this->seksi as $value) {
                echo '<input id=disposisi type=checkbox name=disposisi value=' . $value['kd_bagian'] . ' > Kepala ' . $value['bagian'] . '</br>';
            }
        }
        ?>
        <div id="wdisposisi"></div>
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
                echo "<input id=petunjuk type=checkbox name=petunjuk value=$value[id_petunjuk] checked> $value[petunjuk]</br>";
                $pt++;
            } else {
                echo "<input id=petunjuk type=checkbox name=petunjuk value=$value[id_petunjuk]> $value[petunjuk]</br>";
            }
        } else {
            echo "<input id=petunjuk type=checkbox name=petunjuk value=$value[id_petunjuk] > $value[petunjuk]</br>";
        }


        if ($row == $length) {
            echo "</td><td>";
        }
        $row++;
    }
} else {
    foreach ($this->petunjuk as $value) {
        echo "<input id=petunjuk type=checkbox name=petunjuk value=$value[id_petunjuk] > $value[petunjuk]</br>";
        if ($row == $length) {
            echo "</td><td>";
        }
        $row++;
    }
}
?>
                </td></tr>
        </table>
        <div id="wpetunjuk"></div>
        <hr>
        <h2>Catatan :</h2></br>
        <textarea id="input" name="catatan" rows="10" cols="60"><?php if($this->count > 0) echo $this->disp[5];?></textarea>
        <div id="wcatatan"></div>
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
        <input type="button" name="submit" value="SIMPAN" onclick=" 
               <?php if($this->disp[0]!=null){ ?>
               cek(2);
               <?php }else{?>
               cek(1);
               <?php } ?>">
    </form>
</div>

<script type="text/javascript">

function cek(attr){
    var jml = 0;
    var jmldisp = $("input[name='disposisi']:checked").length;
    var jmlpetunjuk = $("input[name='petunjuk']:checked").length;
    var sifat = $('input[name=sifat]:checked', '#form-rekam').val();
    var catatan = document.getElementById('input').value;
    if(jmldisp==0){
        var wdisposisi = '<div id=warning><font color=red><b>Anda belum memilih disposisi</b></font></div>';
        $('#wdisposisi').html(wdisposisi);
        jml++;
    }
    
    if(jmlpetunjuk==0){
        var wpetunjuk = '<div id=warning><font color=red><b>Anda belum memilih petunjuk</b></font></div>';
        $('#wpetunjuk').html(wpetunjuk);
        jml++;
    }
    
    if(sifat==undefined){
        var wsifat = '<div id=warning><font color=red><b>Anda belum memilih sifat disposisi</b></font></div>';
        $('#wsifat').html(wsifat);
        jml++;
    }
    
    if(catatan==''){
        var wcatatan = '<div id=warning><font color=red><b>Catatan disposisi harus diisi!</b></font></div>';
        $('#wcatatan').html(wcatatan);
        jml++;
    }
    
    if(jml>0){
        return false;
    }else{
        if(attr==1){
            rekam();
        }else if(attr==2){
            ubah();  
        }
        return true;
    }
    
}
function rekam(){
        
        var disposisi = new Array();
            $("input[name='disposisi']:checked").each(function(i){
                disposisi[i] = $(this).val();
            });
        var petunjuk = new Array();
            $("input[name='petunjuk']:checked").each(function(i){
                petunjuk[i] = $(this).val();
            });
        
        var id_surat = document.getElementById('id_surat').value;
        var sifat = $('input[name=sifat]:checked', '#form-rekam').val();
        var catatan = document.getElementById('input').value;
        var join = id_surat+' '+sifat+' '+petunjuk+' '+catatan+' '+disposisi;
        $.ajax({
            type:'POST',
            url:'<?php echo URL; ?>suratmasuk/rekamdisposisi',
            data:'id_surat='+id_surat+
                '&sifat='+sifat+
                '&petunjuk='+petunjuk+
                '&catatan='+catatan+
                '&disposisi='+disposisi,
            success:function(data){
                $('#wdisposisi').fadeOut();
                $('#wsifat').fadeOut();
                $('#wpetunjuk').fadeOut();
                $('#wcatatan').fadeOut();
                $('#pesan').fadeIn(500);
                $('#pesan').html(data);
            }
        });
    }
    
    function ubah(){
        var id_disp = document.getElementById('id_disp').value;
        var disposisi = new Array();
            $("input[name='disposisi']:checked").each(function(i){
                disposisi[i] = $(this).val();
            });
        var petunjuk = new Array();
            $("input[name='petunjuk']:checked").each(function(i){
                petunjuk[i] = $(this).val();
            });
        
        var id_surat = document.getElementById('id_surat').value;
        var sifat = $('input[name=sifat]:checked', '#form-rekam').val();
        var catatan = document.getElementById('input').value;
        var join = id_surat+' '+sifat+' '+petunjuk+' '+catatan+' '+disposisi;
        $.ajax({
            type:'POST',
            url:'<?php echo URL; ?>suratmasuk/ubahdisposisi',
            data:'id_disposisi='+id_disp+
                '&id_surat='+id_surat+
                '&sifat='+sifat+
                '&petunjuk='+petunjuk+
                '&catatan='+catatan+
                '&disposisi='+disposisi,
            success:function(data){
                $('#wdisposisi').fadeOut();
                $('#wsifat').fadeOut();
                $('#wpetunjuk').fadeOut();
                $('#wcatatan').fadeOut();
                $('#pesan').fadeIn(500);
                $('#pesan').html(data);
            }
        });
    }
</script>