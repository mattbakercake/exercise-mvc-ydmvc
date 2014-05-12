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
                //code for http://localhost/widget or http://localhost/widget/index goes here
            }

            function show() {
                //code for http://localhost/widget/show goes here
            }

        }

3)  Create a model class file in /application/models to match the controller name without a suffix e.g. for the widget controller the corresponding model class file would be Widget.php
The model class inside the file should have the same name as the file and extend the core model class e.g. :

        class Widget extends Model {
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
Having done a bit of reading, and trying to interpret what I found, it seems that an increasingly popular 
method for communicating with a data source is the use of the "Repository Pattern".  This abstracts 
actual platform specific queries away from the model, meaning the model can contain business logic operations 
without containing any code referencing a particular storage platform. The advantages of this are, that it
makes it easier to move the application to a new storage platform e.g. SQLite rather than MySQL, and this
approach makes it easier to unit test the model by sending fake/dummy data to it.  Moving to a new storage
platform would involve editing the repository classes for the models rather than the models themselves.

Each model that requires access to the data source has a class in the repository folder.  This class has the same name as the 
model with the suffix "_Repository".  The respository needs to implement the Repository_Interface class:

        class Widget_Repository implements Repository_Interface {
            public function findAll(){
                //define findAll
            }

            public function findById($id){
                //define findById
            }

            public function create($params) {
                //define create
            }

            public function update(){
                //define update 
            }

            public function destroy($id){
                //define destroy
            }
        }

By implementing the Repository_Interface interface, the repository class has to declare the 5 default
functions shown above.  In addition it can define any further custom functions.

So within the application you may have a view that displays all the widgets.  The controller action
might call the displayAllWidgets() method from the widgets model, which needs to actually retrieve a list of
widgets from the datasource apply any business logic to the list and sent it to the view.  within the 
model you will get the list from the database by calling:

        $this->_repository->findAll();

This method in the repository actually connects to the database using a db connection class, and performs
the actual query:
    
        public function findAll(){
            $this->db->initDB();
            $sql = "SELECT * FROM widgets";
            $query = $this->db->_dbHandle->prepare($sql);
            $query->execute();
            $result = $query->fetchAll();
            $this->db->quitDB();
            return $result;
        }