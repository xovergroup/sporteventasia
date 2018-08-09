<?php 

class CRUD {
    
    private $database = null;
    private $imploded;
        
    public $sql, $status, $result, $total, $countResult, $table, $data, $id, $condition, $identifier;
    
    /* ------------------------------------ MISC ------------------------------------ */
    public function __construct($database) {
        $this->database = $database;
    }
    
    public function sanitizeInt($var) {
        
        $var = $this->database->real_escape_string($var);
        $var = intval($var);
        return $var;
    }
    
    public function sanitizeString($var) {
        
        $var = $this->database->real_escape_string($var);
        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = preg_replace('/\s+/', '', $var);
        return $var;
    }
    
    public function sanitizeStringV2($var) {

        $var = $this->database->real_escape_string($var);
        $var = filter_var($var, FILTER_SANITIZE_STRING);
        $var = htmlentities($var);
        $var = strip_tags($var);

        return $var;
    }
    
    public function sanitizeStringV3($var) {

        $var = $this->database->real_escape_string($var);
        $var = filter_var($var, FILTER_SANITIZE_STRING);
        $var = htmlentities($var);
        $var = strip_tags($var);
        $var = preg_replace('/\s+/', '', $var);

        return $var;
    }
    
    public function unsetAction($array){
        
        unset($array['action']);
        
        return $array;
        
    }
    
    public function unsetKeyValue($array, $key){
        
        unset($array[$key]);
        
        return $array;
        
    }
    
    public function removeFirstKeyValue($array){
        
        $key = key($array);
        unset($array[$key]);
        
        return $array;
    }
    
    public function firstKeyValue($array){
        
        $data["key"] = key($array);
        $data["value"] = reset($array);
        
        return $data;
    }
    
    public function condition($array){
        
        $condition = " WHERE ".$array["key"]." = '".$array["value"]."'";
        return $condition;
    }
    
    public function addDateTime($array, $indexName){
        
        $date               = new DateTime();
        $dateTimeToday      = $date->format("Y-m-d H:i:s");
        $array[$indexName]  = $dateTimeToday;
        
        return $array;
        
    }
    
    private function implodedArray($cols) {
        
        $imploded = implode(", ", $cols);
        return $imploded;
    }
    
    /* ------------------------------------ MAIN ------------------------------------ */
    public function create(){
        
        if(isset($this->table) && !empty($this->table)){
            
            $columns    = $this->implodedArray(array_keys($this->data));
            $values     = '';
            $x          = 1;
            
            foreach($this->data as $value){
                $values .= "'".$this->sanitizeStringV2($value)."'";
                if($x < count($this->data)) {
                    $values .= ', ';
                }
                $x++;
            }
            
            $sql = "INSERT INTO ".$this->table."(".$columns.") VALUES(".$values.")";
            
            $result = $this->database->query($sql);
            
            if($result) {
                $this->status   = "Success";
                $this->sql      = $sql;
                $this->result   = $result;

            } else {

                $this->status       = "Failed";
                $this->sql          = $sql;
                $this->result       = "Query Failed";

            }
            
            
        }
    
        
    }
    
    public function update(){
        
        if(isset($this->table) && !empty($this->table)){
            
            $columns = '';
            $x = 1;
            foreach($this->data as $key => $value){
                
                $columns .= $key." = '".$this->sanitizeStringV2($value)." '";
                if($x < count($this->data)){
                    $columns .= ", ";
                }
                $x++;
            }
            
            $condition = $this->condition($this->identifier);
            
            $sql = "UPDATE ".$this->table." SET ".$columns." ".$condition;

            $result = $this->database->query($sql);

            if($result) {
                $this->status   = "Success";
                $this->sql      = $sql;
                $this->result   = $result;

            } else {

                $this->status       = "Query Failed";
                $this->sql          = $sql;
                $this->result       = "Failed";
            }
            
         
            
        }
    }
    
    public function delete(){
        
        if(isset($this->table) && !empty($this->table)){
            
            
            $column = $this->implodedArray(array_keys($this->data));
            $id     = intval($this->implodedArray(array_values($this->data)));
            
            $sql    = "DELETE FROM ".$this->table." WHERE ".$column." = ".$id;
            $result =  $this->database->query($sql);

            if($result) {

                $this->status   = "Success";
                $this->sql      = $sql;

            } else {

                $this->status   = "Query Failed";
                $this->sql      = $sql;
                
            }
        }
    } 
    
    public function selectOne(){
        
        if(isset($this->id)){
      
            $id = $this->database->real_escape_string(intval($this->id));
            
            $sql = "SELECT * FROM ".$this->table."  WHERE ".$this->col_id." = ".$id;
            $result = $this->database->query($sql);

            $the_object_array   = array();
            if($row = $result->fetch_object()) {

                $the_object_array[] = $row;
            }
            //$result->free();
            
            
            if(!empty($the_object_array)) {
            
                $item = array_shift($the_object_array);
            } else {
                $item = "No data";
            }
        
            return $item;
        } else {
            $this->status = "ID is not set";
        }
        
    }
    
    public function selectAll(){
        
        if(isset($this->sql)){
            
            $sql    = $this->sql;
            $result =  $this->database->query($sql);
        
            if($result) {

                if($result->num_rows > 0) {

                    $this->status       = "Success";
                    $this->sql          = $sql;
                    $this->result       = $result;
                    $this->total        = $result->num_rows;

                } else {

                    $this->status       = "Success";
                    $this->sql          = $sql;
                    $this->result       = "No Data";
                    $this->total        = $result->num_rows;

                }


            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Query Failed";

            }
             
        } else {
            $this->status = "SQL is not set";
        }
    }
    
    
    
    
    
    
    
    
    
}



?>