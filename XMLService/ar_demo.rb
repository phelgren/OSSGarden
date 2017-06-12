#!/usr/bin/env ruby
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

# Create a table in the schema

ActiveRecord::Schema.define do

    create_table :employees do |table|
     	  table.column :emp_id, :integer
        table.column :firstname, :string, limit: 30
        table.column :lastname, :string, limit: 50
        table.column :address, :string, limit: 60
        table.column :city, :string, limit: 40
        table.column :st, :string, limit: 10
        table.column :zip, :string, limit: 9
    end
end

class Employee < ActiveRecord::Base

end

emp = Employee.create(:emp_id => 22,:firstname => 'Chester', :lastname=>'BesterTester',:address=>'123 East Main Street',:city=>'San Antonio',:st=>'Texas',:zip=>'78258')
emp = Employee.create(:emp_id => 44,:firstname => 'Mister', :lastname=>'Master',:address=>'222 East Oak Street',:city=>'San Antonio',:st=>'Texas',:zip=>'78255')
emp = Employee.create(:emp_id => 62,:firstname => 'Peekup', :lastname=>'Andropov',:address=>'321 West Street',:city=>'San Antonio',:st=>'Texas',:zip=>'78253')

## Alternate method
emp = Employee.new

emp.emp_id = 64
emp.firstname = 'Peekup'
emp.lastname='AndPeekupAgain'
emp.address = '999 Baltimore Street'
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
