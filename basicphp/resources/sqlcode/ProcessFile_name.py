
# -*- coding: UTF-8 -*-
import codecs, os
from datetime import datetime

currentPin = 'ERROR'


def getDName(d):
	temp = d.split('(')
	name = temp[0]
	name = name.strip(' ')
	return name

def getDId(d):
	temp = d.split('(')
	if(len(temp)> 1):
		id = temp[1]
	else:
		print("ERROR processing designation")	
	id = id.replace(')','') 
	id = id.strip(' ')
	return id


def trimName(n):
	return n.strip(':')


def setCurrentPin(s, ofile):
	global currentPin

	if (s[:3] == ': :'):
		name = trimName(line2)
		designation = line1
		dName = getDName(designation)
		dName = dName.replace("'","''")
		dId = getDId(designation)
		pin = s[3:]
                depid =dId[-1:];
		ofile.write("('"+pin+"', '"+name+"', '"+dName+ "', '"+dId+ "', '"+ depid+"'),"+os.linesep)

line1 = "ERROR"			
line2 = "ERROR"
firstLineOfFile = True 
secondLineOfFile = True 
outFilename = "makeNameTable.sql"
outFile = codecs.open(outFilename, "w", "utf_8")

initStr = "DROP TABLE IF EXISTS RawNameTable;\nCREATE TABLE RawNameTable\n(\n\t`pin` INT NOT NULL ,\n\t`name` varchar(255)  NOT NULL ,\n\t`des` varchar(255)  NOT NULL ,\n\t`desID` varchar(255)  NOT NULL\n);\nINSERT INTO RawNameTable (pin, name, des, desId)\nVALUES\n" ;
outFile.write(initStr+os.linesep)
for line in open("June16.txt"):

    line = line.strip()
    if(firstLineOfFile):
    	firstLineOfFile = False
    	line1 = line
    elif (secondLineOfFile):
    	secondLineOfFile = False
    	line2 = line
    else:
    	setCurrentPin(line, outFile)
    	line1 = line2
    	line2 = line
    # doPrint(line, outFile);

outFile.seek(-3, os.SEEK_END)
outFile.write(";"+os.linesep)
outFile.close()    

# 
