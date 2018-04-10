<?php 
require_once('books_database.php');
require('books_appvars.php');

// Get category ID
if (!isset($book_ID)) {
    $book_ID = filter_input(INPUT_GET, 'book_ID',
                                FILTER_VALIDATE_INT);
    if ($book_ID == NULL || $category_id == FALSE) {
        $book_ID = 1;
    }
}

// Get all books

$queryBooks = 'SELECT * FROM tbl_books
                ORDER BY book_ID';
$statement = $db->prepare($queryBooks);
$statement->execute();
$books = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8" />
    <title>My Book App</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <main>
    <header><h1>Book Manager</h1></header> 
        <!-- display a table of products -->
        <h2>Books on Our Site</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Genre</th>
                <th>Short Review</th>
                <th>Reviewer Name</th>
                <th>Reviewer Email</th>
                <th>Link to Store</th>
                <th>Photo</th>
                <th>&nbsp;</th>
            </tr>

            <?php foreach ($books as $book) : ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td><?php echo $book['genre']; ?></td>
                <td><?php echo $book['short_review']; ?></td>
                <td><?php echo $book['reviewer_name']; ?></td>
                <td><?php echo $book['reviewer_email']; ?></td>
                <td><?php echo $book['store_link']; ?></td>
                <td><?php echo '<img src =" '. GW_UPLOADPATH. $book['photo'] . ' "alt="image" />'; ?></td>
                <td><form action="delete_book.php" method="post">
                    <input type="hidden" name="book_id"
                        value="<?php echo $book['book_ID']; ?>">

                    <input type="submit" value="Delete">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="add_book_form.php">Add Book</a><p>
    </main>
</body>
</html>