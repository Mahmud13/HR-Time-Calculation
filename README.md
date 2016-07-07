## System requirement

PHP version > 5.3. There was a bug in the date() function which could not correctly calculate the length of month in the previous versions of PHP 

## Downloading and copying

Download the hrm.zip from google drive or github, extract the zip folder to the root directory of localhost(htdocs or www), so that the folder 'hrm' is placed in the root directory.

## Database setup

Go to 'import' tab of 'phpmyadmin' and import 'database.sql' from  the directory of 'hrm/basicphp/resources/sqlcode/'. If you click the 'GO' button,  a database will be created with a user and some tables. The tables will then be loaded with dump data of all months of 2015. 
If you just want to create the structure of the database and use some other data file, you can upload the file named 'structure.sql' from the same directory.

## Opening the site  

Go to 'http://localhost/hrm/basicphp/' using the address bar of your browser. If the folder is placed in the right directory, the 'index.php' file should show up. And if the the page can establish a connection to the database successfully, you'll find a search tool on the left side of the screen

## User guide 

If the searchtool appears, you can search for a person using his department and name; or you may just type his pin number in the 'Staff pin' box. If the pin number is valid, the department name and the pin holder's name will show up in their respective boxes. 

Click the button 'Show leave report'. 

Clicking the 'edit' button below the table will make the some columns of the table editable. 

For the time being, you can switch between holiday and workday, change the present type(e.g. full, half) of a person forcefully, and you can grant medical and casual leave.

By default, the present type (e.g. full, half, late) is taken from the database, if available, instead of calculating from 'inTime' and 'outTime'. So, if you make any change to present type, regardless of other data, the present type will remain as you selected.

But, you can tell the app to calculate the present type from the available data by clicking "Reset" button.

If you want to save any changes you make, click the "Update" button. No changes wil be sent to the server and stored until you press the "Update" button.

