def printit(*stuffin):
	"Doesn't matter what order!"
	if(len(stuffin)>=1):
		print "Name: ", stuffin[0]
	if(len(stuffin)==2):
		print "Address:", stuffin[1]
	return

myname = "Joe Zablotnik"
myaddress = "123 Main Street"

printit(myname, myaddress)
# Order doesn't matter
printit(myaddress)