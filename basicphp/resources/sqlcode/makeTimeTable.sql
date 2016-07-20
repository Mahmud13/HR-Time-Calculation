DROP TABLE IF EXISTS RawTimeTable;
CREATE TABLE RawTimeTable (
	`pin` INT NOT NULL ,
	`date` DATE NOT NULL ,
	 `inTime` TIME NOT NULL ,
	`outTime` TIME);
INSERT INTO RawTimeTable (pin, date, inTime, outTime)
VALUES 
