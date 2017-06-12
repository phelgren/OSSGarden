var person1 = new Object;
var person2 = {};

person1.name = "Joe Zablotnik";
person1.age = 40;
person1.address = "123 main street";

person2.name = "Pikofp Andropoff";
person2.age = 30;
person2.address = "444 Gorby street";

function spillthebeans(p){
	
	console.log(p.name+ ":");
	console.log(p.name + " age is " + p.age);
	console.log("and " + p.name + " lives at " + p.address);
	console.log("");
}

spillthebeans(person1);
spillthebeans(person2);
