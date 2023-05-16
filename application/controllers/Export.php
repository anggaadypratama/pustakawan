<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('phpword_lib', [APPPATH.'public/template.docx']);
      }

    public function baseExport(){
      $template = $this->phpword_lib;

      $name = $this->session->userdata("export_name");
      $data =  $this->session->userdata("export");

      $template->loadTemplate();
      $template->setValue('pathfinder',$name);
      $template->setValue('date', date('M Y'));

      $header = array(
        array(
          'Hno' => 'No.',
          'Hjudul' => 'Judul/Penanggung jawab',
          'Hpenerbit' => 'Penerbit',
          'Hsubjek' => 'Subjek',
          'Hkategori' => 'kategori',
          'Hpembaca' => 'Peruntukan pembaca',
          'Hdesc' => 'Anotasi'
        )
      );

    
    $template->templateProcessor->cloneRowAndSetValues('Hno', $header);
    $template->templateProcessor->cloneRowAndSetValues('title',  $data);
    
    // Set the values of each cell in the cloned rows
    $rowIndex = 1;
    foreach ($data as $row) {
        $columnIndex = 1;
        foreach ($row as $cell) {
          $template->templateProcessor->setValue('no#' . $rowIndex, $cell);
            $columnIndex++;
        }
        $rowIndex++;
    }

      return [$template, $name];
    }

    public function word(){ 
      list($template, $name) = $this->baseExport();
      $template->save($name);
    }


    public function pdf(){
      list($template, $name) = $this->baseExport();
      $template->savePDF($name);
    }
}