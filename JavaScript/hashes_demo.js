var myhash = {'mol':42, 'love':'life', 'bb':1984, 'columbus':1492, 'animal':'zebra'};

console.log(myhash['bb']);
console.log(Object.keys(myhash));

Object.keys(myhash).forEach(function (key) {
    var value = myhash[key];
    // iteration code
    console.log("Item with " + key + " is " +value);
});
