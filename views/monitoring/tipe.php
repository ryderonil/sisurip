<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require 'libs/phplot/phplot.php';

$color = array('skyblue',
                'green',
                'orange',
                'blue',
                'red',
                'DarkGreen',
                'purple',
                'peru',
                'cyan',
                'salmon',
                'SlateBlue',
                'Yellow',
                'magenta',
                'aquamarine1',
                'gold',
                'violet');
$data = $this->data;

$plot = new PHPlot(400,250);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('pie');

$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);
# Main plot title:
$plot->SetTitle('TIPE NASKAH');
$plot->SetBackgroundColor('#eeeeff');
# Make a legend for the 3 data sets plotted:
# Turn off X tick labels and ticks because they don't apply here:
$plot->SetDataColors(array('lavender', 'red', 'green', 'blue', 'yellow',
                'SlateBlue', 'cyan','magenta', 'brown', 'pink',
                'gray', 'orange','purple','peru','salmon','aquamarine1',
                'violet','gold',));
foreach ($data as $row)
$plot->SetLegend(implode(': ', $row));
# Place the legend in the upper left corner:
$plot->SetLegendPixels(5, 5);
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();
?>
