<?php

interface Repository_Interface {
    public function findAll();
    public function findById($id);
    public function create($params);
    public function update();
    public function destroy($id);
}

