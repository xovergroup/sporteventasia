<?php 


class Miscellaneous {
    
    public $check, $status;
    
    public function checkExist(){
        
        if(isset($this->check)){
            $check = strlen($this->check);
            
            if($check > 0){
                $this->status = true;
            } else {
                $this->status = false;
            }
        }
    }
    
    public function checkIfSame($var1, $var2){
        
        if($var1 === $var2){
            $status = true;
        } else {
            $status = false;
        }
        
        return $status;
    }
    
    public function convertZeroToNull($item){
        
        if($item == 0){
            $converted = null;
        } else {
            $converted = $item;
        }
        
        return $converted;
    }
    
    public function singularPlural($item, $singular, $plural) {
        
        if($item == 1){
            $word = $singular;
        } elseif($item < 1){
            $word = $singular;
        } elseif($item > 1){
            $word = $plural;
        }
        
        return $word;
    }
    
    public function generateRandStr(){
        
        $salt   = sha1(rand());
        $salt   = substr($salt, 0, 10);
        $number = rand(0,99999999999);
        
        $rand_str = $salt.$number;
        
        return $rand_str;
    }
    
    public function generateUniqueRandStr($salt, $timestamp, $number){

        if($salt){
            $salt   = sha1(rand());
            $salt   = substr($salt, 0, 10);
        } else {
            $salt = "";
        }

        if($timestamp){
            $timestamp = date("YmdHis");
        } else {
            $timestamp = "";
        }

        if($number){
            $number = rand(10000000000,99999999999);
        } else {
            $number = "";
        }

        $rand_str = $salt.$timestamp.$number;

        return $rand_str;
    }
    
}





?>