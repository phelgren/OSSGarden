print "Enter your name and I'll guess ";
answer = gets.chomp;
print "Is it Pete? <press enter>";
gets;
case answer
when "Pete"
  puts "See, I was right"
  exit
when "Bob"
  puts "Well, Bob is an OK name"
else
  puts "Hmmm...I wouldn't have guessed your name was #{answer}"
end