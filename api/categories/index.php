<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/database.php';
    include_once '../../models/Category.php';

    //Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Category Object
    $category = new Category($db);

    //Category query
    $result = $category->read();
    // Get Row Count
    $rowCount = $result->rowCount();

    //Check if any category
    if($rowCount > 0) {
        //initialize array
        $category_arr = array();
        $category_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            //Push to 'data'
            array_push($category_arr['data'], $category_item);
        }

        //Turn to JSON and Output
        echo json_encode($category_arr);

    } else {    
        //No categories
        echo json_encode(
            array('message' => 'No Categories Found.')
        );
    }