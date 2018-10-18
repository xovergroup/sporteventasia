<?php 


class Price extends CustomDateTime {
    
    public $today, $earlyBirdEndDate, $fullPrice, $earlyBirdPrice, $realPrice;
    
    public function checkEarlyBirdPrice(){
        
        if(isset($this->today) && isset($this->earlyBirdEndDate) && isset($this->fullPrice) && isset($this->earlyBirdPrice)){
            
            
            $this->getDateDiff($this->today, $this->earlyBirdEndDate);
            
            
            if($this->earlyBirdPrice == 0){
                
                $this->realPrice = $this->fullPrice;
                
            } else {
                
                if($this->number > 0){
                    $this->realPrice = $this->earlyBirdPrice;
                } else {
                    $this->realPrice = $this->fullPrice;
                }
            }
        }
        
    }
    
    
    
}





?>