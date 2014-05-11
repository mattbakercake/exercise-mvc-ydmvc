<?php
/**
 * The Repsitory_Interface class is an interface that defines methods that 
 * all repository classes must implement
 * 
 * @category Repository
 * @version 0.1
 * @since 09-05-2014
 * @author Matt Baker <dev@mikesierra.net>
 */
interface Repository_Interface {
    public function findAll();
    public function findById($id);
    public function create($params);
    public function update();
    public function destroy($id);
}

