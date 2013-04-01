<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set("UTC");

class Monitoring_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function monitoringKinerjaSuratMasuk() {
        $sql = "SELECT no_agenda, tgl_terima, start, end FROM suratmasuk";
        $data = $this->select($sql);
        foreach ($data as $value) {
            
        }
    }

    private function selisihJam($start, $end) {
        $cekhari = $this->cekSelisihHari($start, $end);
    }

    /*
     * menghasilkan nilai selisih hari pertama dan kedua
     */

    private function cekSelisihHari($start, $end) {
        $hari1 = explode(" ", $start);
        $tgl1 = $hari1[0];
        $tgl1 = explode("-", $tgl1);

        $hari2 = explode(" ", $end);
        $tgl2 = $hari2[0];
        $tgl2 = explode("-", $tgl2);
        if (($tgl2[0] - $tgl1[0]) == 0) {
            if (($tgl2[1] - $tgl1[1]) == 0) {
                if (($tgl2[2] - $tgl1[2]) == 0) {
                    return 0;
                } else {
                    return $tgl2[2] - $tgl1[2];
                }
            } else {
                //cari fungsi mendapatkan tgl maksimal pada bulan t3
                $temp = 30 - $tgl1[2];
                return $temp + $tgl2[2];
            }
        } else {
            $temp = 30 - $tgl1[2];
            return $temp + $tgl2[2];
        }

        return 0;
    }

    // Set timezone
    // Time format is UNIX timestamp or
    // PHP strtotime compatible strings

    function dateDiff($time1, $time2, $precision = 6) {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

        // Set up intervals and diffs arrays
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');
        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Set default diff to 0
            $diffs[$interval] = 0;
            // Create temp time from time1 and interval
            $ttime = strtotime("+1 " . $interval, $time1);
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                $time1 = $ttime;
                $diffs[$interval]++;
                // Create new temp time from time1 and interval
                $ttime = strtotime("+1 " . $interval, $time1);
            }
        }

        $count = 0;
        $times = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval 
            // if value is bigger than 0
            if ($value > 0) {
                // Add s if value is not 1
                if ($value != 1) {
                    $interval .= "s";
                }
                // Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

        // Return string with times
        return implode(", ", $times);
    }

}

/*
 * tes aja
 */

$tgl1 = "2009-10-01";  // 1 Oktober 2009
$tgl2 = "2009-10-10";  // 10 Oktober 2009
// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
// dari tanggal pertama

$pecah1 = explode("-", $tgl1);
$date1 = $pecah1[2];
$month1 = $pecah1[1];
$year1 = $pecah1[0];

// memecah tanggal untuk mendapatkan bagian tanggal, bulan dan tahun
// dari tanggal kedua

$pecah2 = explode("-", $tgl2);
$date2 = $pecah2[2];
$month2 = $pecah2[1];
$year2 = $pecah2[0];

// menghitung JDN dari masing-masing tanggal

$jd1 = GregorianToJD($month1, $date1, $year1);
$jd2 = GregorianToJD($month2, $date2, $year2);

// hitung selisih hari kedua tanggal

$selisih = $jd2 - $jd1;

echo "Selisih kedua tanggal adalah " . $selisih . " hari";
?>
