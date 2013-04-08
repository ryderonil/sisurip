<div >
    <ul id="menu-tab" class="tab-menu">
        <li class="active" onclick="srmasuktahun();"><a href="#suratmasuk">SURAT MASUK</a></li>
        <li><a href="#suratkeluar">SURAT KELUAR</a></li>
    </ul>
    
    <div id="suratmasuk" class="content-tab">
        
        <div id="report"></div>
    </div>
    <div id="suratkeluar" class="content-tab"></div>
</div>


<!--<div><input type="button" onclick="srmasuktahun();" value="SURAT MASUK">
    <input type="button" onclick="srkeluar();" value="SURAT KELUAR"></div>
</br>
<hr>
</br>
<div id="report"></div>-->

<script src="<?php echo URL; ?>public/js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>		

<script type="text/javascript">

$(document).ready(function () {
    $('#menu-tab').tabify();
    $.post("<?php echo URL;?>monitoring/kinerjaSMTahun", {queryString:""},
            function(data){
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
			});
                        
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

function srkeluar(val){
    $.post("<?php echo URL;?>monitoring/kinerjaSMHari", {tanggal:""+val+""},
            function(data){
//                document.write(val);
                $('#report').fadeIn(500);
                $('#report').html(data);
            });
    
}


</script>