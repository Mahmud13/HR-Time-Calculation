## System requirement

A local server(WAMP, XAMPP etc.) with a PHP version > 5.3. 

## Downloading and copying

Download the 'hrm.zip' from Google drive or github, extract the zip folder in such a way to the root directory of localhost(htdocs or www) that the folder 'hrm' is placed just inside the root directory.

## Database setup

Go to 'import' tab of 'phpmyadmin' and import 'database.sql' from  the directory of 'hrm/basicphp/resources/sqlcode/'. If you click the 'GO' button,  a database will be created with a user and some tables. The tables will then be loaded with dump data of all months of 2015. 
If you just want to create the structure of the database and use some other data file, you can upload the file named 'structure.sql' from the same directory.

## Opening the site  

Go to 'http://localhost/hrm/basicphp/' using the address bar of your browser. If the folder 'hrm' is placed in the right directory, the 'index.php' file should show up. And if the the page can establish a connection to the database successfully, you'll find a search tool on the left side of the screen

## User guide 

When the searchtool appears, you can search for a person using his department and his name; or you may just type his pin number in the 'Staff pin' box. If the pin number is valid, the department name and the pin holder's name will show up in their respective boxes. 

Select a year and a month as your interest.

And click the button 'Show leave report'. A table will be produced containg the daily leave update of the employee 

Clicking the 'edit' button below the table will make the some columns of the table editable. 

For the time being, you can switch between holiday and workday, change the present type(e.g. full, half) of a person forcefully, and you can grant medical and casual leave.

By default, the present type (e.g. full, half, late) is taken, if available, from the database instead of calculating from 'inTime', 'outTime' and flag (workday, holiday) of a day. So, if you make any changes to present type, regardless of other data, the present type will remain as you selected.

But, you can tell the app to calculate the present type from 'inTime', 'outTime' and 'flag' by clicking "Reset" button.

After making changes to the table, click the "Update" button. No changes wil be sent to the server and stored there until you click on the "Update" button.

