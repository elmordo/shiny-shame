import copy
import base64
import threading
import datetime
import dircache
import os

class Queue(threading.Thread):
	'''
	fronta pozadavku
	take zabezpecuje zpracovani fronty

	'''

	_IN_PROCESS=False
	''' indikuje, zda se zpracovava fronta '''

	_INSTANCE=None
	''' singleton instance '''

	_LOCK=threading.Lock()
	''' zamek pro zapis a cteni soubrou '''

	_QUEUE_PATH="queue/"
	''' adresar s frontou '''

	_QUEUE_POSTFIX=".qr"
	''' pripona souboru s frontou '''

	def __new__(cls, *args, **kwargs):
		'''
		zabezpecuje existenci jedine instance

		'''
		# kontrola instance
		if (self._INSTANCE == None):
			# vytvoreni nove instance
			self._INSTANCE = super(Queue, self).__new__(*args, **kwargs)

		return cls._INSTANCE

	def run(self):
		'''
		provadi zpracovani fronty

		'''
		self.__class__._IN_PROCESS = True

		# dokud je neco ve fronte, bude se zpracovavat
		request = self.__class__.pop()

		while request is not None:

			# nacteni dalsiho pozadavku
			request = self.__class__.pop()

		# ukonceni behu procesu
		self.__class__._IN_PROCESS = False

	@classmethod
	def isInProcess(cls):
		'''
		@return: bool
		vraci True, pokud se zpracovava fronta
		jinak vraci False

		'''
		return cls._IN_PROCESS

	@classmethod
	def pop(cls):
		'''
		@return: Request
		nacte dalsi pozadavek z fronty a vraci ho
		pokud zadny pozadavek ve fronte uz neni, pak vraci None

		'''
		# zamknuti zamku
		cls._LOCK.acquire();

		# nacteni cesty
		files = dircache.listdir(cls._QUEUE_PATH)
		postLength = len(cls._QUEUE_POSTFIX)
		filePath = None

		for currFile in files:
			# kontrola postfixu
			if currFile[-postLength:] == cls._QUEUE_POSTFIX:
				# jedna se o spravny soubor
				filePath = currFile
				break

		# kontrola zda byl nalezen soubor
		if filePath is None:
			return None

		# nacteni a smazani souboru
		fileName = cls._QUEUE_PATH + filePath
		retVal = Request.readFromFile(fileName)
		os.remove(fileName)

		# odemknuti zamku
		cls._LOCK.release()

		return retVal

	@classmethod
	def processQueue(cls):
		'''
		spusti zpracovani fronty

		'''
		# pokud je zpracovani aktivni, pak se nic nedeje


	@classmethod
	def push(cls, request):
		'''
		@param request: pozadavek pro zarazeni do fronty
		@type request: Request
		zaradi pozadavek do fronty (do souboru)

		'''
		# zamknuti zamku
		cls._LOCK.acquire()

		# vygenerovani jmena souboru a ulozeni dat
		fileName = cls._QUEUE_PATH + datetime.datetime.now().__str__() + "." + cls._QUEUE_POSTFIX
		request.saveToFile(fileName)

		# uvolneni zamku
		cls._LOCK.release()

class Request(object):
	'''
	trida obsahujici informace o pozadavku
	dale umoznuje serializaci a deserializaci a ukladani nebo nacitani ze souboru

	'''

	_method=""
	''' jmeno metody, ktera se ma volat '''

	_params=list()
	''' seznam parametru '''

	def __init__(self):
		'''
		pripravi instanci

		'''
		self._params = list()

	def saveToFile(self, fileName):
		'''
		@param fileName: jmeno souboru
		@type fileName: str
		ulozi serializovany objekt do souboru

		'''
		# serializace dat
		data = self.serialize()

		# zapis dat do souboru
		f = open(fileName, 'w')
		f.write(data)
		f.close()

	def serialize(self):
		'''
		@return: str
		serializuje pozadavek do retezce a vraci tento retezec

		'''
		# serializace parametru
		params = [ self._method ]

		for param in self._params:
			params.append(base64.encode(self._params.__str__()))

		# slouceni do jednoho retezce
		return "\n".join(params)

	@classmethod
	def readFromFile(cls, fileName):
		'''
		@param fileName: jmeno souboru
		@type fileName: str
		@return: Request
		nacte a deserializuje pozadavek ze souboru

		'''
		# nacteni dat
		f = open(fileName, 'r')
		data = f.read()
		f.close()

		# deserializace
		return cls.unserialize(data)

	@classmethod
	def unserialize(cls, data):
		'''
		@param data: data k deserializaci
		@type data: str
		@return Request
		deserializuje data  z retezce a vraci novy request

		'''
		# rozlozeni dat
		splitted = data.split("\n")

		# separace jmena metody
		methodName = splitted.pop(0)

		# dekodovani parametru
		params = list()

		for item in splitted:
			params.append(base64.decode(item))

		# vytvoreni navratove hodnoty a nastaveni dat
		retVal = Request()
		retval._method = methodName
		retVal._params = params

		return retVal

	@property
	def method(self):
	    return self._method
	@method.setter
	def method(self, value):
	    self._method = value

	@property
	def params(self):
	    return copy.copy(self._params)
	@params.setter
	def params(self, value):
	    self._params = copy.copy(value)
	
	