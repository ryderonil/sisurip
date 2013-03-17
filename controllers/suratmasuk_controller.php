<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of suratMasuk
 *
 * @author aisyah
 */
class Suratmasuk_Controller extends Controller{
    
    public function __construct() {
        @parent::__construct($registry);
        Auth::handleLogin();
        $this->nomor = new Nomor();
        $this->view->kantor = Kantor::getNama(); 
        $this->view->js = array(
          'suratmasuk/js/default'  
        );
        //$this->view = new View;
        //echo "</br>kelas berhasil di bentuk";
    }
    //put your code here
    
    public function index(){
        //$this->view->render('suratmasuk/index');
        //header('location:'.URL.'suratmasuk/showall');
        $this->showAll();
    }
    
    public function showAll(){
        
        $this->view->listSurat = $this->model->showAll();
        
        $this->view->render('suratmasuk/suratmasuk');
    }
    
    public function edit($id){
        $this->view->data = $this->model->getSuratMasukById($id);
        $this->view->render('suratmasuk/ubah');
    }
    
    public function remove($id){
        $this->model->remove($id);
        
    }
    
    public function editSurat(){
        $this->model->editSurat();
    }
    
    public function input(){
        $this->model->input();
    }
    
    public function rekam(){
        $this->view->agenda = $this->nomor->generateNumber('SM');
        $this->view->render('suratmasuk/rekam');
    }
    
    public function detil($id){
        $this->view->dataSurat = $this->model->getSuratMasukById($id);
        foreach($this->view->dataSurat as $key=>$value){
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_agenda'];
            $this->view->data[2] = $value['tgl_terima'];
            $this->view->data[3] = $value['tgl_surat'];
            $this->view->data[4] = $value['no_surat'];
            $this->view->data[5] = $value['asal_surat'];
            $this->view->data[6] = $value['perihal'];

        }
        $this->view->render('suratmasuk/detilsurat');
    }
    
    public function disposisi($id){
        $this->view->data = $this->model->getSuratMasukById($id);
        $this->view->seksi = $this->model->get('r_bagian');
        $this->view->petunjuk = $this->model->get('r_petunjuk');
        $this->view->data2 = $this->model->select('SELECT * FROM disposisi WHERE id_surat=' . $id);
        $this->view->count = count($this->view->data2);
        //echo $this->view->count;
        if ($this->view->count > 0) {

            foreach ($this->view->data2 as $key => $value) {
                $this->view->disp[0] = $value['id_disposisi'];
                $this->view->disp[1] = $value['id_surat'];
                $this->view->disp[2] = $value['sifat'];
                $this->view->disp[3] = $value['disposisi'];
                $this->view->disp[4] = $value['petunjuk'];
                $this->view->disp[5] = $value['catatan'];
            }
            $this->view->disposisi = explode(',', $this->view->disp[3]);
            $this->view->petunjuk = explode(',', $this->view->disp[4]);
            //var_dump($this->view->disposisi);

            $this->view->render('suratmasuk/ctkDisposisi');
        }else{
           $this->view->render('suratmasuk/disposisi'); 
        }
        
    }
    
    public function rekamdisposisi(){
        $this->model->rekamdisposisi();
    }
    
    public function distribusi($id){
        $this->view->dataSurat = $this->model->select('SELECT * FROM suratmasuk WHERE id_suratmasuk='.$id);
        $this->view->bagian = $this->model->select('SELECT * FROM r_bagian');
        
        foreach($this->view->dataSurat as $value){
            $this->view->data[0] = $value['id_suratmasuk'];
            $this->view->data[1] = $value['no_surat'];
            $this->view->data[2] = $value['perihal'];
            $this->view->data[3] = $value['asal_surat'];           
            
        }
        $this->view->render('suratmasuk/distribusi');
    }
    
    public function rekamDistribusi(){
        $id = $_POST['id'];
        $bagian = $_POST['bagian'];
        //var_dump($bagian);
        $this->model->distribusi($id, $bagian);
    }
}

?>
