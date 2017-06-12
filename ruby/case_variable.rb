print "Enter something ";
a = gets.chomp;
begin;
a = Float(a);

rescue Exception => e;
  puts e.message;

end;
case a
when 1..5
  "It's between 1 and 5"
when 42
  "It's the meaning of life!"
when String
  "You passed a string"
else
  "You gave me #{a} -- I have no idea what to do with that."
end