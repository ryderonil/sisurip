<div >
    <ul id="menu-tab" class="tab-menu">
        <li class="active" onclick="ikhtisar();"><a href="#arsip">IKHTISAR ARSIP</a></li>
        <li onclick="progressurat();"><a href="#surat">PENYELESAIAN SURAT</a></li>
        <li onclick="grafik();"><a href="#rekap">IKHTISAR SURAT</a></li>
<!--        <li onclick=""><a href="#rekap">REKAPITULASI SURAT</a></li>-->
    </ul>
    
    <div id="arsip" class="content-tab">
        
        <div id="ikhtisar"></div>
    </div>
    <div id="surat" class="content-tab">
        <div id="suratselesai"></div>
    </div>
    <div id="rekap" class="content-tab">
        <div id="rekapsurat"></div>
    </div>
</div>

<script src="<?php echo URL; ?>public/js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>		

<script type="text/javascript">

$(document).ready(function () {
    $('#menu-tab').tabify();
    ikhtisar();
    
});

function ikhtisar(){
    $.post("<?php echo URL;?>arsip/ikhtisar", {queryString:""},
            function(data){
                $('#ikhtisar').fadeIn(500);
                $('#ikhtisar').html(data);
            });
}

function getarsiplokasi(lokasi){
    $.post("<?php echo URL;?>arsip/ikhtisarLokasi", {queryString:""+lokasi+""},
            function(data){                
                $('#ikhtisar').fadeIn(500);
                $('#ikhtisar').html(data);
            });
}

function getarsipklas(val){
    $.post("<?php echo URL;?>arsip/ikhtisarKlas", {queryString:""+val+""},
            function(data){
                $('#ikhtisar').fadeIn(500);
                $('#ikhtisar').html(data);
            });
}

function progressurat(){
    $.post("<?php echo URL;?>monitoring/progresSurat", {queryString:""},
            function(data){
                $('#suratselesai').fadeIn(500);
                $('#suratselesai').html(data);
            });
}

function grafik(){
    $.post("<?php echo URL;?>monitoring/grafik", {queryString:""},
            function(data){
                $('#rekapsurat').fadeIn(500);
                $('#rekapsurat').html(data);
            });
}
                        
</script>