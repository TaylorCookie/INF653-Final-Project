<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/database.php';
    include_once '../../models/Authors.php';

    //Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    //Instantiate Authors Object
    $author = new Author($db);

    //Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $author->id = $data->id;

    //Delete Author
    if($author->delete()) {
        echo json_encode(
            array('message' => "Author Deleted")
        );
    } else {
        echo json_encode(
            array('message' => "Author Not Deleted")
        );
    }