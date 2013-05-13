<div>
    <form id="form-search" name="frm">
    <input id="search" type="input" size="30" name="search" placeholder="masukkan kata kunci pencarian" onkeyup="keyup();">
    <a title="cari" class="tip"><input  type="button" value="CARI" onclick="searchs();"></a>
<!--    <a title="cari" class="tip"><input  type="button" value="CARI" onClick="return cari(document.getElementById('search').value);"></a>-->
        
    <br>
    
    </form>
    <table class="cari-param">
        <tr width="50%">
            <td width="15%" valign="top">
                <select id="kat" name="kategori" class="tip" title="Kategori Pencarian" onchange="">
                    <option value="all" selected>Semua</option>
                    <option value="suratmasuk">Surat Masuk</option>
                    <option value="suratkeluar">Surat Keluar</option>
                    <option value="lampiran">Lampiran</option>
                    <option value="nomor">Nomor</option>
                    <option value="alamat">Alamat</option>
                </select></td>
                <td valign="top"><input type="text" id="datepicker" class="tip" title="Tanggal Awal" onchange=""></br>
                <input type="text" id="datepicker2" class="tip" title="Tanggal Akhir" onchange=""></td></tr>        
    </table>
</div>
<br>
<div id="table-wrapper"><div id="result"></div></div>

<script type="text/javascript">

$(document).ready(function(){
    $('#error').fadeOut(0);
//    document.search.focus();    
});

function keyup(){
    $('#error').fadeOut(0);
    $('#result').fadeOut(0);
    document.frm.search.focus(); 
}

function searchs(){
    var keyword = $('#search').val();
    var category = $('#kat').val();
    var before = $('#datepicker').val();
    var after = $('#datepicker2').val();
    
    if(keyword==''){
        var err = "<div id=error>Kata kunci belum dimasukkan</div>";
        $('#result').fadeOut(0);
        $('#result').fadeIn(500);
        $('#result').html(err);
        return false;
    }
    
        $.ajax({
            type:"POST",
            url:"<?php echo URL;?>cari/find",
            data: "keyword="+keyword+"&category="+category+
                "&before="+before+"&after="+after,
            success:function(data){
                $('#error').fadeOut(0);
                $('#result').fadeIn(500);
                $('#result').html(data);
            }
        });
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

function chooseCat(kat){
    var kategori = document.getElementById('search').value;
    if(kategori==''){
        kategori = 'in:'+kat;       
    }else{
        var sub = kategori.substr(0,2);
        if(sub=='in'){
            kategori = 'in:'+kat; 
        }else if(sub=='be'){
            kategori = 'in:'+kat+' '+kategori; 
        }else if(sub=='af'){
            kategori = 'in:'+kat+' '+kategori; 
        }else{
            var err = '<div id=error>filter tidak sesuai</div>';
            $('#result').fadeOut(0);
            $('#result').fadeIn(500);
            $('#result').html(err);
        }
    }
    
    $('#search').val(kategori);
}

function after(date){
    var kategori = document.getElementById('search').value;
    if(kategori==''){
        kategori = 'after:'+date;       
    }else{
        var sub = kategori.substr(0,2);
        if(sub=='af'){
            kategori = 'after:'+date; 
        }else if(sub=='in'){
            kategori = kategori+' after:'+date; 
        }else if(sub=='be'){
            kategori = kategori+' after:'+date;  
        }else{
            var err = '<div id=error>filter tidak sesuai</div>';
            $('#result').fadeOut(0);
            $('#result').fadeIn(500);
            $('#result').html(err);
        }
    }
    
    $('#search').val(kategori);
}

function before(date){
    var kategori = document.getElementById('search').value;
    if(kategori==''){
        kategori = 'before:'+date;       
    }else{
        var sub = kategori.substr(0,2);
        if(sub=='be'){
            kategori = 'before:'+date; 
        }else if(sub=='in'){
            kategori = kategori+' before:'+date; 
        }else if(sub=='af'){
            kategori = kategori+' before:'+date;  
        }else{
            var err = '<div id=error>filter tidak sesuai</div>';
            $('#result').fadeOut(0);
            $('#result').fadeIn(500);
            $('#result').html(err);
        }
    }
    
    $('#search').val(kategori);
}

function displaysm(id){
        w = window.open("<?php echo URL; ?>suratmasuk/view/"+id, "Display Surat Masuk","toolbar=0,menubar=0,location=0,status=0,width=800,height=500, scrollbar=0");        
    }
    
function displaysk(id){
        w = window.open("<?php echo URL; ?>suratkeluar/view/"+id, "Display Surat Keluar","toolbar=0,menubar=0,location=0,status=0,width=800,height=500 scrollbar=0");        
    }
    
function viewlampiran(id){
        w = window.open("<?php echo URL; ?>lampiran/view/"+id, "Display Lampiran","toolbar=0,menubar=0,location=0,status=0,width=800,height=500");        
    }


</script>
