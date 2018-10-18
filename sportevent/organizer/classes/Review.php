<?php 


class Review {
    
    
    public function showRateStar($rate, $element){
        
        for($x = 0; $x < $rate; $x++) {
            $html .= $element;
        }
        
        return $html;
        
    }
    
    
    
}





?>