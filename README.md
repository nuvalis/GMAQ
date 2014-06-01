Q->Answer
================

dbwebb.se KMOM710 WIP

Installation
------------------
- Step 1 Clone it
	
	git clone https://github.com/nuvalis/GMAQ.git

- Step 2 Use Composer to install the required packages.
- Step 3 Make sure the webroot/.htaccess file is configured correctly.
- Step 4 Check that app/db folder is existing and is writable. This is where the standard Sqlite file will be generated
- Step 5 Visit {yoururl}/webroot/install and {yoururl}/webroot/setup for the tables and db to be generated. 
- Step 6 Thats it! Start posting and testing the code!

TODO
==========

- [ ] Add Ajax support for VoteController
- [x] Build Up Comments, Answers and Questsions Section
- [ ] Implement Groups
	- [ ] Permissions
	- [ ] Better Auth
- [x] Implement Tagging
- [ ] Clean Up Code


Notes
=====================
Remember to change newActions() cat_id

