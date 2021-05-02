<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/Quotes.php';

    //Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Quote Object
    $quote = new Quote($db);

    //GET ID
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get quote
    $quote->read_single();

    //Create array
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'authorId' => $quote->authorId,
        'categoryId' => $quote->categoryId,
        'author' => $quote->author,
        'category' => $quote->category
    );

    //Make JSON
    print_r(json_encode($quote_arr));