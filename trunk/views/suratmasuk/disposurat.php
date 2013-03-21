<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../../libs/fpdf/fpdf.php');

// header dan footer
class PDF extends FPDF {

    function Header() {
        // Logo
        $this->Image('../../public/images/depkeu-kecil.jpg', 1.3, 1.3, 2, 2);
        // Times bold 13
        $this->SetFont('Times', 'B', 9);
        // Move to the right
        $this->Cell(0.5,0.4,'','LT',0);
        // Title 1
        $this->Cell(12.5, 0.4, 'KEMENTERIAN KEUANGAN REPUBLIK INDONESIA', 'TR', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', 'B', 8);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 2
        $this->Cell(12.5, 0.4, 'DIREKTORAT JENDERAL PERBENDAHARAAN', 'R', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', 'B', 7);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 3
        // Query  kanwil
        @$qKanwil = mysql_query("SELECT nmkanwil FROM t_kanwil WHERE aktif='1'") ;
        @$rKanwil = mysql_fetch_object($qKanwil);
        @$nmKanwil = $rKanwil->nmkanwil;
        @$this->Cell(12.5, 0.4, 'KANTOR WILAYAH PROVINSI BENGKULU' . $nmKanwil, 'R', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', '', 7);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 4
        // Query KPPN
        @$qKppn = mysql_query("SELECT nmkppn FROM t_kppn WHERE kddefa='1'") ;
        @$rKppn = mysql_fetch_array($qKppn);
        @$nmKppn = $rKppn['nmkppn'];
        @$this->Cell(12.5, 0.3, 'KANTOR PELAYANAN PERBENDAHARAAN NEGARA BENGKULU' . $nmKppn, 'R', 1, 'C');
        // Times  8
        @$this->SetFont('Times', '', 5);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 5
        @$qryKppn = mysql_query("SELECT almkppn,kotakppn,telkppn,email,kodepos,faxkppn,website,smsgateway FROM t_kppn WHERE kddefa='1'") ;
        @$rsltKppn = mysql_fetch_array($qryKppn);
        @$almKppn = $rsltKppn['almkppn'] . " " . $rsltKppn['kotakppn'] . " " . $rsltKppn['kodepos'] . " Telepon: " . $rsltKppn['telkppn'] . " Faksimile: " . $rsltKppn['faxkppn'];
        @$this->Cell(12.5, 0.3, $almKppn, 'R', 1, 'C');
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 6
        @$queryKppn = mysql_query("SELECT email,website,smsgateway FROM t_kppn WHERE kddefa='1'") ;
        @$resultKppn = mysql_fetch_array($queryKppn);
        @$webKppn = "Website: " . $resultKppn['website'] . " Email: " . $resultKppn['email'] . " SMS Gateway: " . $resultKppn['smsgateway'];
        $this->Cell(12.5, 0.3, $webKppn, 'R', 1, 'C');
        // Draw line
        //$this->Line(1.0,3.95,20.0,3.95);
        //$this->Line(1.0,4.0,20.0,4.0);        
        // Line break
        $this->Cell(13,0.3,'','RL',1,'L');
    }

    function Footer() {
        $this->SetTextColor(015, 015, 015);
        $this->SetFont('', 'U');
        $this->SetY(-2, 5);
    }

}

$pdf = new PDF('P', 'cm', 'A5');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Cell(13,0,'','T',1);
$pdf->Cell(13, 0.4, 'LEMBAR DISPOSISI KPPN BENGKULU', 'RLB', 1, 'C');
$perh = 'PERHATIAN : Dilarang memisahkan sehelai suratpun yang tergabung dalam berkas ini';
$pdf->Cell(13, 0.4, $perh, 'BRL', 1, 'C');
$pdf->Cell(4.5,0.4,'','LR',0,'L');
$pdf->Cell(4.5,0.4,'',0,0,'L');
$pdf->Cell(4,0.4,'','LR',1,'L');
$pdf->Cell(1.5,0.4,'No Surat','L',0,'L');
$pdf->Cell(3,0.4,': ','R',0,'L');
$pdf->Cell(1.5,0.4,'Status',0,0,'L');
$pdf->Cell(3,0.4,': --','R',0,'L');
$pdf->Cell(1.5,0.4,'Diterima Tgl',0,0,'L');
$pdf->Cell(2.5,0.4,': --','R',1,'L');
$pdf->Cell(1.5,0.4,'Tgl Surat','L',0,'L');
$pdf->Cell(3,0.4,': --','R',0,'L');
$pdf->Cell(1.5,0.4,'Sifat',0,0,'L');
$pdf->Cell(3,0.4,': --','R',0,'L');
$pdf->Cell(1.5,0.4,'No. Agenda',0,0,'L');
$pdf->Cell(2.5,0.4,': --','R',1,'L');
$pdf->Cell(1.5,0.4,'Lampiran','BL',0,'L');
$pdf->Cell(3,0.4,': --','BR',0,'L');
$pdf->Cell(1.5,0.4,'Jenis','B',0,'L');
$pdf->Cell(3,0.4,': --','BR',0,'L');
$pdf->Cell(1.5,0.4,'','B',0,'L');
$pdf->Cell(2.5,0.4,'','RB',1,'L');
$pdf->Cell(1.5,0.4,'Dari','L',0,'L');
$pdf->Cell(11.5,0.4,': --','R',1,'L');
$pdf->Cell(1.5,0.4,'Perihal','L',0,'L');
$pdf->Cell(11.5,0.4,': --','R',1,'L');
$pdf->Cell(1.5,0.4,'','BL',0,'L');
$pdf->Cell(11.5,0.4,'','BR',1,'L');

$pdf->Image('../../public/images/check20-cek.png', 3.15, 7.1, 0.2, 0.2, 'PNG');
$pdf->Cell(6.5,0.4,'SANGAT SEGERA','BL',0,'C');
$pdf->Image('../../public/images/check20.png', 10, 7.1, 0.2, 0.2, 'PNG');
$pdf->Cell(6.5,0.4,'SEGERA','BLR',1,'C');
$pdf->Cell(13,0.4,'Diteruskan kepada ','RL',1,'L');
$pdf->Cell(13,0.4,'DISPOSISI KEPALA KANTOR KEPADA :','RL',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 8.3, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Kasubbag Umum','L',0,'L');
$pdf->Image('../../public/images/check20.png', 5.1, 8.3, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Kasi Bank/ Giro Pos',0,0,'L');
$pdf->Image('../../public/images/check20.png', 9.1, 8.3, 0.2, 0.2, 'PNG');
$pdf->Cell(5,0.4,'        Sekretaris Pribadi','R',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 8.7, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Kasi Pencairan Dana I','L',0,'L');
$pdf->Image('../../public/images/check20.png', 5.1, 8.7, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Kasi Verifikasi dan Akuntansi',0,0,'L');
$pdf->Image('../../public/images/check20.png', 9.1, 8.7, 0.2, 0.2, 'PNG');
$pdf->Cell(5,0.4,'        Lain lain','R',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 9.1, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Kasi Pencairan Dana II','L',0,'L');
$pdf->Cell(4,0.4,'',0,0,'L');
$pdf->Cell(5,0.4,'','R',1,'R');
$pdf->Cell(13,0.7,'PETUNJUK :','RL',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 10.2, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Setuju','L',0,'L');
$pdf->Image('../../public/images/check20.png', 4.1, 10.2, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Selesaikan',0,0,'L');
$pdf->Image('../../public/images/check20.png', 7.1, 10.2, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Jawab',0,0,'L');
$pdf->Image('../../public/images/check20.png', 10.1, 10.2, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Ingatkan','R',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 10.6, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Tolak','L',0,'L');
$pdf->Image('../../public/images/check20.png', 4.1, 10.6, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Sesuai Catatan',0,0,'L');
$pdf->Image('../../public/images/check20.png', 7.1, 10.6, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Perbaiki',0,0,'L');
$pdf->Image('../../public/images/check20.png', 10.1, 10.6, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Simpan','R',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 11, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Teliti & Pendapat','L',0,'L');
$pdf->Image('../../public/images/check20.png', 4.1, 11, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Untuk perhatian',0,0,'L');
$pdf->Image('../../public/images/check20.png', 7.1, 11, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Bicarakan dengan saya',0,0,'L');
$pdf->Image('../../public/images/check20.png', 10.1, 11, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Disiapkan','R',1,'L');
$pdf->Image('../../public/images/check20.png', 1.1, 11.4, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Untuk diketahui','L',0,'L');
$pdf->Image('../../public/images/check20.png', 4.1, 11.4, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Edarkan',0,0,'L');
$pdf->Image('../../public/images/check20.png', 7.1, 11.4, 0.2, 0.2, 'PNG');
$pdf->Cell(3,0.4,'        Bicarakan bersama',0,0,'L');
$pdf->Image('../../public/images/check20.png', 10.1, 11.4, 0.2, 0.2, 'PNG');
$pdf->Cell(4,0.4,'        Harap dihadiri/diwakili','R',1,'L');
$pdf->Cell(13,0.7,'CATATAN KEPALA KANTOR :','RL',1,'L');
$test = ";;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;\n
    dkjaljbjbjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjjj\n";
//$pdf->MultiCell(13, 0.1, $test, 1, 'J');
$pdf->Cell(13,0.4,$test,'RL',1,'L');
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0,'',0,1,'L');
$pdf->Cell(6.5,0.4,'Tgl Penyelesaian :','TL',0,'L');
$pdf->Cell(6.5,0.4,'Diajukan kembali tgl :','RTL',1,'L');
$pdf->Cell(6.5,0.4,'Penerima :','BL',0,'L');
$pdf->Cell(6.5,0.4,'Penerima :','RBL',1,'L');
$pdf->Cell(13,0.7,'DISPOSISI Kasubbag / Kasi :','RL',1,'L');
$pdf->Cell(13,0.4,'Kepada :','RL',1,'L');
$pdf->Cell(13,0.4,'Petunjuk :','RL',1,'L');
$pdf->Cell(13,0.4,$test,'RL',1,'L');
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0.4,'Tgl Penyelesaian :','TLR',1,'L');
$pdf->Cell(13,0.4,'Penerima :','TBLR',1,'L');
$pdf->Output();



?>
