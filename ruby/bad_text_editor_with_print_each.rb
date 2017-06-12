record = File.open("/tmp/demo.txt", "w");
p "Enter your text and press <enter>";
print "Enter 'done' when you are done";
$hold_stdout = $stdout;
$stdout = record;
mytext = "";
while (mytext != "done") do
mytext = gets.chomp
puts mytext
end

record.close;
## Turn off writing to file
$stdout = $hold_stdout
# now open it for reading
record = File.open("/tmp/demo.txt", "r");

puts "Reading the file";

record.each {|l| print l};

record.close;
