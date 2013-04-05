<div><form>
    <p><input id="search" type="text" size="30" name="search" placeholder="masukkan kata kunci pencarian" onkeyup="cari(this.value);">
        <!--<input  type="button" name="submit" value="CARI" onClick="cari(document.getElementById('search').value);">--></p>
        <!--<form id="ui_element" class="sb_wrapper" method="POST" action="<?php echo URL; ?>cari">
        <p><input class="sb_input" type="text" size="30" name="search" placeholder="masukkan kata kunci pencarian">
        <input class="sb_search" type="submit" name="submit" value=""></p>-->
    <!--<ul class="sb_dropdown" style="display:none">
        <li class="sb_filter">Pilih Kategori Pencarian</li>
        <li><input type="checkbox"/><label for="all">Semua</label></li>
        <li><input type="checkbox"/><label for="sm">Surat Masuk</label></li>
        <li><input type="checkbox"/><label for="sk">Surat Keluar</label></li>
        <li><input type="checkbox"/><label for="lamp">Lampiran</label></li>                            
    </ul>--></form>
</div>
<br>

<div id="result"></div>

<script type="text/javascript">

    
function cari(val){    
            $.post("<?php echo URL;?>cari/find", {queryString:""+val+""},
            function(data){
                $('#result').fadeIn(500);
                $('#result').html(data);
            });        
}


</script>
