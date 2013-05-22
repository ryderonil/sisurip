<!-- INFORMASI SURAT -->
<h2>Rekam Disposisi Kasubag/Kasi</h2>
<hr>
<div id="pesan"></div>
</br>
<?php
if(isset($this->data)){
        $form = new Form_Generator();
        $html = new Html();
        $html->heading('INFORMASI SURAT MASUK :', 3);
        $html->hr();
        $html->br();
        $html->div_open('id', 'form-wrapper');
        //var_dump($html->div_open('id', 'form-wrapper'));
        $form->form_open('suratkeluar');        
        $form->form_label('AGENDA SURAT MASUK');
        $form->form_input(array('value'=>$this->data[1]));
        $html->br();
        $form->form_label('NOMOR SURAT MASUK');
        $form->form_input(array('value'=>$this->data[2]));
        $html->br();
        $form->form_label('DARI');
        $form->form_input(array('value'=>$this->data[3]));
        $html->br();
        $form->form_label('PERIHAL');
        $form->form_textarea(array('name'=>'#'),$this->data[4]);
        $html->br();
        $form->form_close();
        $html->div_close();
        $html->br();
        $html->hr();
        $html->br();
    }
?>

<div id="form-wrapper"><form id="form-rekam" method="POST" action="#">
        <?php 
            if(isset($this->error)){
                echo "<div id=error>$this->error</div>";
            }elseif(isset($this->success)){
                echo "<div id=success>$this->success</div>";
            }
            
            if(isset($this->data[0])){
                
            
        ?>
        <input id="id_surat" type="hidden" name="id_surat" value="<?php echo $this->data[0];?>">
        <input id="id_disp" type="hidden" name="id_disp" value="<?php echo $this->datad->id_disposisi;?>">
        <input id="bagian" type="hidden" name="bagian" value="<?php echo $this->bagian;?>">
        <label>KEPADA :</label><select  id="peg" name="peg" class="required">
            <option value="">--PILIH PEGAWAI--</option>
            <?php 
                foreach ($this->peg as $val){
                    echo "<option value=$val[id_user]>$val[namaPegawai]</option>";
                }
            ?>
        </select></br>
        <label>PETUNJUK :</label><br><textarea id="input" class="required" name="catatan" rows="10" cols="50"></textarea></br>
        <label></label><input type="button" name ="submit" value="SIMPAN" onclick="rekam();">
            
        <?php }else{
            echo "<div id=warning>Surat belum didisposisi Kepala Kantor, Anda tidak dapat memberikan disposisi!</div>";
        } ?>
        
        
    </form></div>

<script type="text/javascript">

function rekam(){
        var id_surat = document.getElementById('id_surat').value;
        var id_disp = document.getElementById('id_disp').value;
        var bagian = document.getElementById('bagian').value;
        var peg = document.getElementById('peg').value;
        var catatan = document.getElementById('catatan').value;
//        var join = agenda+' '+tgl+' '+alamat+' '+nosurat+' '+hal+' '+sifat+' '+jenis+' '+status+' '+lampiran;
//        alert(join);
        $.ajax({
            type:'POST',
            url:'<?php echo URL; ?>suratmasuk/rekamCatatan',
            data:'id_surat='+id_surat+
                '&id_disp='+id_disp+
                '&bagian='+bagian+
                '&peg='+peg+
                '&catatan='+catatan,
            success:function(data){
                $('#pesan').fadeIn(500);
                $('#pesan').html(data);
            }
        });
    }
</script>