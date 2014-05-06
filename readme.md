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
    -   DOCUMENT_ROOT - set the document root for the application e.g. /var/htdocs/ydmvc or c:/xampp/htdocs/ydmvc
    -   BASE_URL - set the base url for the site e.g. http://localhost/ydmvc
    -   DB_USERNAME, DB_PASSWORD, DB_NAME, DB_HOST - set the database connection details

With those items set correctly, you should see a very basic introduction page with some styling.

Settings
--------

Application settings are defined in application/ydmvc_core/settings.inc.php

####Displaying Errors
+   display_errors - set to 0 to hide php errors (except fatal errors) or 1 to show.  If errors show, exception errors will be displayed indicating problems such as missing controllers, otherwise a 404 not found error shows.
+   error_reporting - Set the level of errors to be displayed if display_errors is on e.g. E_ERROR, -1 (all) etc

####Paths
+   DOCUMENT_ROOT - absolute path to document root for application
+   BASE_URL - Base url to application

####Default Behaviour
+   DEFAULT_CONTROLLER - Controller to invoke if none is specified in the url e.g. the application root
+   DEFAULT_ACTION - Action to invoke if none is specified in the url e.g. the application root

####Database
+   DB_USERNAME - database username
+   DB_PASSWORD - database password
+   DB_NAME - database name
+   DB_HOST - database host
+   $dsn - Data Source Name (DSN) string for database connection

####Layout Options
+   USE_TEMPLATE - if set to TRUE then includes application/views/template.html in output, which can be used to wrap all content with a common structure such as header/footer/nav etc

Using the Framework
===================

Adding Content
--------------
1) Create a controller class file in /application/controllers to match the desired URL in upper case with a trailing _Controller suffix e.g. if the URL is to be http://localhost/widget, then the class file in /applications/controllers should be Widget_Controller.php.
The controller class inside the file should have the same name as the file and extend the core controller class e.g. :

        class Widget_Controller extends Controller {
            //controller class code here
        }

2) Create an action function inside the controller class.  If you want the action to fire when the URL only calls the controller and not any action implicitly (e.g. http://localhost/widget), then the default action must me named index().
Otherwise, to trigger an implicit action from the URL (e.g. http://localhost/widget/show) the appropriate action function should be created inside the controller class:

        class Widget_Controller extends Controller {
            
            function index() {
                //code for http://localhost/widget or http://localhost/index goes here
            }

            function show() {
                //code for http://localhost/widget/show goes here
            }

        }

3)  Create a model class file in /application/models to match the controller name with a trailing _Model suffix e.g. for the widget controller the corresponding model class file would be Widget_Model.php
The model class inside the file should have the same name as the file and extend the core model class e.g. :

        class Widget_Model extends Model {
            //model class functions here
        }

4) Create a directory for the controller views in /application/views e.g. /application/views/widget.  Create html files within this folder.
The default view is index.html unless another view file is explicitly named.

Notes
-----

####Loading a view
From controller or model `$this->_view->load();` to call the default view (index.html) or `$this->_view->load(viewname.html);` to call a named view

####Calling a model method
From controller `$this->_model->methodname();`

####Sending values to the view
From controller or model `$this->_view->setData('variablename', $data);` where 'variablename' is a string that represents the variable name that will be available in the view, and $data is the data that the variable will contain (e.g. string, array etc).

####Set the title for a view
From controller or model `$this->_view->title = "Title String;"` sets the HTML title tag

####Partials
Partials are html markup files that are useful for segregating reusable view components, or messy looping structures such as dynamic tables, from the main view file.
Create html files for partials in /application/views/partials and call them as appropriate from the view file, model or controller by echoing e.g. `echo $this->partial('partialname.html', $data);`,
where 'partialname.html is the partial file and $data is any data that the partial needs (e.g. a value or an array of values).

####Using values from the URL
Params from the url (e.g. http://localhost/widget/show/123/456) are stored in an array, which can be accessed within the controller using `$this->_params`.
(*Warning: These values will need to be sanitised within the controller or model prior to output to prevent malicious code execution).

Interacting with the Database
-----------------------------
The model class in /application/ydmvc_core contains a few core sql methods, which are very basic at the moment and may need to be augmented.
The insert method uses prepared statements and therefore placeholders for inserting actual data.

To interact with the db in your model:

1)  create an sql statement and set it:

######Read from database

        $sql =  "Select
                  u.id,
                  u.firstname,
                  u.surname,
                  f.name
                From
                  User u
                INNER JOIN
                  Fruit AS f on u.fruit = f.id
                ORDER BY u.id ASC";

        $this->_setSql($sql);

######Create into database

        $sql = "INSERT INTO User 
                (firstname,
                surname,fruit) 
                VALUES 
                (:firstname,
                :surname,:fruit)";

       $this->_setSql($sql)

*note placeholders in insert example

2) Perform query and fetch the result:

######Read from database 
`$result = $this->_getAll();`

######Create into the database 
`$result = $this->_insertAll($data)`, where $data is an associative array with the key in each data-pair corresponding to the placeholder name e.g. array('firstname'='Joe', 'surname'='blogs', 'fruit' = 'banana')