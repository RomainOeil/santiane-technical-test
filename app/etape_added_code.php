<?php

    require("etape_code.php");

    $user = 'root';
    $pass = 'root';

    try {
        $db = new PDO ('mysql:host=localhost;dbname=santiane', 'root', 'root');
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage() . "<br/>";
        die;
    }

    if (!headers_sent()) {
        session_start();
    }

    $voyage_id = getVoyageIdFromSession();

    function alreadyPassedIn($column, $voyage_id) {
        try {
            global $db;
            if ($voyage_id == 0) {
                echo 'Journey not found<br/>';
                return;
            }
            $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id;
            foreach ($db->query($get_etape) as $row) {
                if ($row[$column] == $_POST[$column]) {
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function checkValidData($voyage_id) {
        $valid = true;
        if (!isset($_POST['type'])) {
            echo 'Type of transport not defined<br/>';
            $valid = false;
        }
        if (!isset($_POST['number'])) {
            echo 'Number of the transport not defined<br/>';
            $valid = false;
        }
        if (!isset($_POST['departure'])) {
            echo 'Place of departure<br/>';
            $valid = false;
        }
        if (!alreadyPassedIn('departure', $voyage_id)) {
            echo 'Impossible to pass more than 1 time in the same place<br/>';
            $valid = false;
        }
        if (!isset($_POST['arrival'])) {
            echo 'Place of arrival not defined<br/>';
            $valid = false;
        }
        if (!alreadyPassedIn('arrival', $voyage_id)) {
            echo 'Impossible to pass more than 1 time in the same place<br/>';
            $valid = false;
        }
        return $valid;
    }

    function addOptionnalField($voyage_id) {
        try {
            global $db;
            $id = 0;
            $get_etape = "SELECT * FROM etape WHERE voyage_id = $voyage_id";
            foreach ($db->query($get_etape) as $row) {
                if ($row['voyage_id'] == $voyage_id && $row['departure'] == $_POST['departure']) {
                    $id = $row['id'];
                }
            }
            if (isset($_POST['seat'])) {
                $seat = $_POST['seat'];
                $add_seat = "UPDATE etape SET seat = '$seat' WHERE id = $id";
                $db->exec($add_seat);
            }
            if (isset($_POST['gate'])) {
                $gate = $_POST['gate'];
                $add_gate = "UPDATE etape SET gate = '$gate' WHERE id = $id";
                $db->exec($add_gate);
            }
            if (isset($_POST['baggage_drop']) && $_POST['baggage_drop'] != 0) {
                $drop = $_POST['baggage_drop'];
                $add_drop = "UPDATE etape SET baggage_drop = '$drop' WHERE id = $id";
                $db->exec($add_drop);
            }
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function addEtape($voyage_id) {
        try {
            global $db;
            $success = true;
            $success = checkValidData($voyage_id);
            if (!$success) {
                return $success;
            }
            $add_etape = "INSERT INTO etape (voyage_id, type, number, departure, arrival) VALUES ('$voyage_id', '$_POST[type]', '$_POST[number]', '$_POST[departure]', '$_POST[arrival]')";
            $db->exec($add_etape);
            addOptionnalField($voyage_id);
            return $success;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

?>