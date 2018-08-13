<?php 

class CRUD {
    
    private $database = null;
    private $imploded;
        
    public $sql, $status, $result, $total, $countResult, $table, $data, $id, $condition, $conditionColumn, $lastInsertId;
    
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
    
    private function implodedArray($cols) {
        
        $imploded = implode(", ", $cols);
        return $imploded;
    }
    
    private function explodedArray($cols) {
        
        $exploded = explode(", ", $cols);
        return $exploded;
    }
    
    public function getFileExtension($file_name){
        
        $type = pathinfo($file_name, PATHINFO_EXTENSION);
        $type = strtolower($type);
        return $type;
    }
    
    public function uploadFile($path, $file_information, $prefix, $ext) {
        
        $allowed_files = $this->explodedArray($ext);
        
        $check = $this->getFileExtension($file_information["name"]);
        
        if(in_array($check, $allowed_files)){
            
            $datetime = date("YmdHis");

            $uploaddir = $path;
            $file_name = $prefix.$datetime."_".basename($file_information['name']);
            $uploadfile = $uploaddir.$file_name;
            if(move_uploaded_file($file_information['tmp_name'], $uploadfile)) {

                $data["status"] = true;
                $data["msg"] = "File transfer success";
                $data["filename"] = $file_name;
                
            } else {
                $data["status"] = false;
                $data["msg"] = "File transfer failed";
            }
        } else {
            $data["status"] = false;
            $data["msg"] = "File Format Not Allowed";
        }

        return $data;
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
    
    public function update(){
        
        if(isset($this->table) && !empty($this->table) && isset($this->data) && isset($this->condition)){
            
            $columns = '';
            $x = 1;
            foreach($this->data as $key => $value){
                
                $columns .= $this->sanitizeStringV2($key)." = '".$this->sanitizeStringV2($value)." '";
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