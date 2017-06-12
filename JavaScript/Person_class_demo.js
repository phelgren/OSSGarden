'use strict';

class Person {
constructor(fName, age , address) {
// Properties
this.fullName = fName;
this.age = age;
this.address = address;
}
// Methods
talkAboutMe() {
	return `My name is ${this.fullName} I am a ${this.age}-yr. old programmer that lives on ${this.address}`;
}
}

var me = new Person("Pete Helgren", "33", "19001 Huebner road");

console.log(me.talkAboutMe);