<div><input type="button" onclick="srmasuk();" value="SURAT MASUK">
    <input type="button" onclick="srkeluar();" value="SURAT KELUAR"></div>
</br>
<hr>
</br>
<div id="report"></div>

<script type="text/javascript">

function srmasuk(val){
    $.post("<?php echo URL;?>monitoring/kinerjaSuratMasuk", {queryString:""},
            function(data){
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
}

function srmasukbulan(val){
    $.post("<?php echo URL;?>monitoring/kinerjaSuratMasuk", {queryString:""+val+""},
            function(data){
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
}

function srmasukhari(val1,val2){
    $.post("<?php echo URL;?>monitoring/kinerjaSuratMasuk", {queryString:""+val1+","+val2+""},
            function(data){
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
}

function srkeluar(){
    
}


</script>