<?php
/** routes here
 * 
 */
$this->addRoute('/showusers',
                array(
                    'controller'=>'home',
                    'action'=>'dbfetch',
                ));

$this->addRoute('/showuser/:1',
              array(
                    'controller'=>'home',
                    'action'=>'dbfetch',
                    'params'=>array(2)
                ),
                array(
                    '1'=>'/^[0-9]+$/'
                ));
