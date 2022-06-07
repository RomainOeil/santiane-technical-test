<?php
    $user = 'root';
    $pass = 'root';

    try {
        $db = new PDO ('mysql:host=localhost;dbname=santiane', 'root', 'root');
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage() . "<br/>";
        die;
    }

    function addVoyage() {
        try {
            global $db;
            $add_voyage = "INSERT INTO voyage (name) VALUES ('$_POST[name]')";
            $db->exec($add_voyage);
            echo 'Travel added! <br/>';
            echo $_POST["name"];
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

?>
<html>
    <head>
        <title>Travel added</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.php" media="screen"/>
    </head>

    <body>
        <div class="etape_added">
            <?php
                addVoyage();

            ?>
            <p><a href="/">Back to main page</a></p>
        </div>
    </body>
</html>