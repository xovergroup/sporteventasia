<?php 

class CRUD {
    
    private $database = null;
    private $imploded;
        
    public $sql, $status, $result, $total, $countResult, $table, $data, $id, $condition, $conditionColumn, $lastInsertId, $find, $columns, $loop;
    
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
    
    public function setCondition($array, $condition){
        
        $cols = $this->explodedArray($condition);
        
        $x = 1;
        $condition = " WHERE ";
        foreach($cols as $col){
            
            foreach($array as $key => $value) {
                if(strpos( $key, $col ) === 0 ) {
                    $condition .= $this->sanitizeStringV2($key) . " = '" . $this->sanitizeStringV2($array[$key])."'";
                }
            }
            if($x < count($cols)) {
                $condition .= " AND ";
            }
            $x++;
        }
        
        return $condition;
    }
    
    public function unsetKeyValue($array, $key){
        
        unset($array[$key]);
        return $array;
        
    }
    
    public function addKeyValue($array, $key, $value){
        
        $array[$key] = $value;
        
        return $array;
    }
    
    public function getValueFromArray($array, $key){
        
        if(array_key_exists($key, $array)) {
            $data = $array[$key];
        }
        
        return $data;
    }
    
    public function getKeyValueRelated($array, $prefix_or_suffix){
        
        $data = array();
        foreach( $array as $key => $value ) {
            if(strpos($key, $prefix_or_suffix) === 0 ) {
                
                $data[$key] = $value;
                
            }
        }
        
        return $data;
    }
    
    public function addDateTime($array, $indexName){
        
        $date               = new DateTime();
        $dateTimeToday      = $date->format("Y-m-d H:i:s");
        $array[$indexName]  = $dateTimeToday;
        
        return $array;
    }
    
    public function implodedArray($cols) {
        
        $imploded = implode(", ", $cols);
        return $imploded;
    }
    
    public function implodedArrayStringMode($cols) {
        
        $imploded = implode("', '", $cols);
        return $imploded;
    }
    
    public function explodedArray($cols) {
        
        $exploded = explode(", ", $cols);
        return $exploded;
    }
    
    public function getKeys($array){
        
        return $this->implodedArray(array_keys($array));
        
        
    }
    
