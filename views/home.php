<!--<div id="grafik" style="height: 250px;"></div>-->
<div><div  style="float:left;width:49%;height: 250px;">
        <div class="shortcut sm" onclick="menus('suratmasuk')">
            <img src="<?php echo URL; ?>public/images/sm.png"></img>
            <p><font color="white" style="font-family: 'segoe ui','tahoma';
                     font-size: 15px; margin-left: 5px;padding-top: 
                     10px;padding-left: 10px; background: url('../public/images/sm.png') no-repeat;">
                <b>Surat Masuk</b>
                </font></p>
            <?php if (!Auth::isRole(Session::get('role'), 5) AND !Auth::isRole(Session::get('role'), 4)) { ?>
            <div id="notifsk" style="float: right; margin-right: 10px;margin-top: 100px; color:white;">
                <font id="sm" color="white" style="font-size: 50px;font-weight: bold;">0</font>
            </div>
            <?php } ?>
        </div>
        <div class="shortcut sk" onclick="menus('suratkeluar')">
            <img src="<?php echo URL; ?>public/images/sk.png"></img>
            <p><font color="white" style="font-family: 'segoe ui','tahoma';font-size: 15px; margin-left: 5px;">
                <b>Surat Keluar</b>
                </font></p>
            <?php if (!Auth::isRole(Session::get('role'), 5) AND !Auth::isRole(Session::get('role'), 4)) { ?>
            <div id="notifsk" style="float: right; margin-right: 10px;margin-top: 100px;color: white;">
                <font id="sk" color="white" style="font-size: 50px;font-weight: bold;">0</font></div>
            <?php } ?>
        </div>   
    </div>
    <div  class="shortcut arsip" onclick="menus('arsip')">
        <img src="<?php echo URL; ?>public/images/arsip_home.png"></img>
        <p><font color="white" style="font-family: 'segoe ui','tahoma';font-size: 15px; margin-left: 5px;">
                <b>Arsip</b>
                </font></p></br>
        <p><font color="white" style="font-family: 'segoe ui','tahoma';font-size: 20px; margin-left: 5px;"><ul>
            <?php
            foreach ($this->arsip as $val){
                echo "<li>$val[0] [$val[1]]</li>";
            }
        ?></ul></font></p>
    </div>
<div id="grafik" style="height: 250px;"></div></div>

<script type="text/javascript">
$(document).ready(function(){
        var lebar = $('#cwrapper').width();
        $.post("<?php echo URL;?>monitoring/homeGrafikSurat", {lebar:""+lebar+""},
                function(data){
                    $('#grafik').html(data);
                });
        
//        $.post("<?php echo URL;?>home/metro", {q:""},
//                function(data){
//                    $('#metro').html(data);
//                });
        setInterval(function(){
            $.ajax({
                type:'post',
                url:'<?php echo URL; ?>monitoring/getJumlahNotifikasiHome/<?php echo $user; ?>/SM',
                data:'',
                dataType:'json',
                success:function(data){
                    $('#sm').html(data.notifikasi);
//                    alert('<?php echo $user ?>');
                }
            });
            
            $.ajax({
                type:'post',
                url:'<?php echo URL; ?>monitoring/getJumlahNotifikasiHome/<?php echo $user; ?>/SK',
                data:'',
                dataType:'json',
                success:function(data){
                    $('#sk').html(data.notifikasi);
//                    alert(data.notifikasi);
                }
            })
        },3*1000);
})

function menus(attr){
    switch(attr){
        case 'suratmasuk':
            window.open('<?php echo URL;?>suratmasuk','_self');
            break;
        case 'suratkeluar':
            window.open('<?php echo URL;?>suratkeluar','_self');
            break;
        case 'arsip':
            window.open('<?php echo URL;?>monitoring/ikhtisar#arsip-tab','_self');
            break;
    }
}
</script>