<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/phpoffice/phpword/bootstrap.php';

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;

class Phpword_lib
{
    public $templateProcessor;
    protected $templatePath;

    public function __construct($templatePath = "")
    {
        $this->templatePath = $templatePath;
    }

    public function loadTemplate()
    {
        $this->templateProcessor = new TemplateProcessor($this->templatePath[0]);
    }

    public function setValue($placeholder, $value)
    {
        $this->templateProcessor->setValue($placeholder, $value);
    }

    public function save($fileName)
    {
        // $this->templateProcessor->saveAs($filePath);

         // Set the appropriate headers for the file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . "${fileName}.docx" . '"');
    header('Cache-Control: max-age=0');

    // Save the file contents directly to the output
    $this->templateProcessor->saveAs('php://output');
    }

    public function savePDF($fileName)
    {
        $pathDocx = APPPATH.'public/output.docx';
        $this->templateProcessor->saveAs($pathDocx);

        $data = IOFactory::load($pathDocx);
        $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($data);

        ob_start();
        $htmlWriter->save('php://output');
        $htmlContent = ob_get_clean();
        ob_end_clean();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->changeHTMLStyle($htmlContent));
        $dompdf->render();
        $pdfContent = $dompdf->output();


        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . "${fileName}.pdf" . '"');
        header('Content-Length: ' . strlen($pdfContent));
        echo $pdfContent;
    }

    public function changeHTMLStyle($htmlContent){
        $dom = new DOMDocument();
        $dom->loadHTML($htmlContent);    

        $xpath = new DOMXPath($dom);
        $className = 'TableGrid';

        $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");

        if($elements->length >= 2){

            $tdContent = $elements[0]->getElementsByTagName('td');
            foreach($tdContent as $td){
                $td->setAttribute('style', 'padding: 5px');
            }

            $elements[1]->setAttribute('style', 'border: none');
            $tds = $elements[1]->getElementsByTagName('td');
    
            foreach($tds as $td){
                $td->setAttribute('style', 'border: none');
            }
        }

        $modifiedHtmlString = $dom->saveHTML();
        return $modifiedHtmlString;
    }
}