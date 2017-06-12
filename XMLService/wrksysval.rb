require 'xmlservice'
require 'yaml'

data=YAML::load(File.read("credentials.yml"));

user = data["user"]
password = data["password"]

ActiveXMLService::Base.establish_connection(
  connection: 'ActiveRecord', adapter: 'ibm_db', database: '*LOCAL',
  username: "#{user}", password: "#{password}"
)

wrksysval = XMLService::I_SH.new("system -i 'WRKSYSVAL SYSVAL(QTIME) OUTPUT(*PRINT)'")
wrksysval.xmlservice
puts wrksysval.out_xml
   