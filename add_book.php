<?php
// connect to database
require_once('books_connect_vars.php');
require_once('books_appvars.php');

// save database information to variables
$servername = "localhost";
$username = "root";
$password = "@NicolaZoe!1";
$dbname = "db_books";

// Check if data has been submitted
if(isset($_POST['submit']))
{
    // create variables to hold data from form
    $title = filter_input(INPUT_POST, 'title'); 
    $genre = filter_input(INPUT_POST, 'genre'); 
    $short_review = filter_input(INPUT_POST, 'short_review'); 
    $reviewer_name = filter_input(INPUT_POST, 'reviewer_name'); 
    $reviewer_email = filter_input(INPUT_POST, 'reviewer_email');
    $store_link = filter_input(INPUT_POST, 'store_link'); 
    $photo = $_FILES['photo']['name'];
    $phototype = $_FILES['photo']['type'];
    $photosize = $_FILES['photo']['size'];

    // make sure variables aren't empty
    if(!empty($title) && !empty($genre) && !empty($short_review) && !empty($reviewer_name) && !empty($reviewer_email) && !empty($store_link) && !empty($photo)) 
    {            
        // validate photo is acceptable file and size
        if((($phototype == 'image/gif')) || (($phototype == 'image/jpeg')) || (($phototype == 'image/png')) && ($photosize > 0) && ($photosize <= 51200) ) 
        {
            // ensure there are no photo errors
            if($_FILES['photo']['error'] == 0)
            {
                // initialize variable for photo upload path and temporarily store photo in it
                $target = GW_UPLOADPATH.$photo;
                if(move_uploaded_file($_FILES['photo']['tmp_name'], $target))
                {
                    try {
                        require_once('books_database.php');
                        //add the book into table
                        $query = 'INSERT INTO tbl_books
                                        (title, genre, short_review, reviewer_name, reviewer_email, store_link, photo)
                                    VALUES 
                                        (:title, :genre, :short_review, :reviewer_name, :reviewer_email, :store_link, :photo)';
                        $statement = $db->prepare($query);
                        $statement->bindValue(':title', $title);
                        $statement->bindValue(':genre', $genre);
                        $statement->bindValue(':short_review', $short_review);
                        $statement->bindValue(':reviewer_name', $reviewer_name);
                        $statement->bindValue(':reviewer_email', $reviewer_email);
                        $statement->bindValue(':store_link', $store_link);
                        $statement->bindValue(':photo', $photo);
                        $statement->execute();
                        $statement->closeCursor();
                    
                        // Confirm success with the user
                        echo '<p>Thanks for adding your review!</p>';
                        echo '<p><strong>Reviewer Name:</strong> ' . $reviewer_name . '<br />';
                        echo '<strong>Book:</strong> ' . $title . '<br />';
                        echo '<img src="' . GW_UPLOADPATH . $photo . '" alt="Score image" /></p>';
                    
                        $name = "";
                        $title = "";
                        $photo = "";                           

                        echo' <p><a href="manage_books_index.php">View All Reviews</a><p>'; 
                        
                    }
                    catch(PDOException $e) {
                        echo "Error: ". $e->getMessage();
                    }

                    // close database
                    $connection = null;
                } // error uploading photo
                else {
                    echo '<p class="error">Error uploading photo photo</p>';
                }
            } // if there are photo errors  
        } // photo is not acceptable file format or size 
        else {
            echo '<p class="error">The screen shot must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) . ' KB in size.</p>';
        }
        // Try to delete the temporary image file
        @unlink($_FILES['screenshot']['tmp_name']);
    } // variables are empty
    else {
        echo '<p class="error">Please enter all the information</p>';
    }
} // data has not been submitted
else {
    echo 'data not submitted';
}

?>