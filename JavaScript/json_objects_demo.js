var myjsondata = [
{"firstname": "John","lastname": "Doe","age": 50,"eyecolor": "blue"},
{"firstname": "Pete","lastname": "Helgren","age": 56,"eyecolor": "green"},
{"firstname": "Bubba","lastname": "Gump","age": 32,"eyecolor": "brown"},
{"firstname": "Frank","lastname": "Zappa","age": 56,"eyecolor": "gray"},
{"firstname": "Ima","lastname": "Minion","age": 18,"eyecolor": "black"},
{"firstname": "Ima","lastname": "Hacker","age": 15,"eyecolor": "crossed"}
];

fLen = myjsondata.length;

for (i = 0; i < fLen; i++) {
	// we know, just by looking at the data, that we object properties to iterate through as well
	// so get the object and walk the properties
	var myhash = myjsondata[i];
	Object.keys(myhash).forEach(function (key) { 
    var value = myhash[key];
    // iteration code
    console.log("Item " + i + " with " + key + " is " +value);
	});

   //console.log("Item at " + i + " is " + new Object(myjsondata[i]).keys );
}
