<!DOCTYPE html>
<html>
<body>
<!-- this is for assignment 01, to print random paths traversing a 20x20 
note that a path of "******" denotes horizontal traversal for n moves
a path of vertical markers for n marks denotes vertical traversal for n moves
the path can only move either vertically or horizontally-->

<?php
	$arrayIndx = 0;
	//row of 20 - 1, for 0 base index
	$RowSize = 19;
	$arrayOfVal = array();
	$TransversedArrayLRtoUL = array();
	GenerateRandomPathOfSize($RowSize, $arrayOfVal, $arrayIndx);
	
	print "<br> printing normal array<br>";
	Print2dSquareArrayLowerRightToUpperLeft($arrayOfVal, $RowSize);
	print "<br>";
    
	$TransversedArrayLRtoUL = TransversePathLRightToULeft($arrayOfVal, $RowSize);
    
	Print2dSquareArrayUpperRightToLowerLeft($TransversedArrayLRtoUL, $RowSize);
	//Print2ArraysAndFindOverlap($arrayOfVal, $TransversedArrayLRtoUL, "*", 1, 2, 3, $RowSize);
    
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

//gets a row of markers and increments the last x index printed
//NO EOL in this function! if the function is a new row,
//the front of the row is filled with empty dashes
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

//gets vertical row of markers, returns as an array
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
//function Print2ArraysAndFindOverlap($Array1, $Array2, $OriginalMarker, $Marker1, $Marker2, $MarkerOverlap, $size){
	//for ($i=0; $i<=$size; $i++){
	//	for ($j=0; $j<=$size; $j++){
	//		$val1 = $Array1[$i][$j];
	//		$val2 = $Array2[$i][$j];
	//		if ($val1 = $OriginalMarker and $val1 = $OriginalMarker){
	//			print "$MarkerOverlap";
	//		}
	//		elseif($val1 = $OriginalMarker){
	//			print "$Marker1";
	//		}
	//		elseif($val2 = $OriginalMarker){
	//		print "$Marker2";
	//		}
	//		else{
	//			print "-"
	//		}
	//	}
	//	print "<br>";
	//}
}
//transverse an array running from upper left to lower right,
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

//For testing
function TestingOutPrintingArray(){
	//$arr1 = array(1,0,0);
	//$arr2 = array(0,1,0);
	//$arr3 = array(0,0,1);
	//$BigArray = array($arr1, $arr2, $arr3);
	//$TransversedArray = array();
	//
	//print "<br>1. Print original array as is<br>";
	//Print2dSquareArrayUpperLeftToLowerRight($BigArray, 2);
	////print "<br>";
	////Print2dSquareArrayLowerLeftToUpperRight($BigArray, 2);
	////print "<br>";
	////Print2dSquareArrayUpperRightToLowerLeft($BigArray, 2);
	////print "<br>";
	////Print2dSquareArrayLowerLeftToUpperRight($BigArray, 2);
	//print "<br>2. Print original array using function to print in a different format<br>";
	//Print2dSquareArrayLowerRightToUpperLeft($BigArray, 2);
	//
	//$TransversedArray = TransversePathLRightToULeft($BigArray, $size);
	//print "<br>3. Array after being flipped, using Var_dump:<br>";
	//var_dump($TransversedArray);
	//print "<br>4. Attempt to print flipped array, with same call from line 1.<br>";
	//Print2dSquareArrayUpperLeftToLowerRight($TransversedArray, 2);
}
	for ($i=0; $i<=$size; $i++){
		for ($j=0; $j<=$size; $j++){
			$val = $Array[$i][$j];
			print "$val";
		}
		print "<br>";
	}
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