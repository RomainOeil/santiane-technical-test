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