    /* ------------------------------------ MAIN ------------------------------------ */
    public function create(){
        
        if(isset($this->table) && !empty($this->table) && isset($this->data)){
            
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
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->lastInsertId = $this->database->insert_id;
                

            } else {

                $this->status       = "Failed";
                $this->sql          = $sql;
                $this->result       = "Query Failed";

            }
        }
    }
    
    public function createV2(){
        
        if(isset($this->table) && !empty($this->table) && isset($this->data)){
            
            $columns    = $this->implodedArray(array_keys($this->data));
            $values     = $this->implodedArrayStringMode(array_values($this->data));
            
            
            $sql = "INSERT INTO ".$this->table."(".$columns.") VALUES('".$values."')";
            $this->sql          = $sql;
            
            $result = $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->lastInsertId = $this->database->insert_id;
                

            } else {

                $this->status       = "Failed";
                $this->sql          = $sql;
                $this->result       = "Query Failed";

            }
        }
    }
    
    public function createMultiple(){
        
        if(isset($this->table) && !empty($this->table) && isset($this->data)){
            
            $columns = $this->implodedArray(array_keys($this->data));
            
            $count_values = count(array_values($this->data));
            $count_loop = count(array_values($this->data)[0]);
            
            $final_sql = "INSERT INTO ".$this->table."(".$columns.") VALUES "; 
            
            $sql = array();
            for($x = 0; $x < $count_loop; $x++) {
                
                $each_statement = array();
                foreach($this->data as $key => $value){
                    
                    $each_statement[] = "'".$this->sanitizeStringV2($value[$x])."'";
                    
                }
                
                $imploded = implode(", ",$each_statement);
                $sql[] = $imploded;
            }
            
            $format_statement = array();
            foreach($sql as $statement){
                
                $format_statement[] = "(".$statement.")";
                
            }
            
            $final_sql .= implode(", ", $format_statement); 
            
            $result = $this->database->query($final_sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $final_sql;
                $this->result       = $result;
                $this->lastInsertId = $this->database->insert_id;
                

            } else {

                $this->status       = "Failed";
                $this->sql          = $final_sql;
                $this->result       = "Query Failed";

            }
            
        }
          
    }
    
    public function createMultipleV2(){
        
        
        if(isset($this->table) && !empty($this->table) && isset($this->data) && isset($this->loop)){
            
            $columns = $this->getKeys($this->data);
            
            $final_sql = "INSERT INTO ".$this->table."(".$columns.") VALUES "; 
            
            
            $sql = array();
            for($x = 0; $x < $this->loop; $x++) {
                
                $each_statement = array();
                foreach($this->data as $key => $value){
                    
                    $each_statement[] = "'".$this->sanitizeStringV2($value[$x])."'";
                    
                }
                
                $imploded = implode(", ",$each_statement);
                $sql[] = $imploded;
            }
            
            $format_statement = array();
            foreach($sql as $statement){
                
                $format_statement[] = "(".$statement.")";
                
            }
            
            $final_sql .= implode(", ", $format_statement); 
            
            
            $result = $this->database->query($final_sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $final_sql;
                $this->result       = $result;
                $this->lastInsertId = $this->database->insert_id;
                

            } else {

                $this->status       = "Failed";
                $this->sql          = $final_sql;
                $this->result       = "Query Failed";

            }
            
        }
        
        
        
    }
    
    
    public function update(){
        
        if(isset($this->table) && !empty($this->table) && isset($this->data) && isset($this->condition)){
            
            $columns = '';
            $x = 1;
            foreach($this->data as $key => $value){
                
                $columns .= $this->sanitizeStringV2($key)." = '".$this->sanitizeStringV2($value)."'";
                if($x < count($this->data)){
                    $columns .= ", ";
                }
                $x++;
            }
            
            $sql = "UPDATE ".$this->table." SET ".$columns." ".$this->condition;
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
    
    public function updateV2(){
        
        if(isset($this->sql)){
        
            $sql = $this->sql;
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
        
        if(isset($this->table) && !empty($this->table) && isset($this->id) && isset($this->conditionColumn)){
            
            $id = $this->sanitizeStringV2($this->id);
            $column = $this->sanitizeStringV2($this->conditionColumn);
            
            $sql    = "DELETE FROM ".$this->table." WHERE ".$column." = '".$id."'";
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
        
        if(isset($this->sql)){
      
            $result = $this->database->query($this->sql);
            
            $the_object_array   = array();
            if($row = $result->fetch_object()) {

                $the_object_array[] = $row;
                $this->sql = $sql;
            }
            //$result->free();
            
            
            if(!empty($the_object_array)) {
            
                $item = array_shift($the_object_array);
            } else {
                $item = 0;
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
    
    
    public function selectCount(){
        
        if(isset($this->conditionColumn) && isset($this->table) && isset($this->find)) {
            
            $column = $this->sanitizeStringV2($this->conditionColumn);
            $table = $this->sanitizeStringV2($this->table);
            $find = $this->sanitizeStringV2($this->find);
            
            $sql = "SELECT COUNT(".$column.") AS total FROM ".$table." WHERE ".$column." = '".$find."' ";
            $result = $this->database->query($sql);
            
            if($result) {
                
                $this->sql      = $sql;
                $this->result   = $result;
                
                if($row = $result->fetch_object()){
                        
                    $this->status = "Success";
                    $this->total  = $row->total;
                    
                } else {
                    
                    $this->status = "Failure";
                    $this->total  = 0;
                }
                

            } else {

                $this->status   = "Query Failed";
                $this->sql      = $sql;
                $this->result   = "Failed";
                $this->total  = 0;
                
            }
        }
    }
    
    
    
    
    
    
}



?>