
Player Stats API
--------

This RESTful API  allows for upload, viewing and deletion of patient information, locations and stats.

Requirements
--------
This library requires:
	- PHP 5.4.0+
	- CodeIgniter 3.0.0 +


Installation
-------

Clone the repo

Run locally:
  - move the folder into your xammpp or wampp folder

alternately:- Follow the codeigniter installation instruction to run on server from part 2 onwards.
https://www.codeigniter.com/user_guide/installation/index.html

Database
--------
Create a new mysql Database
Ensure you update the database configuration settings in config/database.php to match the new database you have created.

Once the database is set-up, migrate the tables by running this in the root folder: 

```
$ php index.php migrate

```

API instructions
--------

This api is meant to be used in conjunction with a react front end - find the repo here:
https://github.com/mcclymont-k/Player-Stats-App
