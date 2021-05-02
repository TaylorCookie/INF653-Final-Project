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

    //Author query
    $result = $author->read();
    // Get Row Count
    $rowCount = $result->rowCount();

    //Check if any author
    if($rowCount > 0) {
        //initialize array
        $author_arr = array();
        $author_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            //Push to 'data'
            array_push($author_arr['data'], $author_item);
        }

        //Turn to JSON and Output
        echo json_encode($author_arr);

    } else {    
        //No categories
        echo json_encode(
            array('message' => 'No Categories Found.')
        );
    }