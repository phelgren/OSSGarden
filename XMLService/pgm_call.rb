require 'xmlservice'
require 'yaml'

data=YAML::load(File.read("credentials.yml"));

user = data["user"]
password = data["password"]

ActiveXMLService::Base.establish_connection(
  connection: 'ActiveRecord', adapter: 'ibm_db', database: '*LOCAL',
  username: "#{user}", password: "#{password}"
)

pgm = XMLService::I_PGM.new('DEMO1', 'RUBYDEMO') <<
 XMLService::I_a.new('inchara',1,'Z') <<
 XMLService::I_p.new('indec1',7,4,11.1111)
 
pgm.xmlservice

puts pgm.to_xml

puts "input parm0: #{pgm.input.PARM0.inchara}"
puts "input parm1: #{pgm.input.PARM1.indec1}"
puts "-------------------------------------------"
puts "output parm0: #{pgm.response.PARM0.inchara}"
puts "output parm1: #{pgm.response.PARM1.indec1}"