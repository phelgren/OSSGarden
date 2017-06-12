def printit(name, address):
	"Doesn't matter what order!"
	print "Name: ", name
	print "Address:", address
	return

myname = "Joe Zablotnik"
myaddress = "123 Main Street"

printit(myname, myaddress)
# Order doesn't matter
printit(myaddress, myname)