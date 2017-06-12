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
