<?php
class Person{

	public $myname = "Thorin Oakenshield";
}

$me = new Person();

echo "$me->myname\r\n";

$me->myname = "Gandalf Greyhame";

echo $me->myname;

?>