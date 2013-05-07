<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Paging1{
    
    var $page;
    var $limit;
    var $url;
    
    public function __construct() {
        ;
    }
    
    private function setPage($page){
        $this->page = $page;
    }
    
    private function setLimit($limit){
        $this->limit = $limit;
    }
    
    private function setUrl($url){
        $this->url = $url;
    }
    
    private function get($var){
        switch($var){
            case 'page':
                return $this->page;
                break;
            case 'limit':
                return $this->limit;
                break;
            case 'url':
                return $this->url;
                break;
            default:
                echo 'not valid variable';
                break;
        }
    }
    
    public function paging($limit, $url, $page){
        
    }
    
    
}
?>
