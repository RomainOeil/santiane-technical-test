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

    session_start();

    function getVoyageIdFromName() {
        try {
            $voyage_id = 0;
            global $db;
            $get_voyage = 'SELECT * FROM voyage WHERE name = "' . $_SESSION['voyage_name'] . '"';
            $voyage_id = $db->query($get_voyage)->fetch()['id'];
            return $voyage_id;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function findFirstStop($voyage_name) {

    }

    function voyageFull() {
        global $db;
    }

    function voyagePrint() {
        try {
            global $db;
            $get_voyage = 'SELECT * FROM voyage';
            foreach ($db->query($get_voyage) as $row) {
               $name = $row['name'];
               echo '<form action="etape.php" method="post">';
               echo '<input type="submit" name="name" id="test" value="' . $name . '">';
               echo '</form>';
            }
        } catch (PDOException $e) {
           echo "Erreur :" . $e->getMessage() . "<br/>";
           die;
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