<!DOCTYPE html>
<html>
<body>

<?php
	$CurDir = getcwd();
	chdir("Slides03Resources");

	//file of state names
	$handle = fopen("StateNames.txt", "r");
	$i = 0;
	$arr = array();
	//get each line in the file, and create an array of abbreviations
	foreach(file("StateAbbr.txt") as $StateAb){
		//${"var".$i} = $StateAb;
		$var = $StateAb;
		//$${"var".$i} =fgets($handle); 
		$$var = fgets($handle);
		//$i++;	
	}
	$arr = get_defined_vars();
	print_r($arr["AR"]);
	print_r($arr["MI"]);
	print_r($arr["WY"]);//prints
	print_r($arr["$AL"]);
	print_r($arr[$AL]);
	var_dump($arr); //prints
	var_dump($arr["AL"]); //returns null for some reason.
	//Something to do with how php stores these values?
	
	
	foreach(get_defined_vars() as $key=>$val)//the only way to print the state variables other than var dump?
{
   print_r($key);
   echo "=>";
   print_r($val);
print "<br>";
}
	
	fclose($handle);
	chdir($CurDir);
?>
</body>
</html>
