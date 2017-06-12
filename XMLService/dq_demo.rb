require 'xmlservice'
require 'yaml'

data=YAML::load(File.read("credentials.yml"));

user = data["user"]
password = data["password"]

ActiveXMLService::Base.establish_connection(
  connection: 'ActiveRecord', adapter: 'ibm_db', database: '*LOCAL',
  username: "#{user}", password: "#{password}"
)

    dltdatq = XMLService::I_CMD.new("DLTDTAQ DTAQ(QGPL/TESTDTAQ)")
    # call IBM i
    dltdatq.xmlservice
    # xmlservice error occurred?
    rc = dltdatq.xmlservice_error
    if rc
      puts dltdatq.dump_all()
    end
    
crtq = XMLService::I_CMD.new("CRTDTAQ DTAQ(QGPL/TESTDTAQ) MAXLEN(100)")
    crtq.xmlservice
    if crtq.xmlservice_error
      puts crtq.dump
    end

    qsnddtaq = XMLService::I_PGM.new("QSNDDTAQ", 'QSYS') <<
                       XMLService::I_a.new('queueName', 10, 'TESTDTAQ') <<
                       XMLService::I_a.new('libName', 10, 'QGPL') <<
                       XMLService::I_p.new('lenData', 5 , 0, 100.0) <<
                       XMLService::I_a.new('dataInput', 100, 'test data from Ruby for queue')
    qsnddtaq.xmlservice
    
    if qsnddtaq.xmlservice_error
      puts qsnddtaq.dump_all
    end
 
     qrcvdtaq = XMLService::I_PGM.new("QRCVDTAQ") <<
                      XMLService::I_a.new('queueName',10, 'TESTDTAQ') <<
                      XMLService::I_a.new('libName',10, 'QGPL') <<
                      XMLService::I_p.new('lenData', 5, 0, 100.0) <<
                      XMLService::I_a.new('dataOutput', 100, 'replace stuff here') <<
                      XMLService::I_p.new('waitTime', 5, 0, 20.0)
    qrcvdtaq.xmlservice
    
    if qrcvdtaq.xmlservice_error
      puts qrcvdtaq.dump_all
    else
      response = qrcvdtaq.response.PARM3.dataOutput.to_s
    end
    
    puts response