<!DOCTYPE html>
<html>
<body>

<?php
print "This text
spans multiple
lines.<br />";

$strangeBoolEx = "0.0";
if ($strangeBoolEx){
	print "this prints if \"0.0\" evalautes as true.<br />";
	}
	$strangeBoolEx = 0.0;
	if ($strangeBoolEx){
	print "this prints if 0.0 evalautes as true.<br />";
	}
	$strangeBoolEx = "";
	if ($strangeBoolEx){
	print "this prints if \"\" evalautes as true.<br />";
	}
	if (!$strangeBoolEx){
	print "this prints if \"\" evalautes as false.<br />";
	}
	$strEx = "String example";
	print "<br>In PHP, any string with no number in it is coerced into 0 when coerced into any integer.<br> Coersion occurs with operator ==, and not with operator ==<br>";
	print "Is \"string example\" evaluated as == to 0 in PHP? ";
	//examples of printing evaluations of php code.
	?> <b> <?php var_dump((bool)($strEx == 0)); ?> </b>
	 <b><?php echo ($strEx == 0);?></b>
	 <?= ($strEx == 0) ?>
	<?php
	print "<br> List can be used to 'unpack' an array into varaibles based on order and
	position. Kind of line a With statement in VB, but automatic<br>";
	$array = array("Sara", "18", "Student", "F");
	list($Name, $age, $profession, $sex) = $array;
	echo $Name;
	print "<br><br><br>";
	//for each line in text file 'books'
	//explode breaks a string down into an array. Implode changes an array into a string
	$CurDir = getcwd();
	chdir("Slides03Resources");
	foreach(file("books.txt") as $book){
		list($bookTitle, $Auth) = explode(",", $book);

		?>
		<p><li>Book title: <?= $bookTitle ?>, Author: <?= $Auth ?></li><p>
		<?php
	}
	chdir("$CurDir");
	
	//Variable variables:
	//if you have $a = "hello"
	// and $$a = "world", then the second line has created a variable whose name
	// is the value stored within $a. Kind of the same logic as swapping between
	//variable values and ptr refs.
	$a = "hello";
	$$a = "world"; //<- variable name is dynamically set to "$hello", contains "world"
	echo "$a ${$a}"; //<- produces the same output as
	echo "$a $hello";
	//In order to use variable variables with arrays, you have to resolve an ambiguity problem. That is, if you write $$a[1] then the parser needs to know if you meant to use $a[1] as a variable, or if you wanted $$a as the variable and then the [1] index from that variable. The syntax for resolving this ambiguity is: ${$a[1]} for the first case and ${$a}[1] for the second.
?>

</body>
</html>