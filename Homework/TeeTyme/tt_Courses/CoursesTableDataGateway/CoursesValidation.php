<?php
class CoursesValidation{
	public function CheckEmpty($data){
		$msg = array();
        //check that required fields are filled
        $requiredFields = array(
            "name",
            "email",
            "address",
            "city",
            "state",
            "zip",
            "phone"
        );
        foreach($requiredFields as $field){
            if ($data[$field] ===""){
                $msg[$field] = " value is required.";
            }
        }
		return $msg;
	}
	
    public function ValidateCourse($data){
	//	//each required column as a regex
		$RegexReq = array(
		"name" => "/^[A-Z]'?[- a-zA-Z]+$/",
		"email" => "/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD",
		"address" =>  "/^\d+\s[A-z]+\s[A-z]+/",
		"city" => "/[a-zA-Z]+(?:[ '-][a-zA-Z]+)*/",
		"state" => "/^(?:(A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|P[AR]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY]))$/",
		"zip" => "/^\d{5}(?:[-\s]\d{4})?$/",
		"phone" => "/((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}/"
		);
		$MsgAr = array();	
		foreach($RegexReq as $rKey => $r){
			$regex = $r;
			$field = $rKey;
			if(preg_match($regex, $data[$field]) === 0){
				$MsgAr[$field] = $field . " is invalid";
			}
		}
		return $MsgAr;
    }
	public function ValidateNumerics($data){
		
		//Set up an array of regexes for all of the stroe values; they must be numeric
		$parArr = array();
		for($i=0;$i<18;$i++){
			if($i<10){
			$ParKey = "par0" . $i;}
			else{
				$ParKey = "par" . $i;
			}
			$parArr[$ParKey] = '/^[0-9]*$/'; 
		}
		//check numerics
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