<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require 'libs/phplot/phplot.php';

$data = $this->data;

$plot = new PHPlot(800);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');

$plot->SetDataType('text-data');
$plot->SetDataValues($data);
# Main plot title:
$plot->SetTitle('');
$plot->SetBackgroundColor('#eeeeff');
$plot->SetDataColors(array('green','red','gray'));
# Make a legend for the 3 data sets plotted:
$plot->SetLegend(array('Tepat waktu', 'Terlambat', 'Belum selesai'));
# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();
?>
