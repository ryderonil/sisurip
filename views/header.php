<!DOCTYPE html>
<html>
    <head>
        <title>Sistem Informasi Penatausahaan Surat dan Arsip</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="<?php echo URL; ?>public/css/default.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo URL; ?>public/css/flick/jquery-ui-1.10.1.custom.css" rel="stylesheet">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/jquery.autocomplete.css"  />-->

        <script src="<?php echo URL; ?>public/js/jquery-1.7.1.min.js"></script>

        <script src="<?php echo URL; ?>public/js/jquery-ui-1.10.1.custom.js"></script>

        <script src="<?php echo URL; ?>public/js/jquery.validate.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo URL;?>public/css/jquery.cleditor.css" />        
        <script type="text/javascript" src="<?php echo URL;?>public/js/jquery.cleditor.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $("#input").cleditor();
        });
        </script>
        <!--<script src="<?php echo URL; ?>public/js/jquery.js"></script>
        <script src="<?php echo URL; ?>public/js/jquery.autocomplete.js"></script>-->

<!--<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui-1.8.2.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>public/css/smoothness/jquery-ui-1.8.2.custom.css" /> -->

        <link rel="icon" type="image/png" href="<?php echo URL; ?>public/images/favicon.png" />
        <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                echo '<script src=' . URL . 'views/' . $js . '.js ></script>';
            }
        }
        ?>

    </head>
    <body>
        <div id="wrapper">
            <div id="header">
<?php
$role = Session::get('role');
$bagian = Session::get('bagian');
$nama = Session::get('nama');
$user = Session::get('user');
$notif = Notifikasi::getJumlahNotifikasi($user);
$roleuser = Helper_Model::getRoleUser($user);
//var_dump($roleuser);
//echo $role."-".$bagian."-".$user."-".$nama;
?>
                <!-- menu atas -->
                <div id="menu">
                    <div id="depkeu-logo"><img border="1" src="<?php echo URL; ?>public/images/depkeu-kecil2.jpg"></div>
                    <!--<div id="depkeu-logo"></div>-->
                    <div id="brand"> <?php echo $this->kantor; ?></div>
                    <!--<div id="pull-right"><img id="user-icon" src="<?php echo URL; ?>public/images/User-Executive.png"> <b><?php echo Session::get('nama'); ?></b>-->
                    <?php // if ($notif > 0) { ?><div id="notif" onclick="location.href='<?php echo URL; ?>monitoring/notif/<?php echo $user; ?>'" title="lihat notifikasi"><font color="white"><?php echo $notif > 0 ? $notif : ''; ?></font></div><?php // } ?>
                    <div id="user" onclick="location.href='<?php echo URL; ?>admin/userHome/<?php echo $user; ?>'" title="beranda pengguna"> <b><?php echo $nama; ?></b></div>

                    <div>
                        <ul id="trans-nav">
                            <?php
                            //echo Session::get('user');
                            if (Session::get('loggedin') == true):
                                ?>
                                <li onclick="menu('suratmasuk')"><a >Surat Masuk</a></li> <!--href="<?php echo URL; ?>suratmasuk"-->
                                <li onclick="menu('suratkeluar')"><a >Surat Keluar</a></li> <!--href=<?php echo URL; ?>suratkeluar -->
    <?php if (Auth::isRole(Session::get('role'), 1) || Auth::isRole(Session::get('role'), 2)) { ?>
                                    <li><a href="">Monitoring</a>
                                        <ul>
                                            <li onclick="menu('kinerja')"><a >Kinerja</a></li> <!--href="<?php echo URL; ?>monitoring/kinerja"-->
                                            <li onclick="menu('laporan')"><a >Laporan</a></li> <!--href="<?php echo URL; ?>monitoring/ikhtisar"-->
                                        </ul>
                                    </li>
                                <?php } ?>
    <?php if (Auth::isRole($role, 5) OR Auth::isRole($role, 3)) { ?>
                                    <li><a >Pengaturan</a>
                                        <ul>
                                            <?php if (Auth::isRole($role, 5)) { ?><li onclick="menu('kantor')"><a >Kantor</a></li> <!--href="<?php echo URL; ?>admin/rekamKantor"--><?php } ?> 
                                            <li onclick="menu('alamat')"><a >Alamat Surat</a></li> <!--href="<?php echo URL; ?>admin/rekamAlamat"-->
        <?php if (Auth::isRole($role, 5)) { ?><li onclick="menu('lokasi')"><a >Lokasi Arsip</a></li> <!--href="<?php echo URL; ?>admin/rekamLokasi"-->
                                                <li onclick="menu('klasarsip')"><a >Klasifikasi Arsip</a></li> <!--href="<?php echo URL; ?>admin/rekamKlasifikasiArsip"-->
                                                <li onclick="menu('tipenaskah')"><a >Lampiran</a></li> <!--href="<?php echo URL; ?>admin/rekamJenisLampiran"-->
                                                <li onclick="menu('nomor')"><a >Penomoran</a></li> <!--href="<?php echo URL; ?>admin/rekamNomor"-->
                                                <li onclick="menu('user')"><a  >Pengguna</a></li> <!--href="<?php echo URL; ?>admin/rekamUser"-->
                                                <li onclick="menu('calendar')"><a >Hari Libur</a></li> <!--href="<?php 
                                                $thisday = mktime(0 ,0 ,0, date('m'), date('d'), date('Y'));
                                                echo URL; ?>admin/calendar/<?php echo $thisday;?>"-->
                                                <li onclick="menu('backup')"><a  >Backup Restore</a></li> <!--href="<?php echo URL; ?>admin/backuprestore"-->
                                                    <?php } ?>
                                        </ul>
                                    </li> <?php } ?>
                                <!--<li><a href="<?php echo URL; ?>bantuan">Bantuan</a></li>-->
                                <li onclick="menu('cari')"><a >Pencarian</a></li> <!--href="<?php echo URL; ?>cari"-->
                                <li onclick="menu('logout')"><a >Logout</a></li> <!--href="<?php echo URL; ?>login/logout"-->
