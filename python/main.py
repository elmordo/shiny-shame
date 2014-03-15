from src.queue import Request
from src.standard import ImagePreviewer

# nacteni obrazku
f = open("test.tiff", "r")
data = f.read()
f.close()

# vytvoreni requestu
r = Request()
r.method = "ImagePreviewer"
r.params = [data, 0, 640, 480]

i = ImagePreviewer()
i.do(r)