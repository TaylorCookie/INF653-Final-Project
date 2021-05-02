<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<?php

//Check for get parameters
$getAuthorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
$getCategoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
$getLimitNum = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);

//set limit to 100 if not set by user
if(!isset($getLimitNum)) {
    $getLimitNum = 100;
}

$quotes_api_url = 'http://localhost/final_prep/INF653-Final-Project/api/quotes';

$categories_api_url = 'http://localhost/final_prep/INF653-Final-Project/api/categories';

$authors_api_url = 'http://localhost/final_prep/INF653-Final-Project/api/authors';

//set correct api call
if($getAuthorId && $getCategoryId) {
    $quotes_api_url = $quotes_api_url . '?authorId=' . $getAuthorId . '&categoryId=' . $getCategoryId . '&limit=' . $getLimitNum;
}
else if($getAuthorId) {
    $quotes_api_url = $quotes_api_url .  '?authorId=' . $getAuthorId . '&limit=' . $getLimitNum;
} else if($getCategoryId) {
    $quotes_api_url = $quotes_api_url .  '?categoryId=' . $getCategoryId . '&limit=' . $getLimitNum;
} else {
    $quotes_api_url = $quotes_api_url . '?limit=' . $getLimitNum;
}

// Read JSON files
$json_data = file_get_contents($quotes_api_url);
$json_data_categories = file_get_contents($categories_api_url);
$json_data_authors = file_get_contents($authors_api_url);

// Decode JSON data into PHP arrays
$response_data = json_decode($json_data);
$response_data_categories = json_decode($json_data_categories);
$response_data_authors = json_decode($json_data_authors);

//Pull out data
if(isset($response_data->message)) {
    $quotes_data = null;
} else {
    $quotes_data = $response_data->data;
}
$categories_data = $response_data_categories->data;
$authors_data = $response_data_authors->data;

?>

<!-- Display Options -->
<div class="container">
    <form method="GET">
    <select name="categoryId" id="categorySelect">
        <option value="0">View All Categories</option>
        <?php
            foreach ($categories_data as $categoryId) {
                echo "<option value=" . $categoryId->id . 
                ">"
                . $categoryId->category . "</option>";
            }
        ?>
    </select>
    <select name="authorId" id="authorSelect">
        <option value="0">View All Authors</option>
        <?php
            foreach ($authors_data as $authorId) {
                echo "<option value=" . $authorId->id . ">" . $authorId->author . "</option>";
            }
        ?>
    </select>
    <br />
    <select name="limit" id="limitSelect">
        <option value="0">View All</option>
        <option value="1">View 1</option>
        <option value="5">View 5</option>
        <option value="10">View 10</option>
        <option value="20">View 20</option>

    </select>
    <input type="submit" value="Submit">
    </form>
</div>

<!-- Display Table -->
<table class="table table-striped table-bordered table-hover container-fluid">
    <thead class="table-dark">
        <tr>
            <th scope="col">Quote: </th>
            <th scope="col">Author: </th>
            <th scope="col">Category: </th>
        </tr>
    </thead>

    <tbody>
        <?php
            //if statement that will return nothing if no quotes

            if($quotes_data == null) {
                echo "No quotes to display.";
            } else {
            // Traverse array and display quotes data
            foreach ($quotes_data as $quotes) { 
        ?>
                <tr scope="row">
                    <?php 
                        echo "<td>\"" . $quotes->quote . "\"</td>";
                        echo "<td>" . $quotes->author . "</td>";
                        echo "<td>" . $quotes->category . "</td>";
                    ?>
                </tr>
        <?php }} ?>
    </tbody>
</table>

<?php

?>