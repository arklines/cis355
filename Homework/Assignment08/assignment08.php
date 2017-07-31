<?php
session_start();
$_SESSION["user"] = "George Corser";
//cookies are client-side data persistence. Not extremely reliable, so they shouldn't be used
//for required information. Stays within http header. Cookies travel in every subsequence http request for a domain, after the browser saves them

//current time+60*60*24 = 1 day from now. I've set expire date to two days from now instead
$expireTime = time()+60*60*48;

//$name = "Username";
//$value = "Daisy";

//Weird that we're writing cookies for username right after saying that we shouldn't use them for required data. Session might be better for login information. When would it be best to use cookies?
//I've seen many pages that state they use cookies, and to please leave them turned on. This seems inherantly risky. Cookies could be maybe used to keep track of recent search results to improve them. Like if a user was searching using keys of "javascript" then searched for "how do I post data" the browser could include "javascript" as part of the search. ie: if results include "javascript" move to top of results. Let's try it.

//This file saves cookies based on last searches. Search results could then be reordered by relevancy to past searches, but this isn't implemented here

 $json = file_get_contents('Books.json');
 $obj = json_decode($json);
 $counter = 0;


	if(!empty($_POST)){
		$search = $_POST["search"];
		if(isset($_COOKIE["searchCounter"])){
			echo "Previous searches found</br>";
			$counter = $_COOKIE["searchCounter"] + 1;
		}
		echo "number of searches: </br>" . $counter;
		
		echo "</br>searching for..." . $search . "</br>";
		 $books = SearchJsonForBook($json, $search);
		 if(!empty($books)){
			 //Reorder search results based on relevance to past search
				echo "Found " . $search . " in books list</br>";
				var_dump($books);
		 }
		
		//Set persistent cookies for this search
		$name = "LastSearch";
		$value = $search;
		setcookie($name, $value, $expireTime);
		setcookie("searchCounter", $counter);
	}



function SearchJsonForBook($json, $searchValue){
	$arr = json_decode($json, true);
	$a=$arr["books"];
	$ResultBook = array();
	$result = array();
	$counter = 0;
	foreach($a as $book){
		foreach($book as $key=>$value){
				if(contains($searchValue, $value)){
					$ResultBook = $book;
				}
			}
		if(!empty($ResultBook)){
			$result[$counter] = $ResultBook;
			$counter +=  1;
		}	
	}
	return $result;
}

function contains($strSearchFor, $ValueSearchIn)
{	
        if (stripos($ValueSearchIn,$strSearchFor) !== false){ return true;}
    return false;
}


 
?>
<html>
<form method="post">
	<input type="text" name="search" placeholder="Search for a book">
	<div class="form-actions">
		<button type="submit" class="btn btn-success">Search</button>
	</div>
</form>
</html>