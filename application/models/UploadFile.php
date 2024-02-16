<?php
class UploadFile extends CI_Model {
	function photo($folder,$subfolder,$data) {
        $mime_type = @mime_content_type($data['img']);
        $allowed_file_types = ['image/png','image/jpeg','image/jpg'];
        if (! in_array($mime_type, $allowed_file_types)) {
            return false;
        } else {
            $table      =   $data['table'];
            if ($table=='calendars_article') {
                $name   = '-artikel-'.base64_encode($data['articleid'].':'.strtotime(date('d-m-Y H:m:s')));
            }
            if ($table=='users_img') {
                $name   = str_replace(' ','',$data['nip']);
            }
            $filePath   =   'assets/'.$folder.'/'.$subfolder.'/';
            list($type, $data['img'])   = explode(';', $data['img']);
            list(,$extension)           = explode('/',$type);
            list(,$data['img'])         = explode(',', $data['img']);
            $fileName                   = uniqid().$name.time().'.'.$extension;
            $filedecode = base64_decode(preg_replace('#^data:image/\w+;base64,#i','',$data['img']));
            $filesPhoto = $filePath.$fileName;
            file_put_contents($filesPhoto,$filedecode);
            return $filesPhoto;
        }
	}
}
?>