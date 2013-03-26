<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Tanggal{
    
    public static function ubahFormatTanggal($tgl){
        if(substr($tgl, 4, 1)=='-'){
            return $tgl;
        }        
        $tgl = explode('/', $tgl);
        $temp = array(
            $tgl[2],
            $tgl[0],
            $tgl[1]
        );
        
        $tgl = implode('-',$temp);
        
        //list($month, $day, $year) = split('[/.-]',$tgl);
        //$tgl = $year.'-'.$month.'-'.$day;
        return $tgl;
    }
    
    public static function tgl_indo($tgl){
        $tgl=  explode('-', $tgl);
        $month = Tanggal::bulan_indo($tgl[1]);
        
        return $tgl[2].' '.$month.' '.$tgl[0];
    }
    
    public static function bulan_indo($bulan){
        $month ='';
        
        switch($bulan){
            case '01':
                $month = 'Januari';
                break;
            case '02':
                $month = 'Februari';
                break;
            case '03':
                $month = 'Maret';
                break;
            case '04':
                $month = 'April';
                break;
            case '05':
                $month = 'Mei';
                break;
            case '06':
                $month = 'Juni';
                break;
            case '07':
                $month = 'Juli';
                break;
            case '08':
                $month = 'Agustus';
                break;
            case '09':
                $month = 'September';
                break;
            case '10':
                $month = 'Oktober';
                break;
            case '11':
                $month = 'November';
                break;
            case '12':
                $month = 'Desember';
                break;
        }
        
        return $month;
    }
    
    public static function getTglSekarang(){
        return date('Y-m-d');
    }
    
    public static function getTimeSekarang(){
        return ;
    }
}
?>
