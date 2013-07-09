<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require 'libs/phplot/phplot.php';

$data = $this->data;
$lebar = $this->lebar;
//var_dump($lebar);
$plot = new PHPlot($lebar,250);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');

$plot->SetDataType('text-data');
$plot->SetDataValues($data);
# Main plot title:
$plot->SetTitle('PENYELESAIAN SURAT BULAN '.strtoupper(Tanggal::bulan_indo(date('m'))));
$plot->SetBackgroundColor('#eeeeff');
$plot->SetDataColors(array('green','red','blue','grey'));
# Make a legend for the 4 data sets plotted:
$plot->SetLegend(array('SM selesai', 'SM belum selesai', 'SK selesai','SK belum selesai'));
//$plot->SetLegendPosition(0, 0, 'image', 0, 0, 5, 5);
//$plot->SetShading(0);
# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();
?>
