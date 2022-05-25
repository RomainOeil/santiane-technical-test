<!DOCTYPE html>
<?php
    $user = 'root';
    $pass = 'root';

    try {
    $db = new PDO ('mysql:host=localhost;dbname=santiane', 'root', 'root');
    } catch (PDOException $e) {
        echo "Erreur :" . $e->getMessage() . "<br/>";
        die;
    }

    function voyagePrint() {
        global $db;
        $get_voyage = 'SELECT * FROM voyage';
        foreach ($db->query($get_voyage) as $row) {
            $name = $row['name'];
            echo '<form action="etape.php" method="post">';
            echo '<input type="submit" name="name" id="test" value="' . $name . '">';
            echo '<br/>';
            echo '</form>';
        }
    }
?>
<html>
    <head>
        <title>Main page - Journeys list</title>
        <meta charset="utf-8">
    </head>

    <body>

        <form method="post" action="voyage.php">
            <fieldset>
                <legend>Add a journey</legend>
                <p>
                    <label for="name">Name of the journey:</label>
                    <input type="text" name="name" id="name" required />
                </p>
                <input type="submit" value="Add journey" />
            </fieldset>
        </form>

        <p><br/>Journeys list:<br/>
        <?php
            voyagePrint();
        ?>
        </p>

    </body>
</html>