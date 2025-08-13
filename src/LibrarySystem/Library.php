<?php
namespace LibrarySystem;

class Library {
    private $books = [];
    private $users = [];

    public function addBook(Book $book) {
        $this->books[] = $book;
    }

    public function removeBook(Book $book) {
        foreach ($this->books as $key => $b) {
            if ($b === $book) {
                unset($this->books[$key]);
                break;
            }
        }
    }

    public function searchBooks($query) {
        return array_filter($this->books, function($book) use ($query) {
            return stripos($book->getTitle(), $query) !== false || stripos($book->getAuthor(), $query) !== false;
        });
    }

    public function addUser (User $user) {
        $this->users[] = $user;
    }
}
