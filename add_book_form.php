<?php

require_once('books_database.php');
require_once('books_appvars.php');
$query = 'SELECT * FROM tbl_books
            ORDER BY book_ID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
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
    <header><h1>My Book App</h1></header>

    <main>
        <h2>Add Book Review</h2>
        <form enctype="multipart/form-data" method="post" action="add_book.php" id="add_book_form">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo GW_MAXFILESIZE; ?>" />
            <label for="title">Book Title</label>
            <input type="text" name="title" /><br/>
            
            <label for="genre">Book Genre</label>
            <input type="text" name="genre" /><br/>
            
            <label for="short_review">Short Book Review</label>
            <input type="text" name="short_review" /><br/>
            
            <label for="reviewer_name">Name of person submitting review</label>
            <input type="text" name="reviewer_name" /><br/>
            
            <label for="reviewer_email">Email of person submitting book review</label>
            <input type="text" name="reviewer_email" /><br/>
            
            <label for="store_link">Link to online store where book can be purchased</label>
            <input type="url" name="store_link" /><br/>

            <label for="photo">Book Photo:</label>
            <input type="file" id="photo" name="photo" /><br/>

            <input type="submit" value="Submit Review" name="submit"/>
        </form>

        <p><a href="manage_books_index.php">View Book List</a></p>
    </main>
</body>
</html>