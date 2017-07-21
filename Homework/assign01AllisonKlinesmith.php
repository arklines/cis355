<!DOCTYPE html>
<!-- Assign 1-
	 Author: Allison Klinesmith-->
<html>
<body>
<!-- this is for assignment 01, to print random paths traversing a 20x20
note that a path of "******" denotes horizontal traversal for n moves
a path of vertical markers for n marks denotes vertical traversal for n moves
the path can only move either vertically or horizontally-->

<?php
PartOne();
PartTwo();
PartThree();

//Print a random monotonically decreasing path from upper left corner of a 20x20 grid to lower right 
//corner of the grid. Each step of the path can only move down or right, not both.
//Print two paths, one as above, the other from upper right to lower left. 
//The paths should appear on the same grid. Use a marker ‘1’ for path 1, and 
//‘2’ for path 2. Where the paths overlap, use a marker ‘3’.
Function PartOne(){
	$arrayIndx = 0;
	//row of 20 - 1, for 0 base index
	$RowSize = 19;
	$arrayOfVal = array();
	$TransversedArrayURtoLL = array();
	
	//Generate random path
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	Print "<br> Printing Part one, first path: <br><br>";
	Print2dArray($arrayOfVal, $RowSize);
	
	//Generate two other random paths
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	//change flip array
	$TransversedArrayURtoLL = TransversePathURightToLLeft($arrayOfVal, $RowSize);
	//generate second random path
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	print "<br>Printing two random traversals, with marked intersections<br>";
	Print2ArraysAndFindOverlap($arrayOfVal, $TransversedArrayURtoLL, "*", 1, 2, 3, $RowSize);	
}

//Print a random monotonically increasing path from lower left corner of a
// 20x20 grid to upper right corner of the grid by creating an array of 
// 20-character strings. Each step of the path can only move up or right, not both.
//Print two paths, one as above, the other from lower right to upper left. 
//The paths should appear on the same grid. Use a marker ‘1’ for path 1, 
//and ‘2’ for path 2. Where the paths overlap, use a marker ‘3’.
Function PartTwo(){
	$arrayIndx = 0;
	//row of 20 - 1, for 0 base index
	$RowSize = 19;
	$arrayOfVal = array();
	$TransversedArrayLLtoUR = array();
	$TransversedArrayLRtoUL = array();
	
	//Generate random path
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	//change path to start at lower left corner
	$TransversedArrayLLtoUR = TransversePathLLeftToURight($arrayOfVal, $RowSize);
	Print "<br><br> Printing Part Two, first path: <br><br>";
	Print2dArray($TransversedArrayLLtoUR, $RowSize);
	
	//Generate two other random paths
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	//change flip array
	$TransversedArrayLLtoUR = TransversePathLLeftToURight($arrayOfVal, $RowSize);
	//generate second random path
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	$TransversedArrayLRtoUL = TransversePathLRightToULeft($arrayOfVal, $RowSize);
	print "<br>Printing two random traversals, with marked intersections<br>";
	Print2ArraysAndFindOverlap($TransversedArrayLLtoUR, $TransversedArrayLRtoUL, "*", 1, 2, 3, $RowSize);	
}
//Create a variable, $name and assign it a string containing your name.
//Use a for loop to generate an array from $name, following the pattern below.
//Use print_r() to display array contents.
?>
<pre>
<?php
function PartThree(){
	$ArrName = array();
	$name = "Allison Klinesmith";
	$strlen = strlen($name);
	for($i = 0; $i<= $strlen; $i++){
		$ThisKey = substr("$name", 0, $i+1);
		$ArrName["$ThisKey"] = substr("$name", $i, $strlen - $i);
	}
	print_r($ArrName);
}
?>
</pre>
<?php
//Generates the randomized path for a certain sqaured array size.
//Array is passed by ref. 
//Incrementing X or Y is determined by random #
//Number of x steps to take is determined by random #
function GenerateRandomPathOfSize($RowSize, &$arrayOfVal, &$arrayIndx){
    //1-index num of moves
    $RandomXMovesNum = 0;
    //pos -1 = no markers at all
    $xPos = "-1";
    $yPos = "-1";
    $RandDirectionDeterminator = 0;

    //print "Because you cannot move both to the side and across,
    //X must move first!<br>";

    //initialize with x row first
    $RandomXMovesNum = rand(1, $RowSize);
    $arrayOfVal[$arrayIndx] = GetHorizontalMove($xPos, $yPos, "*", $RowSize, $RandomXMovesNum);

    while ($xPos < $RowSize or $yPos < $RowSize){
        $RandDirectionDeterminator = rand(0, 50);
        //only move x pos if x is less than 20.
        //only increment index within the if statements! In case the rand #/
        //pos do not match requirements
        if ($xPos <$RowSize and $RandDirectionDeterminator >= 25){
            $arrayIndx++;
            $RandomXMovesNum = rand(1, $RowSize - $xPos);
            $arrayOfVal[$arrayIndx] =  GetHorizontalMove($xPos, $yPos, "*", $RowSize, $RandomXMovesNum);
        }
        elseif ($yPos <$RowSize and $RandDirectionDeterminator < 25){
            $arrayIndx++;
            $arrayOfVal[$arrayIndx] =  GetVerticalMove($xPos, "*", $RowSize, $yPos);
        }
    }

    //var_dump($arrayOfVal);
}

