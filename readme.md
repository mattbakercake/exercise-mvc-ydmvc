Introduction
============

+ What is this? A simple MVC style framework boilerplate that can decode urls to serve a request
+ Why bother? This was primarily a personal learning exercise to understand MVC/separation of concerns and also to delve a bit deeper into Object Oriented PHP practice
+ What should I do with it?  Probably ignore it! It could probably be developed a little further to provide a structured environment for serving a small website/application (I had this in mind at one point), but time may be better invested in learning a mainstream framework

Getting Started
===============
I had forgotten a about this little learning project and assumed it was complete poop, but actually it is quite interesting...needs a better name though!

The framework has some very rudimentary demo functionality included, to demonstrate a few concepts and help me remember what it can do! 

Installation
------------

+   Clone the GIT repository to your working directory
+   Create a database (MySQL only tested and used) and upload the test tables/data in the test.sql file
+   Set the following setting in the application/ydmvc_core/settings.inc.php file:
    -   SERVER_ROOT - set the document root for the application e.g. /var/htdocs/ydmvc or c:/xampp/htdocs/ydmvc
    -   SITE_ROOT - set the base url for the site e.g. http://localhost/ydmvc
    -   DB_USERNAME, DB_PASSWORD, DB_NAME, DB_HOST - set the database connection details

With those items set correctly, you should see a very basic introduction page with some styling.