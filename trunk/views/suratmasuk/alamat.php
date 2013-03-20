<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

mysql_connect('localhost','root','');
mysql_select_db('sisurip');

$q = $_GET['q'];
if(!$q) return;

$sql = mysql_query("SELECT kode_satker, nama_satker FROM alamat WHERE nama_satker LIKE '%$q%'");

while($r=  mysql_fetch_array($sql)){
    $satker = $r['kode_satker'].' '.$r['nama_satker'];
    echo "$satker \n";
}
?>
