<?php
    $dsn = 'mysql:host=localhost;dbname=db_books';
    $username = 'root';
    $password = '@NicolaZoe!1';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>