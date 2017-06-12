record = File.open("/tmp/demo", "w");

$hold_stdout = $stdout;
$stdout = record;
$stderr = $stdout;

puts "We wrote to a file with Ruby!";
divzero = 10/0;

record.close
