<div class="form-login">
    <h2>LOGIN</h2>
<hr>
</br>
<div ><form id="form-login">
    <label>Nama Pengguna</label><input id="iuser" class="require" type="text" name="username"  onkeyup="hidewarning(1,this.value);"></br>
    <div id="wuser"></div>
    <label>Password</label><input id="pass" class="require" type="password" name="password" onkeyup="hidewarning(2,this.value);"></br>
    <div id="wpass"></div>
    <label></label><input type="button" name="submit" value="LOGIN" onclick="return cek();"></br>
    <?php if(isset($this->error['invalid'])) {?>
    <div id="error"><?php echo $this->error['invalid'];?></div> <?php }?>
</form></div></div>

<script type="text/javascript">

    function hidewarning(id,nilai){
        $('#error').fadeOut(0);
        if(id==1 & nilai!=''){
            $('#wuser').fadeOut(0);
        }else if(id==2 & nilai!=''){
            $('#wpass').fadeOut(0);
        }else if(id==1 & nilai==''){
            $('#wuser').fadeIn(0);
            var wuser = '<div id=warnin align=center><font color=red><b style="text-align:right;">Kolom nama pengguna harus diisi!</b></font></div>';
            $('#wuser').html(wuser);
        }else if(id==2 & nilai==''){
            $('#wpass').fadeIn(0);
            var wpass = '<div id=warnin align=center><font color=red style=text-align:center;><b>Kolom password harus diisi!</b></font></div>';
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
            success:function(){
                location.href='<?php echo URL;?>home'
            }
        });
    }
    
    function cek(){
        var jml = 0;
        var iuser = document.getElementById('iuser').value;
        var pass = document.getElementById('pass').value;
        if(iuser==''){
            var wuser = '<div id=warnin align=center><font color=red><b style="text-align:right;">Kolom nama pengguna harus diisi!</b></font></div>';
            $('#wuser').html(wuser);
            jml++;
        }
        
        if(pass==''){
            var wpass = '<div id=warnin align=center><font color=red style=text-align:center;><b>Kolom password harus diisi!</b></font></div>';
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
