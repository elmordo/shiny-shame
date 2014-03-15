from PIL import Image
import os

class Method(object):
	'''
	vychozi trida, ze ktere odvozuji dalsi metody

	'''

	_TMP_FOLDER="tmp/"

	def do(self, request):
		'''
		@param request: pozadavek ke zpracovani
		@type request: Request
		provede zpracovani pozadavku

		'''
		raise NotImplementedError()

class ImagePreviewer(Method):
	'''
	slouzi ke tvorbe nahledu
	poradi parametru je
	- data obrazku
	- id obrazku
	- sirka nahledu
	- vyska nahledu

	'''

	def do(self, request):
		# ulozeni obrazku do souboru
		tiffName = self.__class__._TMP_FOLDER + "temp.tiff"
		jpegName = self.__class__._TMP_FOLDER + "conv.jpeg"
		fullName = self.__class__._TMP_FOLDER + "full.jpeg"
		prevName = self.__class__._TMP_FOLDER + "prev.jpeg"

		params = request.params;

		f = open(tiffName, "w")
		f.write(params[0])
		f.close()

		# koverze dat
		os.system("convert %s %s" % (tiffName, jpegName))

		# nacteni obrazku do PILu
		img = Image.open(jpegName)
		

		# nalezeni nejmensiho a nejvetsiho pixelu
		colors = img.getcolors()

		pixelMin = None
		pixelMax = None

		for c in colors:
			if pixelMin is None:
				pixelMin = c[1]
				pixelMin = c[1]
			else:
				# vyhodnoceni dat
				pixelMin = min([pixelMin, c[1]])
				pixelMax = max([pixelMax, c[1]])

		# vypocet skalovaciho koeficientu
		coef = 255.0 / float((pixelMax - pixelMin))

		pImp = img.convert("P")
		palette = pImp.getpalette()

		for c in colors:
			cIndex = c[1]
			pIndex = cIndex * 3;

			colorVal = int((cIndex - pixelMin) * coef)
			
			for i in range(3):
				palette[pIndex + i] = colorVal

		pImp.putpalette(palette)
		
		# vypocet velikosti obrazku a jeho zmenseni
		size = pImp.getbbox()
		width = size[2] - size[0]
		height = size[3] - size[1]

		# vypocet pomeru stran a koeficientu zmenseni
		xRatio = float(width) / float(params[2])
		yRatio = float(height) / float(params[3])

		ratio = max([xRatio, yRatio])

		# vypocet novych hodnot a zapis dat
		newWidth = int(float(width) / ratio)
		newHeight = int(float(height) / ratio)

		# zmenseni obrazku
		preview = pImp.resize((newWidth, newHeight))

		# zapis dat na disk
		pImp.convert("L").save(fullName)
		preview.convert("L").save(prevName)
