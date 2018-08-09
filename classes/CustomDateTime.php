<?php 


class CustomDateTime {
    
    public $result, $number;
    
    public function dayBefore($number_of_day){
        
        $number_of_day = intval($number_of_day);
        
        //convert to negative
        if($number_of_day != 0){
            
            $number_of_day = -1 * abs($number_of_day);
            
        }
        
    
        $date = new DateTime(); 
        $date->modify($number_of_day." day");
        
        return $date->format("d-m-Y");
        
    } 
    
    
    
    
    
    
}


?>