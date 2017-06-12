# the new way - create an array
animals = Array.new
animals[0]='cat'
animals[1]='dog'
animals[2]='horse'
animals[3]='pig'

animals.each {|animal| puts animal}

creatures = Hash.new
creatures['cat']='unlikeable'
creatures['dog']='best friend'
creatures['horse']='giddy up'
creatures['pig']='squeal!'

creatures.each {|creature,appeal| puts "#{creature} is #{appeal}" }

puts "different approach"

h = {:cat=>'unfriendly',:dog=>'best friend',:horse=>'giddy up',:pig=>'squeal'}

h.each {|a,b| puts "#{a} is #{b}"}

puts creatures['pig']
puts h[:cat]
