<?php 


class CustomDateTime {
    
    public $result, $number, $msg;
    
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
    
    public function convertDateTime($date, $format){
        
        $str_to_time = strtotime($date);
        $formatted_date = date($format, $str_to_time);
        return $formatted_date;
        
        /*
            //Example
            $datetime = new CustomDateTime();
            echo $datetime->convertDateTime("08:39:57", "g:iA");
            
            //output
            8:39AM
            
        */
        
    }
    
    public function dateTimeNow($format){
        
        return date($format);
        
    }
    
    public function getDateDiff($date1, $date2){
        
        $date1 = new DateTime($date1);
        $date2  = new DateTime($date2);
        $interval   = $date1->diff($date2);

        $number_of_day_left = intval($interval->format('%R%a'));
        
        $this->number = $number_of_day_left;
        
        if($this->number > 1){
            $this->msg = $number_of_day_left." days";
        } elseif($this->number == 1){
            $this->msg = $number_of_day_left." day";
        } else {
            $this->msg = $number_of_day_left." day";
        }
        
    }
    
    
    
    
    
    
    
}


?>