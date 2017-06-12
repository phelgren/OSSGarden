#!/usr/bin/env ruby
require 'xmlservice'
require 'yaml'

data=YAML::load(File.read("credentials.yml"));

user = data["user"]
password = data["password"]

ActiveXMLService::Base.establish_connection(
  connection: 'ActiveRecord', adapter: 'ibm_db', database: '*LOCAL',
  username: "#{user}", password: "#{password}"
)

wrkactjob = XMLService::I_SH.new("system -i 'WRKACTJOB OUTPUT(*PRINT)'")
wrkactjob.xmlservice
puts wrkactjob.out_xml