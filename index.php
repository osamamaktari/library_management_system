<?php

require "vendor/autoload.php";
use LibrarySystem\Book;
use LibrarySystem\Librarian;
use LibrarySystem\Member;
use LibrarySystem\Library;
use LibrarySystem\EmailNotification;

// Initialize Library
$library = new Library();

// Sample Data Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_book'])) {
        $book = new Book($_POST['title'], $_POST['author']);
        $librarian = new Librarian("Admin");
        $librarian->addBook($book, $library);
    } elseif (isset($_POST['borrow_book'])) {
        $member = new Member("User1");
        $book = $library->searchBooks($_POST['search_term'])[0] ?? null;
        if ($book) $member->borrowBook($book, $library);
    }
}

$currentBooks = $library->searchBooks('');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .book-card {
            transition: all 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-indigo-700">Library Management System</h1>
        
        <!-- Book Management Section -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Add Book Form -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-indigo-600">Add New Book</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Author</label>
                        <input type="text" name="author" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <button type="submit" name="add_book" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        Add Book
                    </button>
                </form>
            </div>

            <!-- Borrow Book Form -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-indigo-600">Borrow Book</h2>
                <form method="POST">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Search Book</label>
                        <input type="text" name="search_term" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <button type="submit" name="borrow_book" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Borrow
                    </button>
                </form>
            </div>
        </div>

        <!-- Book Listing -->
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Available Books</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($currentBooks as $book): ?>
                <div class="book-card bg-white p-4 rounded-lg shadow">
                    <div class="mb-3">
                        <img src="https://placehold.co/600x400?text=<?= urlencode($book->getTitle()) ?>" 
                             alt="<?= htmlspecialchars($book->getTitle()) ?> book cover" 
                             class="w-full h-48 object-cover rounded">
                    </div>
                    <h3 class="font-bold text-lg"><?= htmlspecialchars($book->getTitle()) ?></h3>
                    <p class="text-gray-600">By <?= htmlspecialchars($book->getAuthor()) ?></p>
                    <p class="mt-2">
                        Status: <span class="font-semibold <?= $book->isAvailable() ? 'text-green-600' : 'text-red-600' ?>">
                            <?= $book->isAvailable() ? 'Available' : 'Borrowed' ?>
                        </span>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Notification -->
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['borrow_book'])): ?>
            <div class="fixed bottom-4 right-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded">
                <?php
                $notification = new EmailNotification();
                $notification->send("Book borrowed successfully!");
                ?>
                <p> Notification sent to member</p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Auto-hide notification after 5 seconds
        setTimeout(() => {
            const notification = document.querySelector('.fixed.bottom-4');
            if (notification) notification.style.display = 'none';
        }, 5000);
    </script>
</body>
</html>
