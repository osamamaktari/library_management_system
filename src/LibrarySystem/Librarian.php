<?php
namespace LibrarySystem;

class Librarian extends User {
    public function __construct($name) {
        parent::__construct($name);
        $this->role = 'librarian';
    }

    public function interactWithLibrary(Library $library) {
        // Librarian can add/remove books
    }

    public function addBook(Book $book, Library $library) {
        $library->addBook($book);
    }

    public function removeBook(Book $book, Library $library) {
        $library->removeBook($book);
    }
}
