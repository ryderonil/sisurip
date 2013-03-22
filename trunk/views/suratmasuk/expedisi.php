<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('/libs/fpdf/fpdf.php');

// header dan footer
class PDF extends FPDF {

    function Header() {
        // Logo
        $this->Image('public/images/Logo_Depkeu.jpg', 1.2, 1.2, 2, 2);
        // Times bold 13
        $this->SetFont('Times', 'B', 9);
        // Move to the right
        $this->Cell(0.5,0.4,'','LT',0);
        // Title 1
        $this->Cell(18.3, 0.4, 'KEMENTERIAN KEUANGAN REPUBLIK INDONESIA', 'TR', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', 'B', 8);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 2
        $this->Cell(18.3, 0.4, 'DIREKTORAT JENDERAL PERBENDAHARAAN', 'R', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', 'B', 7);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 3
        // Query  kanwil
        @$qKanwil = mysql_query("SELECT nmkanwil FROM t_kanwil WHERE aktif='1'") ;
        @$rKanwil = mysql_fetch_object($qKanwil);
        @$nmKanwil = $rKanwil->nmkanwil;
        @$this->Cell(18.3, 0.4, 'KANTOR WILAYAH PROVINSI BENGKULU' . $nmKanwil, 'R', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', '', 7);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 4
        // Query KPPN
        @$qKppn = mysql_query("SELECT nmkppn FROM t_kppn WHERE kddefa='1'") ;
        @$rKppn = mysql_fetch_array($qKppn);
        @$nmKppn = $rKppn['nmkppn'];
        @$this->Cell(18.3, 0.3, 'KANTOR PELAYANAN PERBENDAHARAAN NEGARA BENGKULU' . $nmKppn, 'R', 1, 'C');
        // Times  8
        @$this->SetFont('Times', '', 5);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 5
        @$qryKppn = mysql_query("SELECT almkppn,kotakppn,telkppn,email,kodepos,faxkppn,website,smsgateway FROM t_kppn WHERE kddefa='1'") ;
        @$rsltKppn = mysql_fetch_array($qryKppn);
        @$almKppn = $rsltKppn['almkppn'] . " " . $rsltKppn['kotakppn'] . " " . $rsltKppn['kodepos'] . " Telepon: " . $rsltKppn['telkppn'] . " Faksimile: " . $rsltKppn['faxkppn'];
        @$this->Cell(18.3, 0.3, $almKppn, 'R', 1, 'C');
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        // Title 6
        @$queryKppn = mysql_query("SELECT email,website,smsgateway FROM t_kppn WHERE kddefa='1'") ;
        @$resultKppn = mysql_fetch_array($queryKppn);
        @$webKppn = "Website: " . $resultKppn['website'] . " Email: " . $resultKppn['email'] . " SMS Gateway: " . $resultKppn['smsgateway'];
        $this->Cell(18.3, 0.3, $webKppn, 'R', 1, 'C');
        // Draw line
        //$this->Line(1.0,3.95,20.0,3.95);
        //$this->Line(1.0,4.0,20.0,4.0);        
        // Line break
        $this->Cell(18.8,0.3,'','RBL',1,'L');
    }

    function Footer() {
        $this->SetTextColor(015, 015, 015);
        //$this->Cell('test');
        $this->SetFont('', 'U');
        $this->SetY(-2, 5);
    }

}

$pdf = new PDF('P', 'cm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(18.8, 0.4, '', 0, 1, 'C');
$pdf->Cell(18.8, 0.4, 'DAFTAR EKSPEDISI SURAT MASUK', 0, 1, 'C');
$date = Tanggal::tgl_indo(date('Y-m-d'));
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18.8, 0.4, 'Bengkulu, '.$date, 0, 1, 'C');
$pdf->Cell(18.8, 0.4, '', 0, 1, 'C');
$pdf->Cell(18.8, 0.4, '', 0, 1, 'C');
$pdf->Cell(18.8, 0.4, '', 0, 1, 'C');

$pdf->Cell(2, 0.5, 'NO URUT', 'RLBT', 0, 'C');
$pdf->Cell(5, 0.5, 'NO SURAT', 'RLBT', 0, 'C');
$pdf->Cell(7, 0.5, 'ASAL SURAT', 'RLBT', 0, 'C');
$pdf->Cell(4.8, 0.5, 'PARAF', 'RLBT', 1, 'C');

$pdf->Output();
?>
