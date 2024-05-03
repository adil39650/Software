<?php

// IMPORTANT: WHEN TESTING YOUR CODE, MAKE SURE YOU SEPARATE THE PHP FUNCTIONS FROM THE HTML, BECAUSE IT WILL DISPLAY UNWANTED HTML CODE

// USE THE INCLUDE KEYWORD TO IMPORT FUNCTIONS. EXAMPLE:

// include('adminFunctions.php');

// Then you can test your code.

// ALSO IMPORTANT: IN ORDER FOR THIS TO WORK PROPERLY, YOUR CODE NEEDS TO BE SPLIT INTO SMALL FUNCTIONS (UNITS OF CODE) THIS MAKES IT MUCH EASIER TO TEST AND DEBUG

function assertEquals($input, $expectedOutput) {
    if($input == $expectedOutput) {
        echo 'SUCCESS';
        return TRUE;
    } else {
        echo 'FAILED';
        return FALSE;
    }
}

function assertTrue($input) {
    if($input == TRUE ) {
        echo 'SUCCESS';
        return TRUE;
    } else {
        echo 'FAILED';
        return FALSE;
    }
}

function square($number) {
    return ($number * $number);
}

// A palindrome is a word spelt the same way backwards

/* List of palindromes


Madam
Mom
Noon
Racecar
Radar
Redder
Refer
Repaper
Rotator

Don't nod.
I did, did I?
My gym
*/


function isPalindrome($word) { 
	$reverse = strrev($word);
	
	if($word == $reverse) {
		return TRUE;
	} else {
		return FALSE;
	}
	
	return $reverse;
}




?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        echo '<h1>Square Test</h1>';
         echo assertEquals(4, square(2));
         
         echo '<h1>Palindrome Test</h1>';
         echo assertTrue(isPalindrome('was i aa i saw'));
         
        ?>
    </body>
</html>
