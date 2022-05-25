<?php
    $user = 'root';
    $pass = 'root';

    try {
        $db = new PDO ('mysql:host=localhost;dbname=santiane', 'root', 'root');
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage() . "<br/>";
        die;
    }

    session_start();

    function getVoyageId() {
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

    $voyage_id = getVoyageId();

    function alreadyPassedIn($column) {
        try {
            global $db, $voyage_id;
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

    function checkValidData() {
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
        if (!alreadyPassedIn('departure')) {
            echo 'Impossible to pass more than 1 time in the same place<br/>';
            $valid = false;
        }
        if (!isset($_POST['arrival'])) {
            echo 'Place of arrival not defined<br/>';
            $valid = false;
        }
        if (!alreadyPassedIn('arrival')) {
            echo 'Impossible to pass more than 1 time in the same place<br/>';
            $valid = false;
        }
        return $valid;
    }

    function addOptionnalField() {
        try {
            global $db, $voyage_id;
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

    function addEtape() {
        try {
            global $db, $voyage_id;
            $success = true;
            $success = checkValidData();
            if (!$success) {
                return $success;
            }
            $add_etape = "INSERT INTO etape (voyage_id, type, number, departure, arrival) VALUES ('$voyage_id', '$_POST[type]', '$_POST[number]', '$_POST[departure]', '$_POST[arrival]')";
            $db->exec($add_etape);
            addOptionnalField();
            return $success;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

?>
<html>
    <body>
        <?php
            $sucess = addEtape();
            if ($sucess == true) {
                echo "Stop added for $_SESSION[voyage_name]<br/>";
            } else {
                echo "Stop not added<br/>";
            }
        ?>
        <p><a href="/etape.php">Back to stops list</a></p>
    </body>
</html>