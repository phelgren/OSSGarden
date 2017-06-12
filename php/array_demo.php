<?php
$languages = array("RPG", "Cobol", "Java","PHP","Ruby","Python");
$ac = count($languages);

	for($x = 0; $x < $ac ; $x++) {
		   echo "$languages[$x] is cool\n\r";
}

$characters = array("Gandalf"=>"Wizard","Frodo"=>"Hobbit", "Gimli"=>"Dwarf","Legolas"=>"Elf");

foreach($characters as $x => $x_value) {
	// Name = key and role = value
    echo "Name=" . $x . ", role=" . $x_value;
    echo "\n\r";
}

?>