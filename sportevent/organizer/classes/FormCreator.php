<?php 

class FormCreator {
    
    private $database = null;
    private $cols = array("input_event", "input_questionNumber", "input_label", "input_type");
    private $cols2 = array("input_detailEvent", "input_detailQuestionNumber", "input_detailText", "input_detailType");
    private $cols3 = array("input_detailEvent", "input_detailQuestionNumber", "input_detailType");
    private $cols4 = array("submitted_event", "submitted_question", "submitted_questionType", "submitted_dataValue");
    private $table = "inputs";
    private $subTable = "input_detail";
    private $subTable2 = "input_submitted_data";
    private $imploded;

    public $input_id, $input_event, $input_questionNumber, $input_label, $input_type, $input_text, $input_value, $status, $sql, $html, $result, $counter, $countResult;
    
    
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
    
    
    public function createForm(){
        
        if(isset($this->input_event) && isset($this->input_questionNumber) && isset($this->input_label) && isset($this->input_type)){
            
            $event              = intval($this->input_event);
            $question_number    = intval($this->input_questionNumber);
            $label              = $this->database->real_escape_string($this->sanitizeStringV2($this->input_label));
            $type               = intval($this->input_type);
            
            
            $imploded   = $this->implodedArray($this->cols);
            $sql        = "INSERT INTO ".$this->table." (".$imploded.") VALUES(".$event.", ".$question_number.", '".$label."', ".$type.") ";
                    
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
    
    
    public function createSubForm(){
        
        
        if(isset($this->input_event) && isset($this->input_questionNumber) && isset($this->input_text) && isset($this->input_type)){
            
            $event              = intval($this->database->real_escape_string($this->input_event));
            $question_number    = intval($this->database->real_escape_string($this->input_questionNumber));
            $text               = $this->database->real_escape_string($this->sanitizeStringV2($this->input_text));
            $type               = intval($this->database->real_escape_string($this->input_type));
            
            
            $imploded   = $this->implodedArray($this->cols2);
            $sql        = "INSERT INTO ".$this->subTable." (".$imploded.") VALUES(".$event.", ".$question_number.", '".$text."', ".$type.") ";
                    
            $this->sql  = $sql;
            $result     =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->result       = $result;
            } else {

                $this->status       = "Failure";
                $this->result       = "Failed";

            }
        }
    }
    
    
    public function createSubFormNormal(){
        
        
        if(isset($this->input_event) && isset($this->input_questionNumber) && isset($this->input_type)){
            
            $event              = intval($this->database->real_escape_string($this->input_event));
            $question_number    = intval($this->database->real_escape_string($this->input_questionNumber));
            $type               = intval($this->database->real_escape_string($this->input_type));
            
            
            $imploded   = $this->implodedArray($this->cols3);
            $sql        = "INSERT INTO ".$this->subTable." (".$imploded.") VALUES(".$event.", ".$question_number.", ".$type.") ";
                    
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
    
    
    
    public function selectDistinctQuestions(){
        
        if(isset($this->input_event)){
            
            $event = intval($this->database->real_escape_string($this->input_event));
            
            $sql = "SELECT DISTINCT inputs.input_questionNumber FROM inputs WHERE input_event = ".$event;
            
            $result =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->countResult  = $result->num_rows;
            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        }
    }
    
    
    public function selectInput(){
        
        if(isset($this->input_event)){
            
            $event = intval($this->database->real_escape_string($this->input_event));
            
            $sql = "SELECT * FROM inputs WHERE input_event = ".$event." ORDER BY inputs.input_questionNumber ASC";
            
            $result =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->countResult  = $result->num_rows;
            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        }
    }
        
        
        
    public function selectInputDetail($question, $type){
        
        $question   = intval($question);
        $type       = intval($type);
        
        if(isset($this->input_event) && $question != 0 && $type != 0){
            
            $event = intval($this->database->real_escape_string($this->input_event));
            
            $sql = "SELECT * FROM input_detail WHERE input_detail.input_detailEvent = ".$event." AND input_detail.input_detailQuestionNumber = ".$question." AND input_detailType = ".$type." ORDER BY `input_detail`.`input_detailId` ASC";
            
            $result =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->sql          = $sql;
                $this->result       = $result;
                $this->countResult  = $result->num_rows;
            } else {

                $this->status       = "Failure";
                $this->sql          = $sql;
                $this->result       = "Failed";

            }
        }
    }
    
    
    public function insertDynamicFormData(){
        
        
        if(isset($this->input_event) && isset($this->input_questionNumber) && isset($this->input_type) && isset($this->input_value)){
            
            $event              = intval($this->database->real_escape_string($this->input_event));
            $question_number    = intval($this->database->real_escape_string($this->input_questionNumber));
            $type               = intval($this->database->real_escape_string($this->input_type));
            $value              = $this->database->real_escape_string($this->input_value);
            
            
            $imploded   = $this->implodedArray($this->cols4);
            $sql        = "INSERT INTO ".$this->subTable2." (".$imploded.") VALUES(".$event.", ".$question_number.", ".$type.", '".$value."') ";
                    
            $this->sql  = $sql;
            $result     =  $this->database->query($sql);
            
            if($result) {
                $this->status       = "Success";
                $this->result       = $result;
            } else {

                $this->status       = "Failure";
                $this->result       = "Failed";

            }
        }
    }
   
        
        
    
}






?>