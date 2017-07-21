<?php
class CoursesValidation{


	public function CheckEmpty($data){
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
		"name" => "^[A-Z]'?[- a-zA-Z]+$",
		"email" => "^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*",
		"address" =>  "^\d+\s[A-z]+\s[A-z]+",
		"city" => "[a-zA-Z]+(?:[ '-][a-zA-Z]+)*",
		"state" => "^(?:(A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|P[AR]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY]))$",
		"zip" => "^\d{5}(?:[-\s]\d{4})?$",
		"phone" => "((\(\d{3}\) ?)|(\d{3}-))?\d{3}-\d{4}"
		);
        
		$MsgAr = array();
		foreach($RegexReq as $rKey => $r){
			$regex = $r;
			$field = $rKey;
			if((preg_match($regex, $data[$field]))){
				$MsgAr[$field] = $field . " is invalid";
			}

		}
		return $MsgAr;
	
	
    }
	
}
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
		

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
	echo "<script>console.log( 'Debug Objects: " . print_r($output) . "' );</script>";
}
?>