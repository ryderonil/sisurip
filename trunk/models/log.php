<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Log extends Model{
    
    private $LOGFILENAME;
    private $SEPARATOR;
    private $HEADERS;
    
    const DEFAULT_TAG = '--';
    
    public function __construct($logfilename='log.csv',$separator=',') {
        parent::__construct();
        $this->LOGFILENAME = $logfilename;
        $this->SEPARATOR = $separator;
        $this->HEADERS = 
                'DATETIME'.$this->SEPARATOR.
                'USER'.$this->SEPARATOR.
                'TAG'.$this->SEPARATOR.
                'VALUE';
    }

    public function addLog($user, $tag,$value=''){
        $datetime = date('Y-m-d@H:i:s');
        if(!file_exists($this->LOGFILENAME)){
            $headers = $this->HEADERS.'\n';
        }
        
        $fd = fopen($this->LOGFILENAME, 'a');
        
        if(@$headers){
            fwrite($fd, $headers);
        }
        
        $entry = array($datetime, $user,$tag,$value);
        
        fputcsv($fd,$entry,  $this->SEPARATOR);
        
        fclose($fd);
        
    }
    
    public function getLog($filename) {
        $return = array();
        if (file_exists($filename)) {
            $fp = fopen($filename, 'r') or die("can't open file");

            while ($csv_line = fgetcsv($fp, 1024)) {

                for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                    $temp = explode(";", $csv_line[$i]);
                    $return[] = $temp;
                }
            }

            fclose($fp) or die("can't close file");
        } else {
            print 'alert(file not found)';
        }
        
        return $return;
    }
    
}
?>
