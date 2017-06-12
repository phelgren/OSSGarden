var meaningoflife = "He who dies with the most toys wins";
console.log(meaningoflife);

meaningoflife = 42;
console.log(meaningoflife);

function mylife(){
stuff = 5;
while(stuff>=0){
console.log("Keep using stuff until it is all gone. Stuff is now " +stuff);
stuff--;
}
console.log("My stuff is all gone!");
}

meaningoflife = mylife;

meaningoflife();