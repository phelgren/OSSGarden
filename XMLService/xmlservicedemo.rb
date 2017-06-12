require 'net/https'
require 'uri'
require 'yaml'

data=YAML::load(File.read("credentials.yml"));

# All this stuff from the yml file
user = data["user"]
password = data["password"]
ibmiip = data["ibmiip"]
ibmiport = data["ibmiport"]
connection = "http://" + "#{ibmiip}" + ":" "#{ibmiport}" +"/cgi-bin/xmlcgi.pgm"


@url = "#{connection}"

@ixml  = "<?xml version='1.0'?>\n"
@ixml << "<xmlservice>"
@ixml << "<cmd>CHGLIBL LIBL(XMLSERVICE) CURLIB(XMLSERVICE)</cmd>"
@ixml << "<sh>system dsplibl</sh>"
@ixml << " <pgm name='ZZCALL'>"
@ixml << " <parm><data type='1A'>a</data></parm>"
@ixml << " <parm><data type='1A'>b</data></parm>"
@ixml << " <parm><data type='7p4'>11.1111</data></parm>"
@ixml << " <parm><data type='12p2'>222.22</data></parm>"
@ixml << " <parm>"
@ixml << "  <ds>"
@ixml << "   <data type='1A'>x</data>"
@ixml << "   <data type='1A'>y</data>"
@ixml << "   <data type='7p4'>66.6666</data>"
@ixml << "   <data type='12p2'>77777.77</data>"
@ixml << "  </ds>"
@ixml << " </parm>"
@ixml << "</pgm>"
@ixml << "<sql>"
@ixml << "<query>select * from QIWS.QCUSTCDT where LSTNAM='Jones'</query>"
@ixml << "<fetch block='all'/>"
@ixml << "</sql>"
@ixml << "</xmlservice>"

post_args = { 
  :db2 => '*LOCAL',
  :uid => "#{user}",
  :pwd => "#{password}",
  :ipc => '/tmp/petehtmlonly',
  :ctl => '*sbmjob',
  :xmlin => URI::encode(@ixml),
  :xmlout => '512000'
}

uri = URI(@url)
http = Net::HTTP.new(uri.host, uri.port)
http.use_ssl = true if uri.scheme == 'https'
http.verify_mode = OpenSSL::SSL::VERIFY_NONE
res = http.post(uri, URI.encode_www_form(post_args))

# output
@xmlout = res.body
puts @xmlout