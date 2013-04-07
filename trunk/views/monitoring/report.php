<div><input type="button" onclick="srmasuktahun();" value="SURAT MASUK">
    <input type="button" onclick="srkeluar();" value="SURAT KELUAR"></div>
</br>
<hr>
</br>
<div id="report"></div>

<script type="text/javascript">

function srmasuktahun(val){
    $.post("<?php echo URL;?>monitoring/kinerjaSMTahun", {queryString:""},
            function(data){
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
}

function srmasukbulan(val1,val2){
    $.post("<?php echo URL;?>monitoring/kinerjaSMBulan", {queryString:""+val1+""+val2+""},
            function(data){
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
}

function srmasuk(val){    
    $.post("<?php echo URL;?>monitoring/kinerjaSMHari", {tanggal:""+val+""},
            function(data){
//                document.write(val);
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
}

function srkeluar(){
    
}


</script>