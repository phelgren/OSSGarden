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

puts " "
puts "READING the file";
puts " "

while  (!record.eof) do
 mytext = record.readline;

 print mytext
end
record.close;
