<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/database.php';
    include_once '../../models/Quotes.php';

    //Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Quote Object
    $quote = new Quote($db);

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    //Set ID to update
    $quote->id = $data->id;

    //Update Quote
    if($quote->delete()) {
        echo json_encode(
            array('message' => "Post Deleted")
        );
    } else {
        echo json_encode(
            array('message' => "Post Not Deleted")
        );
    }