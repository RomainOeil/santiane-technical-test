<?php

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

    if (isset($_POST['name'])) {
        $_SESSION['voyage_name'] = $_POST['name'];
    }

    function getVoyageIdFromSession() {
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

    $voyage_id = getVoyageIdFromSession();

    $etape_array = array();

    function GetPDORowsCount($command) {
        global $db;
        $result = $db->query($command);
        $count = $result->fetchColumn();
        return $count;
    }

    function deleteSelectedEtape($selected_id) {
        global $db;
        foreach ($selected_id as $id) {
            $delete_etape = 'DELETE FROM etape WHERE id = ' . $id;
            $db->query($delete_etape);
        }
        header("Refresh:0");
    }

    function PrintEtapeArray() {
        global $etape_array;
        echo '<form method="post" id="etape_tab" action="etape.php">';
        echo '<table>';
        echo '<caption class="table_title">List of stops for ' . $_SESSION['voyage_name'] . ' sorted from first to last stop</caption>';
        echo '<tr>';
        echo '<th>Transport type</th>';
        echo '<th>Transport number</th>';
        echo '<th>Place of departure</th>';
        echo '<th>Place of arrival</th>';
        echo '<th>Seat number</th>';
        echo '<th>Gate</th>';
        echo '<th>Bags number</th>';
        echo '<th>Delete?</th>';
        echo '</tr>';
        foreach ($etape_array as $etape) {
            echo '<tr>';
            echo '<td>' . $etape['type'] . '</td><td>' . $etape['number'] . '</td><td>'
            . $etape['departure'] . '</td><td>' . $etape['arrival'] . '</td><td>' . $etape['seat'] .
            '</td><td>' . $etape['gate'] . '</td><td>' . $etape['baggage_drop'] . '</td><td>' . '<input type="checkbox" name="delete_etape[]" value="' . $etape['id'] . '">' . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>';
        echo '<input type="submit" name="delete_selected" value="Delete selected etapes" class="delete">';
        echo '</form>';
        if (isset($_POST['delete_etape'])) {
            deleteSelectedEtape($_POST['delete_etape']);
        }
    }

    function EtapeIsIn($column, $etape_id, $name, $etape_list) {
        try {
            global $db, $voyage_id;
            $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id;
            $loop_list = $db->query($get_etape);
            $found = false;
            foreach ($loop_list as $etape) {
                if ($etape[$column] == $name) {
                    if ($found) {
                        echo 'The '. $column . ' is already in the database <br/>';
                    } else {
                        $found = true;
                    }
                }
            }
            if ($found) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function getFirstEtape($etape_list) {
        try {
            global $etape_array;
            $first_etape = [];
            $first_found = false;
            foreach ($etape_list as $row) {
                $is_found = EtapeIsIn('arrival', $row['id'], $row['departure'], $etape_list);
                if (!$is_found && !$first_found) {
                    $first_found = true;
                    $first_etape = $row;
                } else if (!$is_found && $first_found) {
                    echo 'First stop already found<br/>';
                    echo 'Please verify that the travel is correct<br/>';
                    return false;
                }
            }
            $etape_array[] = $first_etape;
            return $first_etape;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function etapeSort() {
        try {
            global $db, $voyage_id, $etape_array;
            $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id;
            $etape_list = $db->query($get_etape);
            $first_etape = getFirstEtape($etape_list);
            if (!$first_etape) {
                return false;
            }
            $current_arrival = $first_etape['arrival'];
            $lenght = GetPDORowsCount('SELECT count(*) FROM etape WHERE voyage_id = ' . $voyage_id);
            for ($l = 1; $l < $lenght; $l++) {
                $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id . ' AND departure = "' . $current_arrival . '"';
                $etape_list = $db->query($get_etape);
                foreach ($etape_list as $row) {
                   $etape_array[] = $row;
                }
                $current_arrival = $row['arrival'];
            }
            PrintEtapeArray();
            return true;
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function etapePrint() {
        try {
            global $db, $voyage_id;
            if ($voyage_id == 0) {
                echo 'Travel not found<br/>';
                return;
            }
            $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id;
            echo '<table>';
            echo '<caption>List of stops for ' . $_SESSION['voyage_name'] . ' unsorted</caption>';
            echo '<tr>';
            echo '<th>Type of transport</th>';
            echo '<th>Transport number</th>';
            echo '<th>Place of departure</th>';
            echo '<th>Place of arrival</th>';
            echo '<th>Seat number</th>';
            echo '<th>Gate</th>';
            echo '<th>Baggage number</th>';
            echo '</tr>';
            foreach ($db->query($get_etape) as $row) {
                echo '<tr>';
                echo '<td>' . $row['type'] . '</td><td>' . $row['number'] . '</td><td>'
                . $row['departure'] . '</td><td>' . $row['arrival'] . '</td><td>' . $row['seat'] .
                '</td><td>' . $row['gate'] . '</td><td>' . $row['baggage_drop'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function purposeDeleteJourney($voyage_id) {
        global $db;
        echo '<form method="post">';
        echo '<input type="submit" name="delete_journey" value="Delete travel" class="delete">';
        echo '</form>';
        if (isset($_POST['delete_journey'])) {
            echo '<form method="post">';
            echo '<input type="submit" name="confirm_delete_journey" value="Confirm delete travel" class="delete" classe="align">';
            echo '</form>';
        }
        if (isset($_POST['confirm_delete_journey'])){
            $delete_voyage = 'DELETE FROM voyage WHERE id = ' . $voyage_id;
            $delete_etape = 'DELETE FROM etape WHERE voyage_id = ' . $voyage_id;
            $db->query($delete_voyage);
            $db->query($delete_etape);
            $voyage_id = 0;
            if(!headers_sent()) {
                header('Location: index.php');
            }
            return true;
        }
        return false;
    }

?>
