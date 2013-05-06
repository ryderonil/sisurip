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
        @$this->Cell(12.5, 0.4, Kantor::getKanwil(), 'R', 1, 'C');
        // Times bold 12
        $this->SetFont('Times', '', 7);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        @$this->Cell(12.5, 0.3, Kantor::getNamaKPPN(), 'R', 1, 'C');
        // Times  8
        @$this->SetFont('Times', '', 5);
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        @$almKppn = Kantor::getAlamat() . " Telepon: " . Kantor::getTelepon() . " Faksimile: " . Kantor::getFaksimile();
        @$this->Cell(12.5, 0.3, $almKppn, 'R', 1, 'C');
        // Move to the right
        $this->Cell(0.5,0.4,'','L',0);
        
        @$webKppn = "Website: " . Kantor::getWebsite() . " Email: " . Kantor::getEmail() . " SMS Gateway: " . Kantor::getSmsGateway();
        $this->Cell(12.5, 0.3, $webKppn, 'R', 1, 'C');
        // Draw line
        //$this->Line(1.0,3.95,20.0,3.95);
        //$this->Line(1.0,4.0,20.0,4.0);        
        // Line break
        $this->Cell(13,0.3,'','RL',1,'L');
    }

    function Footer() {
        $this->SetTextColor(015, 015, 015);
        //$this->Cell('test');
        $this->SetFont('', 'U');
        $this->SetY(-2, 5);
    }

}
function checkImage($pdf,$val,$val_data,$x,$y){
    //var_dump($val_data);
    if (is_array($val_data)) {
        foreach ($val_data as $data) {
            //echo $val.' '.$data;
            if ($val == $data) {
                $pdf->Image('public/images/check20-cek.png', $x, $y, 0.2, 0.2, 'PNG');
                break;
            } else {
                $pdf->Image('public/images/check20.png', $x, $y, 0.2, 0.2, 'PNG');
            }
        }
    } else {
        if ($val == $val_data) {
            $pdf->Image('public/images/check20-cek.png', $x, $y, 0.2, 0.2, 'PNG');
        } else {
            $pdf->Image('public/images/check20.png', $x, $y, 0.2, 0.2, 'PNG');
        }
    }
    
    
}

   
$pdf = new PDF('P', 'cm', 'A5');
$pdf->Open();

