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
            echo 'Journey added! <br/>';
            echo $_POST["name"];
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

?>
<html>
    <head>
        <title>Journey added</title>
        <meta charset="utf-8">
    <body>

        <?php
            addVoyage();

        ?>
        <p><a href="/">Back to main page</a></p>

    </body>
</html>