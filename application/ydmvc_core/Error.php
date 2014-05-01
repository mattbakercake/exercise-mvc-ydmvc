<?php

/**
 * The Error class contains custom error handling functions for the framework
 *
 * @category Core
 * @version 0.1
 * @since 12-03-2013
 * @author Matt Baker <dev@mikesierra.net>
 */
class Error {
  
    /**
     * Sends 404 page not found headers to the browser and displays the contents
     * of a 404 page template if it exists (application/views/404.html), otherwise
     * generic text is shown
     */
    public function _throw404() {
        $_404file = DOCUMENT_ROOT . '/application/views/404.html';//location of 404 template
        //send header
        header("HTTP/1.0 404 Not Found");
        //display 404 template file if exists else basic message
        if (file_exists($_404file)) {
            ob_start();
            include $_404file;
            $output = ob_get_contents();
            ob_end_clean();
            echo $output;
        } else {
            echo "<h1>404 - Page not found</h1><p>The page could not be found</p>";
        }
        exit;
    }
}

?>
