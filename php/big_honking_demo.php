 <?php
// Comments can be  started this way
# Or that way.

//Variables start with $  sign  - show me the money!
//Statements end with a semi-colon

$greeting = "I'm global";
$x = 5;
$y = 10;

function addme() {
    global $x, $y, $me, $Me;
    $me = "I'm global because I'm declared that way";
    $Me = "I'm different than 'me'";
    $y = $x + $y;
}

function iSay($whatiSay) {
	echo "$whatiSay\r\n";
}

addme();

iSay($greeting);
iSay($y);
iSay($me);
iSay($Me);


?>