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
    $quotes = new Quote($db);

    //Get key values
    $quotes->authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    $quotes->categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
    $quotes->limitNum = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
    
    //Depending on get parameter set, call corresponding function
    if($quotes->categoryId && $quotes->authorId) {
        //Quote query
        $result = $quotes->read_both($quotes->limitNum);

    } else if($quotes->categoryId) {
        $result = $quotes->read_categoryId($quotes->limitNum);

    } else if($quotes->authorId) {
        $result = $quotes->read_authorId($quotes->limitNum);

    } else {
        //Default Quote query
        $result = $quotes->read($quotes->limitNum);
    }
    
    // Get Row Count
    $rowCount = $result->rowCount();

    //Check if any quotes
    if($rowCount > 0) {
        //initialize array
        $quotes_arr = array();
        $quotes_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'authorId' => $authorId,
                'categoryId' => $categoryId,
                'author' => $author,
                'category' => $category
            );

            //Push to 'data'
            array_push($quotes_arr['data'], $quote_item);
        }

        echo json_encode($quotes_arr);

    } else {    
        //No quotes
        echo json_encode(
            array('message' => 'No Quotes Found.')
        );
    }