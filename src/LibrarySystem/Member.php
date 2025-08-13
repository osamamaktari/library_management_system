<?php
namespace LibrarySystem;

class Member extends User {
    public function __construct($name) {
        parent::__construct($name);
        $this->role = 'member';
    }

    public function interactWithLibrary(Library $library) {
        // Members can borrow books
    }

    public function borrowBook(Book $book, Library $library) {
        if ($book->borrow()) {
            // Notify user
        }
    }
}
