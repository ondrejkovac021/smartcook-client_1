<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCook</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative; 
        }
        .recipe-box {
            background-color: #f0f0f0;
            padding: 25px;
            margin: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            width: calc(20% - 30px); 
            text-align: center;
            cursor: pointer; 
            transition: background-color 0.3s ease; 
        }
        .recipe-box:hover {
            background-color: #dcdcdc;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            display: flex;
            margin-left: 100px;
        }
        h2 {
            font-size: 1em;
            display: flex;
            margin-left: 250px;
        }
    </style>
</head>
<body>
    <header>
        <h1>SmartCook</h1><h2>Erasmus</h2>
    </header>
    <?php
    require_once("SmartCookClient.php");

    $request_data = [
        "attributes" => ["id", "name", "author"],
        "filter" => [
            "author" => [],
            "dish_category" => [],
        ]
    ];

    try {
        $client = new SmartCookClient();
        $response = $client->setRequestData($request_data)->sendRequest("recipes")->getResponseData();

        echo "<div style='display: flex; flex-wrap: wrap; justify-content: space-around;'>"; 
        foreach ($response['data'] as $recipe) {
            echo "<div class='recipe-box' onclick='showRecipe(\"{$recipe['name']}\", \"{$recipe['author']}\", \"{$recipe['id']}\")'>"; 
            echo "<h3>" . $recipe['name'] . "</h3>";
            echo "<p>By " . $recipe['author'] . "</p>";
            echo "</div>";
        }
        echo "</div>";

    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>
    
    <script>
        function showRecipe(name, author, id) {
            var url = 'recipe.php?name=' + encodeURIComponent(name) + '&author=' + encodeURIComponent(author) +"&id=" + encodeURIComponent(id);
            window.location.href = url;
        }
    </script>
</body>
</html>
