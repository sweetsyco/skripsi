<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf {
    public function __construct() {
        $this->dompdf = new Dompdf();
    }

    public function generate($html, $filename, $stream = true, $paper = 'A4', $orientation = 'portrait') {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paper, $orientation);
        $this->dompdf->render();

        if ($stream) {
            $this->dompdf->stream($filename, ["Attachment" => 1]);
        } else {
            return $this->dompdf->output();
        }
    }
}