$pdf->AliasNbPages();
for($i=0;$i<count($this->view->data);$i++){ 
$pdf->AddPage();
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(13,0,'','T',1);
$pdf->Cell(13, 0.4, 'LEMBAR DISPOSISI '.Kantor::getNama(), 'RLB', 1, 'C');
$perh = 'PERHATIAN : Dilarang memisahkan sehelai suratpun yang tergabung dalam berkas ini';
$pdf->Cell(13, 0.4, $perh, 'BRL', 1, 'C');
$pdf->Cell(4.5,0.4,'','LR',0,'L');
$pdf->Cell(4.5,0.4,'',0,0,'L');
$pdf->Cell(4,0.4,'','LR',1,'L');
$pdf->Cell(1.5,0.4,'No Surat','L',0,'L');
$pdf->Cell(3,0.4,': '.$this->view->data[$i]['no_surat'],'R',0,'L');
$pdf->Cell(1.5,0.4,'Status',0,0,'L');
$pdf->Cell(3,0.4,': --'.$this->view->data[$i]['status'],'R',0,'L');
$pdf->Cell(1.5,0.4,'Diterima Tgl',0,0,'L');
$pdf->Cell(2.5,0.4,': '.$this->view->data[$i]['tgl_terima'],'R',1,'L');
$pdf->Cell(1.5,0.4,'Tgl Surat','L',0,'L');
$pdf->Cell(3,0.4,': '.$this->view->data[$i]['tgl_surat'],'R',0,'L');
$pdf->Cell(1.5,0.4,'Sifat',0,0,'L');
$pdf->Cell(3,0.4,': '.$this->view->data[$i]['sifat'],'R',0,'L');
$pdf->Cell(1.5,0.4,'No. Agenda',0,0,'L');
$pdf->Cell(2.5,0.4,': '.$this->view->data[$i]['no_agenda'],'R',1,'L');
$pdf->Cell(1.5,0.4,'Lampiran','BL',0,'L');
$pdf->Cell(3,0.4,': '.$this->view->data[$i]['lampiran'],'BR',0,'L');
$pdf->Cell(1.5,0.4,'Jenis','B',0,'L');
$pdf->Cell(3,0.4,': '.$this->view->data[$i]['jenis'],'BR',0,'L');
$pdf->Cell(1.5,0.4,'','B',0,'L');
$pdf->Cell(2.5,0.4,'','RB',1,'L');
$pdf->Cell(1.5,0.4,'Dari','L',0,'L');
$pdf->Cell(11.5,0.4,': '.$this->view->data[$i]['asal_surat'],'R',1,'L');
$pdf->Cell(1.5,0.4,'Perihal','L',0,'L');
$pdf->Cell(11.5,0.4,': '.$this->view->data[$i]['perihal'],'R',1,'L');
$pdf->Cell(1.5,0.4,'','BL',0,'L');
$pdf->Cell(11.5,0.4,'','BR',1,'L');

//$pdf->Image('public/images/check20-cek.png', 3, 7.08, 0.2, 0.2, 'PNG');
checkImage($pdf, 'SS', $this->view->disp[$i][2], 3, 7.08);
$pdf->Cell(6.5,0.4,'SANGAT SEGERA','BL',0,'C');
//$pdf->Image('public/images/check20.png', 9.95, 7.08, 0.2, 0.2, 'PNG');
checkImage($pdf, 'S', $this->view->disp[$i][2], 9.95, 7.08);
$pdf->Cell(6.5,0.4,'SEGERA','BLR',1,'C');
$pdf->Cell(13,0.4,'Diteruskan kepada ','RL',1,'L');
$pdf->Cell(13,0.4,'DISPOSISI KEPALA KANTOR KEPADA :','RL',1,'L');
//$pdf->Image('public/images/check20.png', 1.1, 8.3, 0.2, 0.2, 'PNG');
checkImage($pdf, 'UM', $this->view->disp[$i][3], 1.1, 8.3);
$pdf->Cell(4,0.4,'     Kasubbag Umum','L',0,'L');
//$pdf->Image('public/images/check20.png', 5.1, 8.3, 0.2, 0.2, 'PNG');
checkImage($pdf, 'BU', $this->view->disp[$i][3], 5.1, 8.3);
$pdf->Cell(4,0.4,'     Kasi Bank/ Giro Pos',0,0,'L');
//$pdf->Image('public/images/check20.png', 9.1, 8.3, 0.2, 0.2, 'PNG');
checkImage($pdf, 'SP', $this->view->disp[$i][3], 9.1, 8.3);
$pdf->Cell(5,0.4,'     Sekretaris Pribadi','R',1,'L');
//$pdf->Image('public/images/check20.png', 1.1, 8.7, 0.2, 0.2, 'PNG');
checkImage($pdf, 'P1', $this->view->disp[$i][3], 1.1, 8.7);
$pdf->Cell(4,0.4,'     Kasi Pencairan Dana I','L',0,'L');
//$pdf->Image('public/images/check20.png', 5.1, 8.7, 0.2, 0.2, 'PNG');
checkImage($pdf, 'VA', $this->view->disp[$i][3], 5.1, 8.7);
$pdf->Cell(4,0.4,'     Kasi Verifikasi dan Akuntansi',0,0,'L');
//$pdf->Image('public/images/check20.png', 9.1, 8.7, 0.2, 0.2, 'PNG');
checkImage($pdf, 'LL', $this->view->disp[$i][3], 9.1, 8.7);
$pdf->Cell(5,0.4,'     Lain lain','R',1,'L');
//$pdf->Image('public/images/check20.png', 1.1, 9.1, 0.2, 0.2, 'PNG');
checkImage($pdf, 'P2', $this->view->disp[$i][3], 1.1, 9.1);
$pdf->Cell(4,0.4,'     Kasi Pencairan Dana II','L',0,'L');
$pdf->Cell(4,0.4,'',0,0,'L');
$pdf->Cell(5,0.4,'','R',1,'R');
$pdf->Cell(13,0.7,'PETUNJUK :','RL',1,'L');
//$pdf->Image('public/images/check20.png', 1.1, 10.2, 0.2, 0.2, 'PNG');
checkImage($pdf, '1', $this->view->disp[$i][4], 1.1, 10.2);
$pdf->Cell(3,0.4,'     Setuju','L',0,'L');
//$pdf->Image('public/images/check20.png', 4.1, 10.2, 0.2, 0.2, 'PNG');
checkImage($pdf, '5', $this->view->disp[$i][4], 4.1, 10.2);
$pdf->Cell(3,0.4,'     Selesaikan',0,0,'L');
//$pdf->Image('public/images/check20.png', 7.1, 10.2, 0.2, 0.2, 'PNG');
checkImage($pdf, '9', $this->view->disp[$i][4], 7.1, 10.2);
$pdf->Cell(3,0.4,'     Jawab',0,0,'L');
//$pdf->Image('public/images/check20.png', 10.1, 10.2, 0.2, 0.2, 'PNG');
checkImage($pdf, '13', $this->view->disp[$i][4], 10.1, 10.2);
$pdf->Cell(4,0.4,'     Ingatkan','R',1,'L');
//$pdf->Image('public/images/check20.png', 1.1, 10.6, 0.2, 0.2, 'PNG');
checkImage($pdf, '2', $this->view->disp[$i][4], 1.1, 10.6);
$pdf->Cell(3,0.4,'     Tolak','L',0,'L');
//$pdf->Image('public/images/check20.png', 4.1, 10.6, 0.2, 0.2, 'PNG');
checkImage($pdf, '6', $this->view->disp[$i][4], 4.1, 10.6);
$pdf->Cell(3,0.4,'     Sesuai Catatan',0,0,'L');
//$pdf->Image('public/images/check20.png', 7.1, 10.6, 0.2, 0.2, 'PNG');
checkImage($pdf, '10', $this->view->disp[$i][4], 7.1, 10.6);
$pdf->Cell(3,0.4,'     Perbaiki',0,0,'L');
//$pdf->Image('public/images/check20.png', 10.1, 10.6, 0.2, 0.2, 'PNG');
checkImage($pdf, '14', $this->view->disp[$i][4], 10.1, 10.6);
$pdf->Cell(4,0.4,'     Simpan','R',1,'L');
//$pdf->Image('public/images/check20.png', 1.1, 11, 0.2, 0.2, 'PNG');
checkImage($pdf, '3', $this->view->disp[$i][4], 1.1, 11);
$pdf->Cell(3,0.4,'     Teliti & Pendapat','L',0,'L');
//$pdf->Image('public/images/check20.png', 4.1, 11, 0.2, 0.2, 'PNG');
checkImage($pdf, '7', $this->view->disp[$i][4], 4.1, 11);
$pdf->Cell(3,0.4,'     Untuk perhatian',0,0,'L');
//$pdf->Image('public/images/check20.png', 7.1, 11, 0.2, 0.2, 'PNG');
checkImage($pdf, '11', $this->view->disp[$i][4], 7.1, 11);
$pdf->Cell(3,0.4,'     Bicarakan dengan saya',0,0,'L');
//$pdf->Image('public/images/check20.png', 10.1, 11, 0.2, 0.2, 'PNG');
checkImage($pdf, '15', $this->view->disp[$i][4], 10.1, 11);
$pdf->Cell(4,0.4,'     Disiapkan','R',1,'L');
$pdf->Image('public/images/check20.png', 1.1, 11.4, 0.2, 0.2, 'PNG');
checkImage($pdf, '4', $this->view->disp[$i][4], 1.1, 11.4);
$pdf->Cell(3,0.4,'     Untuk diketahui','L',0,'L');
//$pdf->Image('public/images/check20.png', 4.1, 11.4, 0.2, 0.2, 'PNG');
checkImage($pdf, '8', $this->view->disp[$i][4], 4.1, 11.4);
$pdf->Cell(3,0.4,'     Edarkan',0,0,'L');
//$pdf->Image('public/images/check20.png', 7.1, 11.4, 0.2, 0.2, 'PNG');
checkImage($pdf, '12', $this->view->disp[$i][4], 7.1, 11.4);
$pdf->Cell(3,0.4,'     Bicarakan bersama',0,0,'L');
//$pdf->Image('public/images/check20.png', 10.1, 11.4, 0.2, 0.2, 'PNG');
checkImage($pdf, '16', $this->view->disp[$i][4], 10.1, 11.4);
$pdf->Cell(4,0.4,'     Harap dihadiri/diwakili','R',1,'L');
$pdf->Cell(13,0.7,'CATATAN KEPALA KANTOR :','RL',1,'L');
//$pdf->MultiCell(13, 0.1, $test, 1, 'J');
@$pdf->Cell(13,0.4,''.$this->view->disp[$i][5],'RL',1,'L');
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
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0.4,'','RL',1,'L');
$pdf->Cell(13,0.4,'Tgl Penyelesaian :','TLR',1,'L');
$pdf->Cell(13,0.4,'Penerima :','TBLR',1,'L');

}
$pdf->Output();



?>
