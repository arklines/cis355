<?php
class InputObjects{
	public static function EchoInputGroup($inputKey, $inputValue, $dataItem, $error){
			echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
                     <label class='control-label'>" . trim($inputValue) . "</label>
                  <div class='controls'>
                  <input name='" . $inputKey . "' type='text'  placeholder='" . $inputKey . "' value='" .  (!empty($dataItem)?$dataItem:'') . "'>" .
                              (!empty($error)?"<span class='help-inline'>" .  $error . "</span>" :'') .
                           "</div></div>";
				
	}
		
	public static function EchoSecureInputGroup($inputKey, $inputValue, $error){
		echo "<div class='control-group " . (!empty($error)?'error':'') . "'>
						<label class='control-label'>" . trim($inputValue) . "</label>
						<div class='controls'>
							<input name='" . $inputKey . "' type='password'  placeholder='" . $inputValue . "' value=''>" .
								(!empty($error)?"<span class='help-inline'>" .  $error . "</span>" :'') .
						"</div></div>";
	}
	
	public static function EchoSelectControlGroup($SelectName, $Label, $optionPrompt, $currentSelectedID, $data, $error){
		echo "<div class='control-group " . (!empty($error)?'error':'') . "'>		
		<label for='" . $SelectName . "'>" . $Label  . "</label>
		<select name='" .  $SelectName . "' id='" .  $SelectName . "'>
        <option >" . $optionPrompt . "'</option>";
		foreach($data as $key=>$rec){
		  unset($id, $name);
                  $id = $key;
                  $name = $rec;
				if($rec['id'] === $currentSelectedID){	
				 echo '<option selected="selected" value="'.$id.'">'.$name.'</option>';
				}
				else{
                  echo '<option value="'.$id.'">'.$name.'</option>';
				}
			}
		echo "</select>
		</div>";
	}
	
	public static function EchoReadControlGroup($inputKey, $inputValue, $dataItem){
		 echo "<div class='control-group '>
					<label class='control-label'>". trim($inputValue) ."</label>
                    <div class='controls'>
                      <label class='checkbox'>" . trim($dataItem) . "</label>
                    </div></div>";
	}
}
?>