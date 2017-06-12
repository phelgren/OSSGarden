'use strict';

class Employee {
	constructor(hireDate, monthlySalary) {
	this.hireDate = hireDate;
	this.monthlySalary = monthlySalary;
	}
getMonthlySalary() {
	return `I make ${this.monthlySalary} each month.`
  	}
}

class Person extends Employee{
constructor(fName, age , address, hireDate, monthlySalary) {
	// Call the contructor for Employee
	super(hireDate, monthlySalary);
// Person Properties
this.fullName = fName;
this.age = age;
this.address = address;
}
// Methods
talkAboutMe() {
	return `My name is ${this.fullName} I am a ${this.age}-yr. old programmer that lives on ${this.address}`;
}
}

var me = new Person("Pete Helgren", "33", "19001 Huebner road", "09/01/2012", 1.99);

console.log(me.talkAboutMe());
console.log(me.getMonthlySalary());