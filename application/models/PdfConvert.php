<?php
    class PdfConvert extends CI_model{
        private $_pdf;
        public function __construct() {
            parent::__construct();
            $this->_pdf   =   new \Mpdf\Mpdf(
                [
                    'mode'          => 'utf-8',
                    'default_font'  => 'fantasy',
                    'orientation'   => 'P',
                    'format'        => 'A4',
                    'margin_left'   => 5,
                    'margin_right'  => 5,
                    'margin_top'    => 5,
                    'margin_bottom' => 5,
                    'margin_header' => 5,
                    'margin_footer' => 5,
                ]
            );
        }

        public function do_pdf($data) {
            $dtAPI['value'] = $data;
            $title          = 'berita-acara-'.$data['action'].'-'.str_replace('/','-',$data['param']);
            $filename       = $title.'.pdf';
            $pdfFilePath    = FCPATH . "assets/filePDF/".$filename;
            $file = $this->load->view('content/bastPool',$dtAPI,TRUE);
            ob_clean();
            $this->_pdf->SetDisplayMode('fullpage');
            $this->_pdf->SetTitle($title);
            $this->_pdf->WriteHTML($file);
            $this->_pdf->Output($pdfFilePath, "F");
            return 'assets/filePDF/'.$filename;
        }
    }
?>