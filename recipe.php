<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .recipe-container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.2em;
        }
        .back-link-container {
            position: absolute;
            top:20px;
            left: 20px;
        }
        .back-link {
            background-color: #f0f0f0;
            padding: 30px;
            margin: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            width: calc(20% - 20px);
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .back-link:hover {
            background-color: #dcdcdc;
        }
        .back-link a {
            color: black;
            text-decoration: none;
            margin-left: 10px; 
        }
    </style>
</head>
<body>
    <div class="recipe-container">
        <?php
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $author = isset($_GET['author']) ? $_GET['author'] : '';

        if (!empty($name) && !empty($author)) {
            echo "<h1>$name</h1>";
            echo "<p>By $author</p>";
        } else {
            echo "<p>Recipe not found.</p>";
        }
        ?>
    </div>
    <div class="back-link-container">
        <div class="back-link" onclick="goBack()">
            Back to Recipes
            <a href="#" style="color: black; text-decoration: none;">🡸</a>
        </div>
    </div>

    <ul>
        <?php
        require_once("SmartCookClient.php");    

        try {
            $data=(new SmartCookClient)
                ->setRequestData(["recipe_id" => $_GET["id"]])
                ->sendRequest("recipe")
                ->getResponseData();
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
        
        $obtiznost= array(1=>" low difficulty"," medium difficulty", "high difficulty");
        echo "<li>".$obtiznost[$data["data"]["difficulty"]]."</li>";
        echo "<li>".$data["data"]["duration"]." min</li>";
        $cena= array(1=>" cheap"," medium", " expensive");
        echo "<li>".$cena[$data["data"]["price"]]."</li>";
        echo "<li>".$data["data"]["description"]."</li>";
        echo "<li>".$data["data"]["country"]."</li>";
        echo "dish category: <ul>";
        foreach($data["data"]["dish_category"] as $i){echo "<li>".$i."</li>";}
        echo "</ul>recipe category:<ul>";
        foreach($data["data"]["recipe_category"] as $i){echo "<li>".$i."</li>";}
        echo "</ul>tolerance: <ul>";
        foreach($data["data"]["tolerance"] as $i){echo "<li>".$i."</li>";}
        echo "</ul>ingredients: <ul>";
        foreach($data["data"]["ingredient"] as $i){echo "<li>".$i["name"]."</li>";}
        echo "</ul>";
        ?>
    </ul>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
