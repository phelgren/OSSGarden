class Talker:
	import klingon
	'The talker class'
	talkerCount = 0

	def __init__(self, greeting):
		self.greeting=greeting
		Talker.talkerCount+=1

	def speak(self):
		print self.greeting
		return

talker1 = Talker("Hola")
talker2 = Talker("Bonjour")

talker1.klingon.speak_klingon()
talker2.klingon.speak_klingon()

talker1.speak()
talker2.speak()

print Talker.talkerCount
