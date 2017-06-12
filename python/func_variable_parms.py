def printit(**stuffin):
	"Number of parms doesn't matter!"
	if 'name' in stuffin:
		print "Name: ", stuffin['name']
	if 'address' in stuffin:
		print "Address:", stuffin['address']

	return

myname = "Joe Zablotnik"
myaddress = "123 Main Street"

printit(name = myname, address = myaddress)
# one or two, it doesn't matter to the function
printit(address = myaddress)