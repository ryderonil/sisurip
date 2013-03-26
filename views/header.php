<?php 
    $role = Session::get('role');
    $bagian = Session::get('bagian');
?>
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
        <!--<script src="<?php echo URL; ?>public/js/jquery.js"></script>
        <script src="<?php echo URL; ?>public/js/jquery.autocomplete.js"></script>-->
        
       <!--<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-1.4.2.min.js"></script> 
	<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery-ui-1.8.2.custom.min.js"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/smoothness/jquery-ui-1.8.2.custom.css" /> -->
        
       <link rel="icon" type="image/png" href="<?php echo URL; ?>public/images/favicon.png" />
        <?php 
            if(isset($this->js)){
                foreach($this->js as $js){
                    echo '<script src='.URL.'views/'.$js.'.js ></script>';
                }
            }
        ?>
        
    </head>
    <body>
        <div id="wrapper">
        <div id="header">
            
                <!-- menu atas -->
                <div id="menu">
                    <div id="depkeu-logo"><img border="1" src="<?php echo URL; ?>public/images/depkeu-kecil.jpg"></div>
                    <div id="brand"> <?php echo $this->kantor;?></div>
                    <div id="pull-right"><img id="user-icon" src="<?php echo URL;?>public/images/User-Executive.png"> <b><?php echo Session::get('user'); ?></b></div>
                    <div>
                    <ul id="trans-nav">
                        <?php                        
                        //echo Session::get('user');
                        if(Session::get('loggedin')==true):?>
                        <li><a href=<?php echo URL; ?>suratmasuk>Surat Masuk</a></li>
                        <li><a href=<?php echo URL; ?>suratkeluar>Surat Keluar</a></li>
                        <?php if(Auth::isRole(Session::get('role'), 1) || Auth::isRole(Session::get('role'), 2) ) { ?>
                        <li><a href="">Monitoring</a>
                            <ul>
                                <li><a href="">Kinerja Pegawai</a></li>
                                <li><a href="">Laporan</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php if(Auth::isRole($role, 5) OR Auth::isRole($role, 3)) {?>
                        <li><a href="">Pengaturan</a>
                            <ul>
                                <?php if(Auth::isRole($role, 5)) { ?><li><a href="<?php echo URL;?>admin/rekamKantor">Kantor</a></li><?php } ?>
                                <li><a href="<?php echo URL;?>admin/rekamAlamat">Alamat Surat</a></li>
                                <?php if(Auth::isRole($role, 5)){ ?><li><a href="<?php echo URL;?>admin/rekamLokasi">Lokasi Arsip</a></li>
                                <li><a href="<?php echo URL;?>admin/rekamKlasifikasiArsip">Klasifikasi Arsip</a></li>
                                <li><a href="<?php echo URL;?>admin/rekamJenisLampiran">Lampiran</a></li>
                                <!--<li><a href="<?php echo URL;?>admin/rekamStatusSurat">Status Surat</a></li>-->
                                <li><a href="<?php echo URL;?>admin/rekamNomor">Penomoran</a></li>
                                <li><a href="<?php echo URL;?>admin/rekamUser">Pengguna</a></li>
                                <li><a href="<?php echo URL;?>admin/backup">Backup</a></li>
                                <li><a href="<?php echo URL;?>admin/restore">Restore</a></li><?php } ?>
                            </ul>
                        </li> <?php } ?>
                        <!--<li><a href="<?php echo URL; ?>bantuan">Bantuan</a></li>-->                        
                        <li><a href="<?php echo URL; ?>login/logout">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                    </div>
                    
                </div>
                <div id="navbar">
                <!-- pencarian --> 
                
                <div id="sisurip">
                    <?php if(Session::get('loggedin')==true):?><h1>SiSuRIP</h1><?php endif; ?></div>
                
                <div id="">  <?php if(Session::get('loggedin')==true):?>                  
                    <form method="POST" action="<?php echo URL;?>cari">
                        <p><input id="search" type="text" size="30" name="search" placeholder="masukkan kata kunci pencarian">
                        <input  type="submit" name="submit" value="CARI"></p>
                        <!--<form id="ui_element" class="sb_wrapper" method="POST" action="<?php echo URL;?>cari">
                        <p><input class="sb_input" type="text" size="30" name="search" placeholder="masukkan kata kunci pencarian">
                        <input class="sb_search" type="submit" name="submit" value=""></p>-->
                        <!--<ul class="sb_dropdown" style="display:none">
                            <li class="sb_filter">Pilih Kategori Pencarian</li>
                            <li><input type="checkbox"/><label for="all">Semua</label></li>
                            <li><input type="checkbox"/><label for="sm">Surat Masuk</label></li>
                            <li><input type="checkbox"/><label for="sk">Surat Keluar</label></li>
                            <li><input type="checkbox"/><label for="lamp">Lampiran</label></li>                            
                        </ul>-->
                    </form><?php endif; ?>
                </div>
                
                <!-- end of pencarian -->
                
                </div>
                     
            
            
        </div>
        
        <div id="content">
        <div id="cwrapper">
            <script type="text/javascript">
           $(function() {
				/**
				* the element
				*/
				var $ui 		= $('#ui_element');
				
				/**
				* on focus and on click display the dropdown, 
				* and change the arrow image
				*/
				$ui.find('.sb_input').bind('focus click',function(){
					$ui.find('.sb_down')
					   .addClass('sb_up')
					   .removeClass('sb_down')
					   .andSelf()
					   .find('.sb_dropdown')
					   .show();
				});
				
				/**
				* on mouse leave hide the dropdown, 
				* and change the arrow image
				*/
				$ui.bind('mouseleave',function(){
					$ui.find('.sb_up')
					   .addClass('sb_down')
					   .removeClass('sb_up')
					   .andSelf()
					   .find('.sb_dropdown')
					   .hide();
				});
				
				/**
				* selecting all checkboxes
				*/
				$ui.find('.sb_dropdown').find('label[for="all"]').prev().bind('click',function(){
					$(this).parent().siblings().find(':checkbox').attr('checked',this.checked).attr('disabled',this.checked);
				});
            }); 
        
    

            
        </script>
    