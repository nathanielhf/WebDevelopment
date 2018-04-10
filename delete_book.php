<?php
require_once('books_database.php');

// Set variables with filters
$book_id = filter_input(INPUT_POST, 'book_id', FILTER_VALIDATE_INT);

// Delete product from database
if ($book_id!= false) {
    $query = 'DELETE FROM tbl_books
                WHERE book_ID = :book_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':book_id', $book_id);
    $success = $statement->execute();
    $statement->closeCursor();
}

// Display the book list page
include('manage_books_index.php');

?>