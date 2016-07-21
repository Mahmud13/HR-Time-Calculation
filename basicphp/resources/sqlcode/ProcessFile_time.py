
# -*- coding: UTF-8 -*-
import codecs, os
from datetime import datetime

currentPin = 'ERROR'

def doPrint(s, ofile):
	line  = s
	s = s.replace('  ', ' ')
	parts = s.split(' ');
	if len(parts) > 2:		
		t = parts[1].split(':')
		d = parts[0].split('-')
		x = (parts[2] == 'AM') or (parts[2] == 'PM')
		y = len(t) == 3
		z = len(d) == 3

		if (x and y and z):
			date = parts[0]
			timeIn = parts[1]+parts[2].lower()
			if len(parts) > 4:
				if (len(parts[3]) > 1) and (len(parts) < 6):
					timeOut = parts[3][1:]+parts[4].lower()
				else:
					timeOut = parts[4]+parts[5].lower()
			else:
				timeOut = "null"
			date_object = datetime.strptime(date, '%d-%b-%Y')
			dateSql = date_object.strftime('%Y-%m-%d')

			time_object_in = datetime.strptime(timeIn, '%I:%M:%S%p')
			timeInSql = time_object_in.strftime('%H:%M:%S')
			# print(timeIn+" "+time_object_in.strftime('%H:%M:%S'))

			if timeOut != 'null':
				time_object_out = datetime.strptime(timeOut, '%I:%M:%S%p')
				# print(timeOut+" "+time_object_out.strftime('%H:%M:%S'))
				timeOutSql = time_object_out.strftime('%H:%M:%S')
			else:
				timeOutSql = 'null'

			ofile.write("('"+currentPin +"', '"+dateSql+"', '"+timeInSql+"', '"+timeOutSql+"'),"+os.linesep)
def setCurrentPin(s):
	global currentPin
	if (s[:3] == ': :'):
		currentPin = s[3:]


outFilename = "makeTimeTable.sql"
outFile = codecs.open(outFilename, "w", "utf_8")

initStr = "DROP TABLE IF EXISTS RawTimeTable;\nCREATE TABLE RawTimeTable (\n\t`pin` INT NOT NULL ,\n\t`date` DATE NOT NULL ,\n\t `inTime` TIME NOT NULL ,\n\t`outTime` TIME);\nINSERT INTO RawTimeTable (pin, date, inTime, outTime)\nVALUES ";
outFile.write(initStr+os.linesep)
for line in open("June16.txt"):
    line = line.strip()
    setCurrentPin(line)
    doPrint(line, outFile);

outFile.seek(-3, os.SEEK_END)
outFile.write(";"+os.linesep)
outFile.close()    

# 
