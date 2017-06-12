require 'active_record'
require 'yaml'

data=YAML::load(File.read("credentials.yml"));

user = data["user"]
password = data["password"]

ActiveRecord::Base.establish_connection(
  :adapter => 'ibm_db',
  :username=> "#{user}",
  :password =>  "#{password}",
  :database => '*LOCAL',
  :schema => 'empDemo'
  )

# Get a table without creating a schema

class Employee < ActiveRecord::Base
  self.table_name = "employees"
  
end

## Alternate method
emp = Employee.new

emp.emp_id = 500
emp.firstname = 'Dave'
emp.lastname='HAL9000'
emp.address = '123 Bubba Street'
emp.city='San Antonio'
emp.st='Texas'
emp.zip='78251'

emp.save


puts '-------------------------------'
puts Employee.find_by_id(1).lastname
puts Employee.find_by_emp_id(62).lastname
puts Employee.find_by_firstname('Peekup').lastname
puts Employee.find_by_lastname('Master').firstname
puts '-------------------------------'
Employee.find_each do |empl|
puts empl.firstname << ' ' << empl.lastname
end
puts '-------------------------------'
Employee.where("firstname = 'Peekup'").find_each do |empl|
puts empl.firstname << ' ' << empl.lastname
end
puts '-------------------------------'
#ActiveRecord::Migration.drop_table(:employees)
