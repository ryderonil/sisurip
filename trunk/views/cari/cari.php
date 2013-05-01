<div>
    <form id="form-search" name="frm">
    <input id="search" type="input" size="30" name="search" placeholder="masukkan kata kunci pencarian" onkeyup="keyup();">
    <a title="cari" class="tip"><input  type="button" value="CARI" onClick="return cari(document.getElementById('search').value);"></a>
        <!--<form id="ui_element" class="sb_wrapper" method="POST" action="<?php echo URL; ?>cari">
        <p><input class="sb_input" type="text" size="30" name="search" placeholder="masukkan kata kunci pencarian">
        <input class="sb_search" type="submit" name="submit" value=""></p>-->
    <ul class="sb_dropdown" style="">
        <li class="sb_filter">Pilih Kategori Pencarian</li>
        <li><input type="checkbox"/><label for="all">Semua</label></li>
        <li><input type="checkbox"/><label for="sm">Surat Masuk</label></li>
        <li><input type="checkbox"/><label for="sk">Surat Keluar</label></li>
        <li><input type="checkbox"/><label for="lamp">Lampiran</label></li>                            
    </ul>
    </form>
</div>
<br>
<div id="table-wrapper"><div id="result"></div></div>

<script type="text/javascript">

$(document).ready(function(){
    $('#error').fadeOut(0);
    document.search.focus();    
});

function keyup(){
    $('#error').fadeOut(0);
    $('#result').fadeOut(0);
    document.frm.search.focus(); 
}

function cari(val){
    if(val==''){
        var err = "<div id=error>Kata kunci belum dimasukkan</div>";
        $('#result').fadeOut(0);
        $('#result').fadeIn(500);
        $('#result').html(err);
        return false;
    }
            $.post("<?php echo URL;?>cari/find", {queryString:""+val+""},
            function(data){
                $('#error').fadeOut(0);
                $('#result').fadeIn(500);
                $('#result').html(data);
            });        
}

$(function(){
    $(".tip").tipTip({maxWidth: "auto", edgeOffset: 10});
});


</script>
