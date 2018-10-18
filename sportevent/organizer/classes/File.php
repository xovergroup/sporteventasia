<?php 


class File {
    
    public function getFileExtension($file_name){
        
        $type = pathinfo($file_name, PATHINFO_EXTENSION);
        $type = strtolower($type);
        return $type;
    }
    
    public function uploadFile($path, $file_information, $prefix, $ext) {
        
        $allowed_files = $this->explodedArray($ext);
        
        $check = $this->getFileExtension($file_information["name"]);
        
        if(in_array($check, $allowed_files)){
            
            $datetime = date("YmdHis");

            $uploaddir = $path;
            $file_name = $prefix.$datetime."_".basename($file_information['name']);
            $uploadfile = $uploaddir.$file_name;
            if(move_uploaded_file($file_information['tmp_name'], $uploadfile)) {

                $data["status"] = true;
                $data["msg"] = "File transfer success";
                $data["filename"] = $file_name;
                
            } else {
                $data["status"] = false;
                $data["msg"] = "File transfer failed";
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "File Format Not Allowed";
        }

        return $data;
    }
    
    public function processImage64($image_base64_encoded, $full_path, $save_path, $prefix){
        
        $unique_id = $this->generateUniqueId();
        $date = new DateTime();
        $dateTimeNow = $date->format("YmdHis");
        
        
        $image_data = explode(',', $image_base64_encoded);
        $decode_image = base64_decode($image_data[1]);
        $img_name = preg_replace('/\s+/', '', $prefix.'_'.$dateTimeNow.'_'.$unique_id);
        $link = $save_path.$img_name.".png";
        $path = $full_path.$img_name.".png";
        $file = fopen($link, 'wb');
        $is_written = fwrite($file, $decode_image);
        fclose($file);
        
        return $path;
    }
    
    public function convertImageToBase64($link, $format){
        
        $image = base64_encode(file_get_contents($link));
        $image = "data:image/".$format.";base64,".$image;
        
        return $image;
        
    }
    
    private function generateUniqueId(){
        
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $random_num = rand(1000000000, 9999999999);
        $unique_id = $random_num.$salt;
        
        return $unique_id;
        
    }
    
    
    
}





?>