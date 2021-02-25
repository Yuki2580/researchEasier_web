from pdfminer.pdfinterp import PDFResourceManager, PDFPageInterpreter
from pdfminer.converter import TextConverter
from pdfminer.layout import LAParams
from pdfminer.pdfpage import PDFPage
from googletrans import Translator
import time
import docx
import os
import sys
 
from io import StringIO
import io
from glob import glob
import urllib as ul



w = sys.argv[1]
#file_list = glob('C:/Users/masam/Desktop/1111.pdf') # PDFファイル取り込み
print(w)
file_list=glob(w)

def convert_pdf_to_txt(path):
    rsrcmgr = PDFResourceManager()
    retstr = io.StringIO()
    codec = 'utf-8'
    laparams = LAParams()
    device = TextConverter(rsrcmgr, retstr, codec=codec, laparams=laparams)
    #fp = open(path, 'rb')
    with open(path, 'rb') as fp:
      interpreter = PDFPageInterpreter(rsrcmgr, device)
      password = ""
      maxpages = 0
      caching = True
      pagenos = set()

      for page in PDFPage.get_pages(fp, pagenos, maxpages=maxpages,
                                    password=password,
                                    caching=caching,
                                    check_extractable=True):
          interpreter.process_page(page)

      text = retstr.getvalue()

      fp.close()
    device.close()
    retstr.close()
    return text

result_list = []
for item in file_list:
    result_txt = convert_pdf_to_txt(item)
    result_list.append(result_txt)

allText = ','.join(result_list) # PDFごとのテキストが配列に格納されているので連結する
before = allText.encode('cp932', "ignore")
allText2 = before.decode('cp932')
#allText = allText.encode('cp932','ignore')
#allText = allText.decode('utf-8')

file = open("C:/MAMP/htdocs/new222/storage/app/txt/pdf.txt", 'w')  #書き込みモードでオープン
file.write(allText2)


transtext = ""
translated_text = ""
with open("C:/MAMP/htdocs/new222/storage/app/txt/pdf.txt", "r", encoding="utf-8", errors='ignore') as convert_text:
    for lina in convert_text:
        transtext += convert_text.readline()
        if len(transtext) >4000:
            print(str(len(transtext)))
            translated_text += Translator().translate(transtext, dest="ja").text
            transtext = ""
            time.sleep(3)
    translated_text += Translator().translate(transtext, dest="ja").text
    print(str(len(transtext)))


doc = docx.Document()
doc.add_paragraph(translated_text)
doc.save("C:/MAMP/htdocs/new222/storage/app/doc/pdf_translated_ja.docx")
#result = ul.request.urlretrieve("","pdf_translated_ja.docx")
#result.close()
#os.remove("pdf.txt")
os.remove("C:/MAMP/htdocs/new222/storage/app/txt/pdf.txt")
os.remove("C:/MAMP/htdocs/new222/storage/app/doc/pdf_translated_ja.docx")
os.remove(w)