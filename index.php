<?php
require __DIR__ ."vendor/autoload.php";

require 'vendor/autoload.php';

use LibrarySystem\Library;
use LibrarySystem\Librarian;
use LibrarySystem\Member;
use LibrarySystem\Book;
use LibrarySystem\EmailNotification;

$library = new Library();

// Create users
$librarian = new Librarian("Alice");
$member = new Member("Bob");

// Add users to library
$library->addUser ($librarian);
$library->addUser ($member);

// Create books
$book1 = new Book("1984", "George Orwell");
$book2 = new Book("To Kill a Mockingbird", "Harper Lee");

// Add books to library
$librarian->addBook($book1, $library);
$librarian->addBook($book2, $library);

// Search for a book
$searchResults = $library->searchBooks("1984");
foreach ($searchResults as $book) {
    echo "Found: " . $book->getTitle() . " by " . $book->getAuthor() . "\n";
}

// Member borrows a book
$member->borrowBook($book1, $library);

// Send notification
$notification = new EmailNotification();
$notification->send("You have borrowed " . $book1->getTitle());

// Log actions
$librarian->log("Added book: " . $book1->getTitle());
