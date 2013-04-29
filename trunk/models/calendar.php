<?php

/*
 * source : http://www.pixelcode.co.uk/tutorials/Creating+a+calendar+in+PHP.html
 * dengan penambahan dan perubahan seperlunya
 */
class Calendar extends Model {

    var $events;

    function Calendar($date) {
        if (empty($date))
            $date = time();
        define('NUM_OF_DAYS', date('t', $date));
        define('CURRENT_DAY', date('j', $date));
        define('CURRENT_MONTH_A', date('F', $date));
        define('CURRENT_MONTH_N', date('n', $date));
        define('CURRENT_YEAR', date('Y', $date));
        define('START_DAY', (int) date('N', mktime(0, 0, 0, CURRENT_MONTH_N, 1, CURRENT_YEAR)) - 1);
        define('COLUMNS', 7);
        define('PREV_MONTH', $this->prev_month());
        define('NEXT_MONTH', $this->next_month());
        $this->events = array();
    }

    function prev_month() {
        return mktime(0, 0, 0, (CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), (checkdate((CURRENT_MONTH_N == 1 ? 12 : CURRENT_MONTH_N - 1), CURRENT_DAY, (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1), (CURRENT_MONTH_N == 1 ? CURRENT_YEAR - 1 : CURRENT_YEAR));
    }

    function next_month() {
        return mktime(0, 0, 0, (CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1), (checkdate((CURRENT_MONTH_N == 12 ? 1 : CURRENT_MONTH_N + 1), CURRENT_DAY, (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR)) ? CURRENT_DAY : 1), (CURRENT_MONTH_N == 12 ? CURRENT_YEAR + 1 : CURRENT_YEAR));
    }

    function getEvent($timestamp) {
        $event = NULL;
        if (array_key_exists($timestamp, $this->events))
            $event = $this->events[$timestamp];
        return $event;
    }

    function addEvent($event, $day = CURRENT_DAY, $month = CURRENT_MONTH_N, $year = CURRENT_YEAR) {
        $timestamp = mktime(0, 0, 0, $month, $day, $year);
        if (array_key_exists($timestamp, $this->events))
            array_push($this->events[$timestamp], $event);
        else
            $this->events[$timestamp] = array($event);
    }

    function makeEvents() {
        if ($events = $this->getEvent(mktime(0, 0, 0, CURRENT_MONTH_N, CURRENT_DAY, CURRENT_YEAR)))
            foreach ($events as $event)
                echo $event . '<br />';
    }

    function makeCalendar() {
        echo '<table border="0" cellspacing="4" id="calendar"><tr >';
        echo '<td width="30"><a href="' . URL . 'admin/calendar/' . PREV_MONTH . '"><img src=' . URL . 'public/images/icons/prev.png></a></td>';
        echo '<td colspan="5" style="text-align:center">' . strtoupper($this->bulan_indo(CURRENT_MONTH_A)) . ' - ' . CURRENT_YEAR . '</td>';
        echo '<td width="30"><a href="' . URL . 'admin/calendar/' . NEXT_MONTH . '"><img src=' . URL . 'public/images/icons/next.png></a></td>';
        echo '</tr><tr style="background-color: #abc0c5">';
        echo '<td width="30">Senin</td>';
        echo '<td width="30">Selasa</td>';
        echo '<td width="30">Rabu</td>';
        echo '<td width="30">Kamis</td>';
        echo '<td width="30">Jum\'at</td>';
        echo '<td width="30">Sabtu</td>';
        echo '<td width="30">Minggu</td>';
        echo '</tr><tr>';

        echo str_repeat('<td>&nbsp;</td>', START_DAY);

        $rows = 1;

        for ($i = 1; $i <= NUM_OF_DAYS; $i++) {
            $timestamp = mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR);
            $curEvent = $this->getEvent(mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR));
            if ($i == CURRENT_DAY) {
                echo '<td '.$this->cekSabtuMinggu('style="background-color: #C0C0C0"',$timestamp).'><a ';
                if ($event = $this->getEvent(mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR))) {
                    echo "title='" . $curEvent[0] . "' class=tip";
                }
                echo '><strong>' . $i . '</strong></a></td>';
            } else if ($event = $this->getEvent(mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR))) {
                echo "<td style='background-color: #ff8a8a'><a href=" . URL . "admin/calendar/" . mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR) . " onclick=addLiburi(" . mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR) . ") title='" . $curEvent[0] . "' class=tip ><span>" . $i . "</span></a></td>";
            } else {
                echo '<td '.$this->cekSabtuMinggu('', $timestamp).'><a href="' . URL . 'admin/calendar/' . mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR) . '" onclick=addLiburi(' . mktime(0, 0, 0, CURRENT_MONTH_N, $i, CURRENT_YEAR) . ')>' . $i . '</a></td>';
            }
            if ((($i + START_DAY) % COLUMNS) == 0 && $i != NUM_OF_DAYS) {
                echo '</tr><tr>';
                $rows++;
            }
        }
        echo str_repeat('<td>&nbsp;</td>', (COLUMNS * $rows) - (NUM_OF_DAYS + START_DAY)) . '</tr></table>';
    }

    function bulan_indo($bulan) {
        $month = '';

        switch ($bulan) {
            case 'January':
                $month = 'Januari';
                break;
            case 'February':
                $month = 'Februari';
                break;
            case 'March':
                $month = 'Maret';
                break;
            case 'April':
                $month = 'April';
                break;
            case 'May':
                $month = 'Mei';
                break;
            case 'June':
                $month = 'Juni';
                break;
            case 'July':
                $month = 'Juli';
                break;
            case 'August':
                $month = 'Agustus';
                break;
            case 'September':
                $month = 'September';
                break;
            case 'October':
                $month = 'Oktober';
                break;
            case 'November':
                $month = 'November';
                break;
            case 'December':
                $month = 'Desember';
                break;
        }

        return $month;
    }
    
    function cekSabtuMinggu($style, $timestamp){
        $return = $style;
        $date = date('w',$timestamp);
        if($date==0 OR $date==6){
            $return = 'style="background-color: #ff8a8a"';
        }        
        return $return;
    }

}

?>