def block_local_parameter
  str = "Hello"
  ["Hi. "].each {|str| str << "This is a block-local 'str'!" }
  puts str
end

block_local_parameter