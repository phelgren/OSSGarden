require 'xmlservice'
require 'yaml'

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

wrksysval = XMLService::I_SH.new("system -i 'WRKSYSVAL SYSVAL(QTIME) OUTPUT(*PRINT)'")
wrksysval.xmlservice
puts wrksysval.out_xml  #nice