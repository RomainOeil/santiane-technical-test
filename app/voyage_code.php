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
            $result = $db->exec($add_voyage);
            echo 'Travel added! <br/>';
            echo $_POST["name"];
            return true;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

?>