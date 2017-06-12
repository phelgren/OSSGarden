require 'xmlservice'
require 'yaml'
require 'net/https'

data=YAML::load(File.read("credentials.yml"));

# All this stuff from the yml file
user = data["user"]
password = data["password"]
ibmiip = data["ibmiip"]
ibmiport = data["ibmiport"]
connection = "http://" + "#{ibmiip}" + ":" "#{ibmiport}" +"/cgi-bin/xmlcgi.pgm"

ActiveXMLService::Base.establish_connection(
 connection: "#{connection}",
 username: "#{user}",
 password: "#{password}"
)

pgm = XMLService::I_PGM.new('DEMO1', 'RUBYDEMO') <<
 XMLService::I_a.new('inchara',1,'a') <<
 XMLService::I_p.new('indec1',7,4,11.1111)
 
pgm.xmlservice

pgm.to_xml

puts "inchara: #{pgm.input.PARM0.inchara}"
puts " indec1: #{pgm.input.PARM1.indec1}"