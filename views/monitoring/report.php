<div >
    <ul id="menu-tab" class="tab-menu">
        <li class="active" onclick="srmasuktahun();"><a href="#suratmasuk">SURAT MASUK</a></li>
        <li onclick="srkeluar();"><a href="#suratkeluar">SURAT KELUAR</a></li>
        <li onclick="kinerja();"><a href="#kinerja">KINERJA PEGAWAI</a></li>
    </ul>
    
    <div id="suratmasuk" class="content-tab">
        
        <div id="report"></div>
    </div>
    <div id="suratkeluar" class="content-tab">
        <div id="reportsr"></div>
    </div>
    <div id="kinerja" class="content-tab">
        <div id="reportknj"></div>
    </div>
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
    $.post("<?php echo URL;?>monitoring/kinerjaSKTahun", {tanggal:""+val+""},
            function(data){
//                document.write(val);
                $('#reportsr').fadeIn(500);
                $('#reportsr').html(data);
            });
    
}

function srkeluarbulan(val1,val2){
    $.post("<?php echo URL;?>monitoring/kinerjaSKBulan", {queryString:""+val1+""+val2+""},
            function(data){
                $('#reportsr').fadeIn(500);
                $('#reportsr').html(data);
            });
}

function srkeluarhari(val){    
    $.post("<?php echo URL;?>monitoring/kinerjaSKHari", {tanggal:""+val+""},
            function(data){
//                document.write(val);
                $('#reportsr').fadeIn(500);
                $('#reportsr').html(data);
            });
}

function kinerja(){
    $.post("<?php echo URL;?>monitoring/kinerjaPegawai", {tanggal:""},
            function(data){
//                document.write(val);
                $('#reportknj').fadeIn(500);
                $('#reportknj').html(data);
            });
}


</script>