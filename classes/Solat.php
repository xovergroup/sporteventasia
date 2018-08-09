<?php 



class Solat {
    
    private $database = null;
    private $cols = array("solat_name", "solat_type", "solat_date", "solat_datetime", "solat_counter");
    private $cols2 = array("solat_name", "solat_type", "solat_date", "solat_datetime");
    private $table = "solats";
    private $imploded;

    public $solat_id, $solat_name, $solat_type, $total, $countResult, $status, $sql, $html, $result, $formatDate, $solat_date;
    
    
    public function __construct($database) {
        $this->database = $database;
    }
    
    
    public function sanitizeInt($var) {
        
        $var = intval($var);
        return $var;
    }
    
    
    public function sanitizeString($var) {

        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = preg_replace('/\s+/', '', $var);
        return $var;
    }
    
    public function sanitizeStringV2($var) {

        $var = filter_var($var, FILTER_SANITIZE_STRING);
        $var = htmlentities($var);
        $var = strip_tags($var);

        return $var;
    }
    
    public function sanitizeStringV3($var) {

        $var = filter_var($var, FILTER_SANITIZE_STRING);
        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = preg_replace('/\s+/', '', $var);

        return $var;
    }

    
    
    private function implodedArray($cols) {
        
        $imploded = implode(", ", $cols);
        return $imploded;
    }
    
    
    public function formatDate($date){
        
        $date   = new DateTime($date);
        $format  = $date->format("d-m-Y");
        
        return $format;
    }
    
    
    public function formatDateV2($date){
        
        $date   = new DateTime($date);
        $format  = $date->format("Y-m-d");
        
        return $format;
    }
    
    
    public function countTotalSolat($solat_id, $solat_type){
        
        $this->solat_id     = intval($solat_id);
        $this->solat_type   = intval($solat_type);
        
        $sql = "SELECT SUM(solat_counter) AS total FROM solats_wajib WHERE solat_name = ".$this->solat_id." AND solat_type = ".$this->solat_type." ";
        $result =  $this->database->query($sql);
        
        if($result) {
            
            $this->status = "Success";
            $this->sql = $sql;
            
            if($row = $result->fetch_object()) {
                $total = $row->total;
                
                if($total == null) {
                    $total = 0;
                }
            }
        
        } else {
            
            $this->status   = "Failure";
            $this->sql      = $sql;
            $total          = 0;
        }
        
        return $total;
        
    }
    
    
    public function checkSolatTodayExist(){
        
        
        $date   = new DateTime();
        $today  = $date->format("Y-m-d");
        
        $sql = "SELECT COUNT(solat_date) AS total FROM solats_wajib WHERE solat_date = '".$today."'";
        $result =  $this->database->query($sql);
        
        if($result) {
            
            $this->status   = "Success";
            $this->sql      = $sql;
            
            if($row = $result->fetch_object()) {
                $this->total    = $row->total;
            }
        
        } else {
            
            $this->status   = "Failure";
            $this->sql      = $sql;
            $this->total    = 0;
        }
    }
    
    
    #Use with checkSolatTodayExist()
    public function insertDailySolat(){
        
        if(isset($this->total)){
            
            if($this->total < 1) {
                
                $imploded = $this->implodedArray($this->cols2);
                
                $date           = new DateTime();
                $dateToday      = $date->format("Y-m-d");
                $dateTimeToday  = $date->format("Y-m-d H:i:s");
                
                for ($x = 1; $x <= 5; $x++) {
                    
                    $sql = "INSERT INTO solats_wajib (".$imploded.") VALUES(".$x.", 3, '".$dateToday."', '".$dateTimeToday."') ";
                    
                    $this->sql  = $sql;
                    $result     =  $this->database->query($sql);
                    
                } 
            }
        }
    }
    
    
    public function selectSolatByDate($date){
        
        $date   = $this->sanitizeString($date);
        $date   = new DateTime($date);
        $date  = $date->format("Y-m-d");
        
        $sql = "SELECT * FROM solats_wajib WHERE solat_date = '".$date."' ORDER BY solat_name ASC ";
        $result =  $this->database->query($sql);
        
        if($result) {
            
            if($result->num_rows > 0) {
                
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->countResult  = $result->num_rows;
                
            } else {
                
                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->countResult  = $result->num_rows;
                $this->result       = "Failed";
            }
            
        
        } else {
            
            $this->status       = "Failure";
            $this->sql          = $sql;
            $this->result       = "Failed";
            
        }
        return $this->result;
    }
    
    
    
