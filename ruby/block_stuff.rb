def say_stuff

yield("Pete","ruby")

end

say_stuff do |name, lang|

puts "#{name} loves to program #{lang}"

end