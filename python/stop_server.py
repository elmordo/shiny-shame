from src.queue import Request
from src.server import Server
import socket

# vytvoreni a serializace zpravy
r = Request()
r.method = "shutdown"
msg = r.serialize()

# hlavicka zpravy
msgData = Server.writeHeader(msg)

# odeslani pozadavku na server
s = socket.socket()

s.connect(("127.0.0.1", 53535))
s.send(msgData)
s.close()