//prints a full horizontal row, for a certain number of markers.
//Returns array
function GetHorizontalMove(&$currentXPos, &$yPos, $marker, $rowlength, $RandomXMovesNum){
    $arrayOfVal = array();
    $arrayIndex = 0;

    for ($index = 0; $index < $currentXPos; $index++){
        $arrayOfVal[$arrayIndex] = "-";
        $arrayIndex++;
    }
    //print marker for current x position
    if ($currentXPos >= 1){
        $arrayOfVal[$arrayIndex] = "$marker";
        $arrayIndex++;
    }

//		print marker for new x position(s)
    for($index = 0; $index < $RandomXMovesNum; $index++){
        $currentXPos++;
        $arrayOfVal[$arrayIndex] = "$marker";
        $arrayIndex++;
    }

    //print end of row
    for ($index = $currentXPos; $index < $rowlength; $index++){
        $arrayOfVal[$arrayIndex] = "-";
        $arrayIndex++;
    }
    $yPos++;

    return $arrayOfVal;
}

//gets vertical row of markers, returns an arrray
function GetVerticalMove($currentXPos, $marker, $rowlength, &$yPos){
    $arrayOfVal = array();
    $arrayIndex = 0;

    //print up to BEFORE x position
    for ($index = 0; $index < $currentXPos ; $index++){
        $arrayOfVal[$arrayIndex] = "-";
        $arrayIndex++;
    }
//
//		//print marker from current x position
    $arrayOfVal[$arrayIndex] = "$marker";
    $arrayIndex++;

//			//print blank marker until the end of the row
    for ($index = $currentXPos; $index < $rowlength; $index++){
        $arrayOfVal[$arrayIndex] = "-";
        $arrayIndex++;
    }
    $yPos++;
    return $arrayOfVal;
}

//Arrays must be of the same size!
//OriginalMarker is the marker in both original arrays, for comparison
function Print2ArraysAndFindOverlap($Array1, $Array2, $OriginalMarker, $Marker1, $Marker2, $MarkerOverlap, $size){

	print "<br> Both Arrays, with overlap: <br>"; 
	?>
<pre>
<?php
	for ($i=0; $i<=$size; $i++){
    	for ($j=0; $j<=$size; $j++){
    		$val1 = $Array1[$i][$j];
    		$val2 = $Array2[$i][$j];

    		if (($val1 == $OriginalMarker) && ($val2 == $OriginalMarker)){
    			print "$MarkerOverlap";
    		}
    		elseif($val1 == $OriginalMarker){
    			print "$Marker1";
    		}
    		elseif($val2 == $OriginalMarker){
    		print "$Marker2";
    		}
    		else{
    			print "-";
    		}
    	}
    	print "<br>";
    }
	?>
	</pre>
<?php
}

