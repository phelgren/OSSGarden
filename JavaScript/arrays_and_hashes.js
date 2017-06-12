var myarray = [42, 'life', 1984, 1492, 'zebra'];

console.log(myarray[2]);

var mynewarray = new Array(42, 'life', 1984, 1492, 'zebra');

console.log(mynewarray[3]);

myarray.pop()
myarray.push('antelope');

fLen = myarray.length;
for (i = 0; i < fLen; i++) {
   console.log("Item at " + i + " is " + myarray[i] );
}
