<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/Authors.php';

    //Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Author Object
    $author = new Author($db);

    //GET ID
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get author
    $author->read_single();

    //Create array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    //Make JSON
    print_r(json_encode($author_arr));