<?php 


class Session {
    
    public function setSessionUserRegistering($event_id){
        
        $timestamp      = date("YmdHis");
        $random_string  = sha1(rand());
        $random_string  = substr($random_string, 0, 10);
        
        $_SESSION["user_registering_event"] = $event_id;
        $_SESSION["user_temporary_id"]      = $timestamp.$random_string;
         
    }
    
    
    
}





?>