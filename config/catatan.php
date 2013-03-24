<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * SELECT a.id_lokasi, b.id_lokasi, b.parent, c.parent, a.lokasi, b.lokasi, c.lokasi FROM lokasi a JOIN lokasi b ON a.id_lokasi = b.parent JOIN lokasi c ON b.id_lokasi = c.parent
 * 
 * status surat masuk :
 * 11=baru ->notif KK
 * 12=disposisi ->notif kasi
 * 13=diterima kasi ->notif pelaksana
 * 14=diterima pelaksana
 * 15=arsip
 * 
 * status surat keluar
 * 21=konsep pelaksana
 * 22=konsep kasi
 * 23=konsep disetujui KK
 * 24=net pelaksana
 * 25=net kasi
 * 26=net KK
 * 27=arsip
 */
?>
