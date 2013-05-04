<h2>Rekam/ Ubah Data Hari Libur</h2>
        <hr>
        </br>
<table>
    <tr><td width="30%" valign="top"><div class="span6"><div id="libur"><form method="POST" action="<?php echo !$this->ket?URL.'admin/rekamLibur':URL.'admin/updateLibur';?>">
        <div id="warning"></div>
        </br>
        <label>Tanggal</label><input id="tgl" type="text" name="tgl" value="<?php echo @Tanggal::tgl_indo($this->tgl);?>" readonly></br>
    <label>Keterangan</label><input type="text" name="ket" value="<?php echo !$this->ket?'':$this->ket;?>"></br></br>
    <label></label><input type="submit" class="btn" name="submit" value="SIMPAN" >
    <?php
        if($this->ket!=false){
            ?>
            <input type="button" class="btn" name="hapus" value="HAPUS" onclick="hapusEvent(document.getElementById('tgl').value)">
        <?php
            }
    ?>
    </br>
    </br>
</form></div></div></td><td>
<!--<div class="span6"><div id="form-wrapper"><form method="POST" action="<?php echo !$this->ket?URL.'admin/rekamLibur':URL.'admin/updateLibur';?>">
        <div id="warning"></div>
        <h3>Rekam/ Ubah Data Hari Libur</h3>
        <hr>
        </br>
        <label>Tanggal</label></br><input id="tgl" type="text" name="tgl" value="<?php echo @Tanggal::tgl_indo($this->tgl);?>" readonly></br>
    <label>Keterangan</label></br><input type="text" name="ket" value="<?php echo !$this->ket?'':$this->ket;?>"></br></br>
    <input type="submit" class="btn" name="submit" value="SIMPAN" >
    <?php
        if($this->ket!=false){
            ?>
            <input type="button" class="btn" name="hapus" value="HAPUS" onclick="hapusEvent(document.getElementById('tgl').value)">
        <?php
            }
    ?>
    </br>
</form></div></div>-->

<?php
$cal = new Calendar($this->curDate);
//        $cal->addEvent('event 1');
//        $cal->addEvent('event 2', 10);
//$cal->addEvent('event 3', 10, 10);
//        $cal->addEvent('event 4', 10, 10, 10);

foreach ($this->event as $val){
    $event = $val['keterangan'];
    $tgl = str_replace("-", "",$val['tgl']);
    $date = substr($tgl, -2);
    $month = substr($tgl, 4,2);
    $year = substr($tgl, 2,2);
//    echo $year.'-'.$month.'-'.$date.'-'.$event;
    $cal->addEvent($event,$date,$month,$year);
}

echo "<div class=span7><div id=table-wrapper>";
$cal->makeCalendar();
//$cal->makeEvents();
echo "</div></div>";
?>

    </td></tr>
</table>
<script>
    
    $(document).ready(function(){
//        $('#form-wrapper').fadeOut(0);
        $('#warning').fadeOut(0);
    });
    
    function addLibur(tgl){
        $.post("<?php echo URL;?>admin/ceklibur", {queryString:""+tgl+""},
            function(data){
                $('#error').fadeOut(0);
                $('#form-wrapper').fadeIn(500);
                $('#tgl').html(data);
            });
    }
    
function hapusEvent(tgl){
    var answer = 'anda yakin menghapus data libur tanggal : '+tgl+'?'
    
    if(confirm(answer)){
        $.post("<?php echo URL;?>admin/hapusLibur",{queryString:""+tgl+""},
            function(data){
                $('#warning').fadeIn();
                $('#warning').html(data);
            });
    }else{
        return false;
    }
}

function addEvent(data1,data2){
    $.post("<?php echo URL;?>admin/rekamLibur",{queryString:""+data1+","+data2+""},
            function(data){
                $('#warning').fadeIn();
                $('#warning').html(data);
            });
}
    
$(function(){
    $(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});
});
</script>