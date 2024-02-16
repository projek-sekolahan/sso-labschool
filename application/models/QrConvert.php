<?php
    class QrConvert extends CI_model{

        function generate($param=[]) { 
            return new \Mpdf\QrCode\QrCode($param); 
        }

        function imagePNG($param=[]) { 
            return new \Mpdf\QrCode\Output\Png($param); 
        }

        public function createQR($data,$ket) {
            $filename   = $data['title'].'.png';
            $qrFilePath = FCPATH . "assets/fileQR/".$filename;
            // isi qrcode
            $code       = $this->generate($data['data']);
            $QrResult   = $this->imagePNG();
            $datacode   = $QrResult->output($code,250);
		    file_put_contents($qrFilePath, $datacode);
            return 'assets/fileQR/'.$filename;
        }

    }
?>