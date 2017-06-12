def sayit(phrase):
	"This demonstrates scope"
	print phrase
	phrase = "Inside the function "
	print phrase
	return

myphrase = "Outside the function"
sayit()
print myphrase
