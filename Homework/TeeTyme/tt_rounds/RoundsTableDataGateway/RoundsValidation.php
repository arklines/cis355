<?php
class RoundsValidation{
	public function CheckEmpty($data){
		$msg = array();
        //check that required fields are filled
        $requiredFields = array(
            "person_id",
            "course_id",
            "teedate", 
            "teetime", 
        );
        foreach($requiredFields as $field){
            if ($data[$field] ===""){
                $msg[$field] = " value is required.";
            }
        }
		return $msg;
	}
	
    public function ValidateRounds($data){
		//each required column as a regex
		$RegexReq = array(
			"teedate"=>'/(0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/',
			"teetime"=>'/^(00|0[0-9]|[0-9]|1[012]):[0-5][0-9]?:[0-5][0-9] ? ((a|p)m|(A|P)M)$/',
			"person_id"=>"/^[1-9]*$/",
			"course_id"=>"/^[1-9]*$/"
		);
		$MsgAr = array();	
		foreach($RegexReq as $rKey => $r){
			$regex = $r;
			$field = $rKey;
			if(preg_match($regex, $data[$field]) === 0){
				$MsgAr[$field] = $field . " is invalid";
			}
		}
		//The above iteration across keys is fine, but CheckDate is a more solid check of
				//validity, so it is used in the case that checking the data fails
				list($mth,$day,$yr)=explode("-",$data["teedate"], 3);
				if(checkdate($mth,$day,$yr)){
					unset($MsgAr["teedate"]);
				}
		return $MsgAr;
    }
	public function ValidateNumerics($data){
		$MsgAr = array();
		//Set up an array of regexes for all of the stroe values; they must be numeric
		$parArr = array();
		for($i=0;$i<18;$i++){
			if($i<10){
			$ParKey = "stroke0" . $i;}
			else{
				$ParKey = "strokes" . $i;
			}
			$parArr[$ParKey] = '/^[0-9]*$/'; 
		}
		//check numerics, but only if the item is set
		foreach($parArr as $rKey=>$r){
			$regex = $r;
			$field = $rKey;
			if(isset($data[$field])){
				if(preg_match($regex, $data[$field]) === 0){
					$MsgAr[$field] = $field . " is invalid";
				}
			}
		}
		return $MsgAr;
	}
}

?>