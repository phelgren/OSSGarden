'use strict';

function sayHello(pName){

	console.log("Hello "+pName);
	// In HTML this would pop up an alert box:
	//alert("Hello "+pName);

}

sayHello("Pete");

var blarg = function(pName){ console.log("Hello " + pName) };

blarg("Pete");


function sayHello(pName){
return "Hello " + pName;
}

console.log(sayHello("Pete"));

(function sayHola(){
	var pName = "Pete";
	console.log("Hola " + pName);
})();
