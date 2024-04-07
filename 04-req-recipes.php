<?php
require_once("SmartCookClient.php");

$request_data = [
    "attributes" => ["id", "name", "author"],
    "filter" => [
        "author" => ["Kováč Ondřej"],
        "dish_category" => [],
    ]
];

try {
    $client = new SmartCookClient();
    $response = $client->setRequestData($request_data)->sendRequest("recipes")->getResponseData();

    $html = "<table>";
    $html .= "<tr><th>Recipe</th><th>Author</th></tr>";
    foreach ($response['data'] as $recipe) {
        $html .= "<tr><td>" . $recipe['name'] . "</td><td style='padding-left: 35px;'>" . $recipe['author'] . "</td></tr>";
    }
    $html .= "</table>";

    echo $html;
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
