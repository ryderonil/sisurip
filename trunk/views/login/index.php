<section class="container">
<div class="login"><h1>LOGIN SiSURIP</h1>
<form id="form-login">
        <div id="error-login"></div>
        <p><label>NAMA PENGGUNA</label><input id="iuser" type="text" size="20" name="username"  onkeyup="hidewarning(1,this.value);"></br>
        </p><div id="wuser"></div>
        <p><label>PASSWORD</label><input id="pass" type="password" size="20" name="password" onkeyup="hidewarning(2,this.value);"></br>
        </p><div id="wpass"></div>
    <label></label><input type="button" name="submit" value="LOGIN" onclick="return cek();"></br>
    <?php if(isset($this->error['invalid'])) {?>
    <div id="error"><?php echo $this->error['invalid'];?></div> <?php }?>
</form></div></section>

<script type="text/javascript">

$(document).ready(function(){
   $('#error-login').fadeOut(0); 
});

    function hidewarning(id,nilai){
        $('#error').fadeOut(0);
        if(id==1 & nilai!=''){
            $('#wuser').fadeOut(0);
        }else if(id==2 & nilai!=''){
            $('#wpass').fadeOut(0);
        }else if(id==1 & nilai==''){
            $('#wuser').fadeIn(0);
            var wuser = '<div id=warning-login align=center><font color=red><b style="text-align:right;">Kolom nama pengguna harus diisi!</b></font></div>';
            $('#wuser').html(wuser);
        }else if(id==2 & nilai==''){
            $('#wpass').fadeIn(0);
            var wpass = '<div id=warning-login align=center><font color=red style=text-align:center;><b>Kolom password harus diisi!</b></font></div>';
            $('#wpass').html(wpass);
        }
    }
    
    function auth(){
        var iuser = document.getElementById('iuser').value;
        var pass = document.getElementById('pass').value;
//        alert('iuser '+iuser+' pass '+pass);
        $.ajax({
            type:'POST',
            url:'<?php echo URL;?>login/auth',
            data:'username='+iuser+
                '&password='+pass,
            dataType:'json',
            success:function(response){
                if(response.status=='success'){
                    location.href='<?php echo URL;?>home';
                }else if(response.status=='error'){
                    $('#error-login').fadeIn(200);
                    $('#error-login').html(response.message);
                }
                
            }
            
        });
    }
    
    function cek(){
        var jml = 0;
        var iuser = document.getElementById('iuser').value;
        var pass = document.getElementById('pass').value;
        if(iuser==''){
            var wuser = '<div id=warning-login align=center><font color=red><b style="text-align:right;">Kolom nama pengguna harus diisi!</b></font></div>';
            $('#wuser').html(wuser);
            jml++;
        }
        
        if(pass==''){
            var wpass = '<div id=warning-login align=center><font color=red style=text-align:center;><b>Kolom password harus diisi!</b></font></div>';
            $('#wpass').html(wpass);
            jml++;
        }
        if(jml>0){
            return false;
        }else{
            auth();
            return true;
        }
    }

</script>
