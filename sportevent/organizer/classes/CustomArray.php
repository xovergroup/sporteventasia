<?php 


class CustomArray {
    
    public function countFirstElementOfArrayValue($array){
        
        $number = count(array_values($array)[0]);
        
        return $number;
        
        /*
        Array
            (
                [event_category_name] => Array
                    (
                        [0] => 
                        [1] => 
                    )

                [event_category_fees] => Array
                    (
                        [0] => 
                        [1] => 
                    )
            )
            
        This method will count the first array. The above example will return 2. Useful for for loop
        */
    }
    
    public function createArray($value, $loop){
        
        $array = array();
        
        if($loop > 1){
            
            for ($x = 0; $x < $loop; $x++) {
                $array[] = $value;
            } 
        } else {
            
            $array[] = $value;
        }
            
       return $array;
        
    }
    
    
    
}





?>