<?php endif; ?>
                        </ul>
                    </div>

                </div>
                <div id="navbar">
                    <!-- pencarian --> 

                    <div id="sisurip">
<?php if (Session::get('loggedin') == true){ ?><h1>SiSuRIP</h1></div>
                    <div id="pull-right">
                            <select id="role" name="role" onchange="location.href='<?php echo URL;?>login/changeRole/'+this.value;">
<!--                            <option value="">--PILIH ROLE--</option>-->
                            <?php //cek klo sesuai selected
                            foreach ($roleuser as $valrole){
                                $rolebag = $valrole[0]."-".$valrole[1];
                                $rolbag = $role."-".$bagian;
                                if($rolebag==$rolbag){
                                    echo "<option value=$rolebag selected>$valrole[2]</option>";
                                }else{
                                    echo "<option value=$rolebag>$valrole[2]</option>";
                                }
                                
                            }
                            ?>
                            </select>                            
                       </div>
                    <div id="pull-right"><?php echo Helper_Model::getRoleName($role) . '/' . Helper_Model::getBagianName($bagian); ?><?php } ?></div>                    

                </div>



            </div>

            <div id="content">
                <div id="cwrapper">
                    <div id="test"></div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#notif').fadeOut(0);
                            setInterval(function(){
                                //ntar pake ajax
                                $.ajax({
                                   type:"post",
                                   url:"<?php echo URL; ?>monitoring/getJmlNotifikasi/<?php echo $user; ?>/<?php echo $notif; ?>",
                                   data:'',
                                   dataType:'json',
                                   success:function(data){
                                       if(data.cek>0){
//                                           alert(data.cek+' '+data.notifikasi);
                                           $('#notif').fadeIn(0);
                                           $('#notif').html(data.notifikasi);
                                           //bunyikan suara
                                           $('<audio id="chatAudio" src="public/sound/sounds-847-office-2.mp3" type="audio/mpeg"></audio>').appendTo('body');
                                           $('#chatAudio')[0].play(1);
                                           //tampilkan jendela notifikasi
                                       }else if(data.notifikasi>0){
//                                           alert(data.cek+' '+data.notifikasi);
                                           $('#notif').fadeIn(0);
                                           $('#notif').html(data.notifikasi);
                                       }else if(data.notifikasi==0){
//                                           alert(data.cek+' '+data.notifikasi);
                                           $('#notif').fadeOut(0);
                                       }
                                   }
                                });
                            },10*1000); // every 10 seconds
                        }) 
        
                        function changerole(role){

                            $.post("<?php echo URL;?>login/changeRole", {queryString:""+role+""});
                        }
                        
                        function backup(){
                            $.post("<?php echo URL; ?>admin/backup",{},
                                function(data){
                                    $("#cwrapper").fadeIn(0);
                                    $("#cwrapper").html(data);
                                });
                        }
                        
                        function user(){
                            $.post("<?php echo URL; ?>admin/rekamUser",{},
                                function(data){
                                    $("#cwrapper").fadeIn(0);
                                    $("#cwrapper").html(data);
                                });
                        }
                        
                        function menu(attr){
                            switch(attr){
                                case 'suratmasuk':
                                    window.open('<?php echo URL;?>suratmasuk','_self');
                                    break;
                                case 'suratkeluar':
                                    window.open('<?php echo URL;?>suratkeluar','_self');
                                    break;
                                case 'kinerja':
                                    window.open('<?php echo URL;?>monitoring/kinerja','_self');
                                    break;
                                case 'laporan':
                                    window.open('<?php echo URL;?>monitoring/ikhtisar','_self');
                                    break;
                                case 'cari':
                                    window.open('<?php echo URL;?>cari','_self');
                                    break;
                                case 'logout':
                                    window.open('<?php echo URL;?>login/logout','_self');
                                    break;
                                case 'kantor':
                                    window.open('<?php echo URL;?>admin/rekamKantor','_self');
                                    break;
                                case 'alamat':
                                    window.open('<?php echo URL;?>admin/rekamAlamat','_self');
                                    break;
                                case 'lokasi':
                                    window.open('<?php echo URL;?>admin/rekamLokasi','_self');
                                    break;
                                case 'klasarsip':
                                    window.open('<?php echo URL;?>admin/rekamKlasifikasiArsip','_self');
                                    break;
                                case 'tipenaskah':
                                    window.open('<?php echo URL;?>admin/rekamJenisLampiran','_self');
                                    break;
                                case 'nomor':
                                    window.open('<?php echo URL;?>admin/rekamNomor','_self');
                                    break;
                                case 'user':
                                    window.open('<?php echo URL;?>admin/rekamUser','_self');
                                    break;
                                case 'calendar':
                                    <?php $thisday = mktime(0 ,0 ,0, date('m'), date('d'), date('Y'));?>
                                    window.open('<?php echo URL;?>admin/calendar/<?php echo $thisday;?>','_self');
                                    break;
                                case 'backup':
                                    window.open('<?php echo URL;?>admin/backuprestore','_self');
                                    break;
                            }
                        }

                    </script>
