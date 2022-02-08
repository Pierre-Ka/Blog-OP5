https://insight.symfony.com/projects/27885bab-72de-4bdc-83e5-c881fa3421d5/analyses/22



########################## Create a PHP Blog  #########################################
**Openclassrooms project 5 - PHP/Symfony application developer path**

# Third party libraries & General Settings

In order to install third party libraries, run `composer install`.

Packages used in this project :
- __Twig__ as template engine
- __Faker__ to generate fake data
- __PhpMailer__ to send emails

To run the project you will need to have : 
- apache
- php 8
- mysql
- phpMyAdmin
- composer

To see the blog code on github : https://github.com/Pierre-Ka/BlogPHP_Project5


## Installation

1. Clone this repository
1. Use "composer update" in the root repository
1. Create a database on your SGDB (MySQL) with the name saved in .env.ini
1. Import the database file project5_blog.sql
1. Open the file .env and insert the following parameters : 
		- dbname : 'mysql: host=localhost;dbname=project5_blog;charset=utf8'(dbname= project5_blog by default, you can choose name for the database)
		- login : Enter your username for access to the mysql databse ("root" by default)
		- password : Enter your password for access to the mysql database ("root" or "" by default)
"Composer" is used as an autoload.

You can now connect to the blog at the following URL and enjoy its features : 
http://localhost/PHP_Blog


### Theme 

To realize the visual part of the blog, I decided to use the theme "Kompleet" available on the website : 
https://templatemag.com/kompleet-free-multipurpose-bootstrap-template/

About "Kompleet", a clean blog theme

Kompleet is by far the most advanced and flexible Bootstrap template ever released. It comes with many awesome demo variations and all these benefits are free of charge. Copyright 2019. Designed by DISTINCTIVE THEMES

The directory assets/ contains all the code from the Bootstrap theme, for the reason that this directory contains only external code, it have been excluded from the SymfonyInsight code review.


#### Sending emails

Emails are sent with `php mailer` _package_. To send emails, create `mail.yaml` configuration file and change parameters in the Mailer\MyMailer file.


##### Copyright and License

Designed and built with all the love in the world by the Bootstrap team with the help of our contributors.
Code licensed MIT, docs CC BY 3.0.
Currently v5.1.3.

###### Organisation

The 'home' field is public  : 
The 'user' field is user's reserved : 
The 'admin' field is admin's reserved : 


	LANDING PAGE :									 
	View : home.home										
frontcontroller->home();  // Send Mail
	--
-----------------------------------------View : home.post 								
	--									frontcontroller->post();	
	--
	--
-----------------------------------------View : home.single							
	--					     			frontcontroller->single(); // Write Comment
	--
	--
-----------------------------------------View : home.category				
	--									frontcontroller->category();	
	--
	--
----------- View : home.sign_in
		frontcontroller->signin();	// Connect
	    frontcontroller->signup();  // Register
	    		--
	    		--
	 -------------   		
	 --
	 --
 View : user.home	
backcontroller->home();   // Delete Own Post
	--
	--
	--
-----------------------------------------View : user.post.add
	--									backcontroller->addpost();  // Add New Post
	--
	--
-----------------------------------------View : user.post.edit
    --                                  backcontroller->editpost();	 
    --								// Edit Own Post, Valid Comment, Delete Comments
    --
-----------------------------------------View : user.edit									--									backcontroller->edituser();   // Edit Own Profil
	--						
	--
View : admin.home
admincontroller->home();    // Delete Post
	--
	--
	--
-----------------------------------------View : admin.manage_category
	--									admincontroller->manageCategory();
	--							// Create, Edit and Delete Categories
	--
-----------------------------------------View : admin.manage_user
										admincontroller->manageUser();
								// Valid or Delete Users

