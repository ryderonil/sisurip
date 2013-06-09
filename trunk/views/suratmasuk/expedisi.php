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
        $this->SetFont('Times', 'B', 14);
        // Move to the right
        $this->Cell(0.5,0.6,'','',0);
        // Title 1
        $this->Cell(18.3, 0.6, 'KEMENTERIAN KEUANGAN REPUBLIK INDONESIA', '', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', 'B', 12);
        // Move to the right
        $this->Cell(0.5,0.6,'','',0);
        // Title 2
        $this->Cell(18.3, 0.6, 'DIREKTORAT JENDERAL PERBENDAHARAAN', '', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', 'B', 12);
        // Move to the right
        $this->Cell(0.5,0.6,'','',0);
        // Title 3
        // Query  kanwil
        @$qKanwil = mysql_query("SELECT nmkanwil FROM t_kanwil WHERE aktif='1'") ;
        @$rKanwil = mysql_fetch_object($qKanwil);
        @$nmKanwil = $rKanwil->nmkanwil;
        @$this->Cell(18.3, 0.6, 'KANTOR WILAYAH PROVINSI BENGKULU' . $nmKanwil, '', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', '', 11);
        // Move to the right
        $this->Cell(0.5,0.5,'','',0);
        // Title 4
        // Query KPPN
        @$qKppn = mysql_query("SELECT nmkppn FROM t_kppn WHERE kddefa='1'") ;
        @$rKppn = mysql_fetch_array($qKppn);
        @$nmKppn = $rKppn['nmkppn'];
        @$this->Cell(18.3, 0.5, 'KANTOR PELAYANAN PERBENDAHARAAN NEGARA BENGKULU' . $nmKppn, '', 1, 'C');
        // Times  8
        @$this->SetFont('Times', '', 8);
        // Move to the right
        $this->Cell(0.5,0.4,'','',0);
        // Title 5
        @$qryKppn = mysql_query("SELECT almkppn,kotakppn,telkppn,email,kodepos,faxkppn,website,smsgateway FROM t_kppn WHERE kddefa='1'") ;
        @$rsltKppn = mysql_fetch_array($qryKppn);
        @$almKppn = $rsltKppn['almkppn'] . " " . $rsltKppn['kotakppn'] . " " . $rsltKppn['kodepos'] . " Telepon: " . $rsltKppn['telkppn'] . " Faksimile: " . $rsltKppn['faxkppn'];
        @$this->Cell(18.3, 0.4, $almKppn, '', 1, 'C');
        // Move to the right
        $this->Cell(0.5,0.4,'','B',0);
        // Title 6
        @$queryKppn = mysql_query("SELECT email,website,smsgateway FROM t_kppn WHERE kddefa='1'") ;
        @$resultKppn = mysql_fetch_array($queryKppn);
        @$webKppn = "Website: " . $resultKppn['website'] . " Email: " . $resultKppn['email'] . " SMS Gateway: " . $resultKppn['smsgateway'];
        $this->Cell(18.3, 0.4, $webKppn, 'B', 1, 'C');
        // Draw line
        //$this->Line(1.0,3.95,20.0,3.95);
        //$this->Line(1.0,4.0,20.0,4.0);        
        // Line break
        $this->Cell(18.8,0.1,'','B',1,'L');
    }

    function Footer() {
        $this->SetTextColor(015, 015, 015);
        //$this->Cell('test');
        $this->SetFont('', 'U');
        $this->SetY(-2, 5);
    }

}

function getBagianName($kd_bag){
    $nmbag = '';
    $pdo = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS) or die('gagal konek!');
    $sql = "SELECT bagian FROM r_bagian WHERE kd_bagian=:kd_bagian";
    $sth = $pdo->prepare($sql);
    $sth->bindValue(':kd_bagian', $kd_bag);
    $sth->execute();
    $data = $sth->fetchAll(PDO::FETCH_OBJ);
    foreach ($data as $val){
        $nmbag = $val->bagian;
    }
    return strtoupper($nmbag);
}

$pdf = new PDF('P', 'cm', 'A4');
$pdf->Open();
$pdf->SetAutoPageBreak(true, 4);
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
$pdf->Cell(4.8, 0.5, 'PARAF PENERIMA', 'RLBT', 1, 'C');

if(count($this->data)>0){
    $no=1;
    $pdf->SetFont('Arial', '', 9);
    //nama satker maks 35 karakter
    foreach($this->data as $key=>$val){
        $kdbag = getBagianName($key);
        $pdf->Cell(18.8, 0.7, $kdbag, 'TBRL', 1, 'L');
        foreach ($val as $value){
        $length_asal = strlen($value['asal_surat']);
        $div = ceil($length_asal/35);
        $asal = substr($value['asal_surat'], 0, 35);
        $j=35;
        $pdf->Cell(2,0.5,$no,'RL',0,'C');
        $pdf->Cell(5, 0.5, $value['no_surat'], 'RL', 0, 'L');        
        $pdf->Cell(7, 0.5, $asal, 'RL', 0, 'L');
        $pdf->Cell(4.8, 0.5, '', 'RL', 1, 'C');
        if($div>0){
            for($i=1;$i<=$div;$i++){
                $asal=  substr($value['asal_surat'], $i*$j,$i*$j+35);
                $pdf->Cell(2,0.5,'','RL',0,'C');
                $pdf->Cell(5, 0.5, '', 'RL', 0, 'C');        
                $pdf->Cell(7, 0.5, $asal, 'RL', 0, 'L');
                $pdf->Cell(4.8, 0.5, '', 'RL', 1, 'C');
            }            
        }
        $no++;
    }
    }
    $pdf->Cell(18.8, 0.3, '', 'T', 1, 'C');
}

$pdf->Output();
?>