    public function selectDailySolatType($solat_id, $date){
        
        $solat_id   = intval($solat_id);
        
        $date       = $this->sanitizeString($date);
        $date       = new DateTime($date);
        $date       = $date->format("Y-m-d");
        
        
        $sql = "SELECT solat_type FROM solats_wajib WHERE solat_name = ".$solat_id." AND solat_date = '".$date."' ";
        $result =  $this->database->query($sql);
        
        if($result) {
            
            if($result->num_rows > 0) {
                
                $this->status   = "Success";
                $this->sql      = $sql;

                if($row = $result->fetch_object()) {

                    $this->sql          = $sql;
                    $this->solat_type   = $row->solat_type;
                    
                    if($this->solat_type == 3) {
                        $this->html = '<i class="fa fa-times" aria-hidden="true" data-type="'.$this->solat_type.'"></i>';
                    } elseif($this->solat_type == 1) {
                        $this->html = '<i class="fa fa-check" aria-hidden="true" data-type="'.$this->solat_type.'"></i>';
                    }
                }
                
            } else {
                
                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->solat_type   = "";
                $this->html         = '<i class="fa fa-times" aria-hidden="true" data-type="'.$this->solat_type.'"></i>';
            }
            
        
        } else {
            
            $this->status       = "Failure";
            $this->sql          = $sql;
            $this->solat_type   = "";
            $this->html         = '<i class="fa fa-times" aria-hidden="true" data-type="'.$this->solat_type.'"></i>';
        }
        
        return $this->html;
    }
    
    
    public function selectSolatWajibDateByWeek(){
        
        $sql = "SELECT DISTINCT solat_date FROM solats_wajib ORDER BY solat_date DESC LIMIT 7";
        $result =  $this->database->query($sql);
        
        if($result) {
            
            if($result->num_rows > 0) {
                
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->countResult  = $result->num_rows;
                
            } else {
                
                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->countResult  = $result->num_rows;
                $this->result       = "Failed";
            }
            
        
        } else {
            
            $this->status       = "Failure";
            $this->sql          = $sql;
            $this->result       = "Failed";
            
        }
    }
    
    
    public function changeSolatStatus(){
        
        if(isset($this->solat_id) && isset($this->solat_date) && isset($this->solat_type)){
            
            $solat_id   = intval($this->solat_id);
            $solat_type = intval($this->solat_type);
            $solat_date = $this->formatDateV2($this->sanitizeStringV3($this->solat_date));
            
            if($solat_type == 1) {
                $sql = "UPDATE solats_wajib SET solat_type = 3 WHERE solat_date = '".$solat_date."' AND solat_name = ".$solat_id;
            } elseif($solat_type == 3){
                $sql = "UPDATE solats_wajib SET solat_type = 1 WHERE solat_date = '".$solat_date."' AND solat_name = ".$solat_id;
            }
            
            $result =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        } 
    }
    
    
    public function qadaSolat(){
        

        if(isset($this->solat_name) && isset($this->solat_type)) {
            
            $solat_name = intval($this->solat_name);
            $solat_type = intval($this->solat_type);
            
            $date           = new DateTime();
            $dateToday      = $date->format("Y-m-d");
            $dateTimeToday  = $date->format("Y-m-d H:i:s");
            
            $imploded = $this->implodedArray($this->cols);
            
            $sql = "INSERT INTO solats_wajib (".$imploded.") VALUES(".$solat_name.", ".$solat_type.", '".$dateToday."', '".$dateTimeToday."', 1) ";
                    
            $this->sql  = $sql;
            $result     =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        }
    }
    
    
    public function todaySolat(){
        

        if(isset($this->solat_name) && isset($this->solat_type)) {
            
            $solat_name = intval($this->solat_name);
            $solat_type = intval($this->solat_type);
            
            $date           = new DateTime();
            $dateToday      = $date->format("Y-m-d");
            
            $imploded = $this->implodedArray($this->cols);
            
            $sql = "UPDATE solats_wajib SET solat_type = 1 WHERE solat_date = '".$dateToday."' AND solat_name = ".$solat_name;
                    
            $this->sql  = $sql;
            $result     =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        }
    }
    
    
    
    
    

    
    
    
    
} //End of User



?>

