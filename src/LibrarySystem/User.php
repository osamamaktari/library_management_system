<?php
namespace LibrarySystem;

abstract class User {
    protected $name;
    protected $role;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function getRole() {
        return $this->role;
    }

    abstract public function interactWithLibrary(Library $library);
}
