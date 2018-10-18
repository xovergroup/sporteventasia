<?php 


class State {
    
    public function getStateName($state){
        
        if(intval($state) == 1){
            $name = "Kuala Lumpur";
        } elseif(intval($state) == 2){
            $name = "Selangor";
        } elseif(intval($state) == 3){
            $name = "Putrajaya";
        } elseif(intval($state) == 4){
            $name = "Johor";
        } elseif(intval($state) == 5){
            $name = "Melaka";
        } elseif(intval($state) == 6){
            $name = "Perak";
        } elseif(intval($state) == 7){
            $name = "Kedah";
        } elseif(intval($state) == 8){
            $name = "Kelantan";
        } elseif(intval($state) == 9){
            $name = "Negeri Sembilan";
        } elseif(intval($state) == 10){
            $name = "Pahang";
        } elseif(intval($state) == 11){
            $name = "Perlis";
        } elseif(intval($state) == 12){
            $name = "Pulau Pinang";
        } elseif(intval($state) == 13){
            $name = "Terengganu";
        } elseif(intval($state) == 14){
            $name = "Sabah";
        } elseif(intval($state) == 15){
            $name = "Sarawak";
        } elseif(intval($state) == 16){
            $name = "W.P. Labuan";
        } else {
            $name = "Anywhere";
        }
        
        return $name;
        
    }
    
    
    
}





?>