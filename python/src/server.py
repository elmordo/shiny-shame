import socket
import threading
from queue import Request, Queue

class Server(threading.Thread):
	'''
	server pro komunikaci s dalsimi castmi projektu

	'''

	MAX_CHUNK=1024
	''' maximalni velikost najednou nacitanych dat ze socketu '''

	_LENGTH_BYTES=4
	''' pocet bytu, ktere v protokolu oznacuji delku zpravy '''

	_host="127.0.0.1"
	''' rozhrani, na kterem se bude poslouchat '''

	_port=53535
	''' cislo portu '''

	_socket=socket.socket
	''' instance socketu '''

	_shutDown=False
	''' prepinac pozadavku vypnuti serveru '''

	def __init__(self):
		'''
		prirpavi instanci

		'''
		super(Server, self).__init__()

		self._socket = socket.socket()

	def run(self):
		'''
		spusti poslouchani serveru

		'''

		# bind adresy a nastaveni socketu
		sck = self._socket

		sck.bind((self._host, self._port))

		# zacatek poslouchani
		sck.listen(5)

		# cekani na prichozi spojeni
		while not self._shutDown:
			conn, addr = sck.accept()

			# prijem zpravy
			msg = self._receive(conn)

			# uzavreni spojeni
			conn.close()

			# zpracovani zpravy a ulozeni do fronty
			request = Request.unserialize(msg)

			# pokud se jedna o pozadavek k vypnuti, pak se nic nebude zarazovat do fornty a server se vypne
			if request.method == "shutdown":
				self._shutDown = True
				continue

			Queue.push(request)

			# spusteni zpracovani fronty
			Queue.processQueue()

		sck.shutdown(socket.SHUT_WR)
		sck.close()

	def _receive(self, s):
		'''
		@param s: socket ze ktereho se bude cist
		@type s: socket.socket
		@return: str
		nacte data z prichoziho spojeni pomoci standardniho protokolu (viz README)

		'''
		# nacteni prvnich 4 bytu oznacujicich delku
		lenData = self._readLength(s, self._LENGTH_BYTES)

		# zpracovani na delku
		length = self.readHeader(lenData);

		# nacteni zpravy
		return self._readLength(s, length)

	def _readLength(self, s, l):
		'''
		@param s: socket, ze ktereho se bude cist
		@type s: socket.socket
		@param l: delka dat
		@type l: int
		@return: String
		nacte data o pozadovane delce

		'''
		# navratova hodnota
		retVal = ''

		# velikost uz nactenych dat a velikost zbyvajicich dat
		read = 0
		rest = l

		while rest > 0:
			# vypocet delky k nacteni
			toRead = min([rest, self.MAX_CHUNK])

			# nacteni dat
			chunk = s.recv(toRead)
			rest -= len(chunk)

			# zapis do navratove hodnoty
			retVal += chunk

		# vraceni dat
		return retVal

	@classmethod
	def readHeader(cls, msg):
		'''
		@param msg: zprava prijata od klienta
		@return: int
		nacte header a vraci delku zpravy

		'''
		length = 0

		for i in range(cls._LENGTH_BYTES):
			length += ord(msg[i]) << (i * 8)

		return length;

	@classmethod
	def writeHeader(cls, data):
		'''
		@param data: data k odeslani
		@return: str
		vytvori hlavicku, kterou pripoji k datum a vraci kompletni zpravu

		'''
		# nacteni a zpracovani delky zpravy
		msgLen = len(data)
		lenData = list()

		for i in range(cls._LENGTH_BYTES):
			lenData.append(chr(msgLen >> (i * 8)))

		header = "".join(lenData)

		return header + data;