//changes an array running from upper left to lower right,
//to an array running from bottom right to upper left
function TransversePathLRightToULeft($Array, $size){
    $i2 = 0;
    $j2 = 0;
    $MirroredArray = array();
    for ($i=$size; $i>=0; $i--){
        $j2 = 0;
        for ($j=$size; $j>=0; $j--){
            //get array value in transversed value
            $val = $Array[$i][$j];
            //rebuild arrray in transversed order
            $MirroredArray[$i2][$j2] = $val;
            $j2++;
        }
        $i2++;
    }
    return $MirroredArray;
}

//changes an array running from upper left to lower right,
//to an array running from upper right to lower left
function TransversePathURightToLLeft($Array, $size){
    $i2 = 0;
    $j2 = 0;
    $MirroredArray = array();
    for ($i=0; $i<=$size; $i++){
        $j2 = 0;
        for ($j=$size; $j>=0; $j--){
            //get array value in transversed value
            $val = $Array[$i][$j];
            //rebuild arrray in transversed order
            $MirroredArray[$i2][$j2] = $val;
            $j2++;
        }
        $i2++;
    }
    return $MirroredArray;
}

//changes an array running from upper left to lower right,
//to an array running from bottom left to upper right
function TransversePathLLeftToURight($Array, $size){
    $i2 = 0;
    $j2 = 0;
    $MirroredArray = array();
    for ($i=$size; $i>=0; $i--){
        $j2 = 0;
        for ($j=0; $j<=$size; $j++){
            //get array value in transversed value
            $val = $Array[$i][$j];
            //rebuild arrray in transversed order
            $MirroredArray[$i2][$j2] = $val;
            $j2++;
        }
        $i2++;
    }
    return $MirroredArray;
}
//Prints an array from upper left to lower right
function Print2dArray($Array, $size){
	?>
<pre>
<?php
	for ($i=0; $i<=$size; $i++){
		for ($j=0; $j<=$size; $j++){
			$val = $Array[$i][$j];
			print "$val";
		}
		print "<br>";
	}
	?>
	</pre>
	<?php
	
}

//For testing only, not integrated fully into final program
function TestingOutPrintingArray(){
    $arr1 = array(1,0,0);
   $arr2 = array(0,1,0);
   $arr3 = array(0,0,1);
   $BigArray = array($arr1, $arr2, $arr3);
   $TransversedArray = array();

   print "<br>1. Print original array as is<br>";
   //print "<br>";
   //Print2dSquareArrayLowerLeftToUpperRight($BigArray, 2);
   //print "<br>";
   //Print2dSquareArrayUpperRightToLowerLeft($BigArray, 2);
   //print "<br>";
   //Print2dSquareArrayLowerLeftToUpperRight($BigArray, 2);
   print "<br>2. Print original array using function to print in a different format<br>";
   Print2dSquareArrayLowerRightToUpperLeft($BigArray, 2);
}

function Print2dSquareArrayLowerLeftToUpperRight($Array, $size){
//	for ($i=$size; $i>=0; $i--){
//		for ($j=0; $j<=$size; $j++){
//			$val = $Array[$i][$j];
//			print "$val";
//		}
//		print "<br>";
//	}
}
function Print2dSquareArrayUpperRightToLowerLeft($Array, $size){
    //for ($i=0; $i<=$size; $i++){
    //	for ($j=$size; $j>=0; $j--){
    //		$val = $Array[$i][$j];
    //		print "$val";
    //	}
    //	print "<br>";
    //}
}
function Print2dSquareArrayLowerRightToUpperLeft($Array, $size){
    //for ($i=$size; $i>=0; $i--){
    //	for ($j=$size; $j>=0; $j--){
    //		$val = $Array[$i][$j];
    //		print "$val";
    //	}
    //	print "<br>";
    //}
}
?>

</body>
</html>