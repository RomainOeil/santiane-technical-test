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

    function PrintEtapeArray() {
        global $etape_array;
        echo '<table>';
        echo '<caption>List of stops for ' . $_SESSION['voyage_name'] . '</caption>';
        echo '<tr>';
        echo '<th>Type of transport</th>';
        echo '<th>Number of the transport</th>';
        echo '<th>Place of departure</th>';
        echo '<th>Place of arrival</th>';
        echo '<th>Number of the seat</th>';
        echo '<th>Gate</th>';
        echo '<th>Number of the baggage</th>';
        echo '</tr>';
        foreach ($etape_array as $etape) {
            echo '<tr>';
            echo '<td>' . $etape['type'] . '</td><td>' . $etape['number'] . '</td><td>'
            . $etape['departure'] . '</td><td>' . $etape['arrival'] . '</td><td>' . $etape['seat'] .
            '</td><td>' . $etape['gate'] . '</td><td>' . $etape['baggage_drop'] . '</td>';
            echo '</tr>';
        }
    }

    function EtapeIsIn($column, $etape_id, $name, $etape_list) {
        try {
            global $db, $voyage_id;
/*            echo 'Column : ' . $column . '<br/>';
            echo 'Name : ' . $name . '<br/>';
            echo 'Etape id : ' . $etape_id . '<br/>';*/
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
                    die;
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
        } catch (PDOException $e) {
            echo "Error :" . $e->getMessage() . "<br/>";
            die;
        }
    }

    function etapePrint() {
        try {
            global $db, $voyage_id;
            if ($voyage_id == 0) {
                echo 'Journey not found<br/>';
                return;
            }
            $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id;
            echo '<table>';
            echo '<caption>List of stops for ' . $_SESSION['voyage_name'] . '</caption>';
            echo '<tr>';
            echo '<th>Type of transport</th>';
            echo '<th>Number of the transport</th>';
            echo '<th>Place of departure</th>';
            echo '<th>Place of arrival</th>';
            echo '<th>Number of the seat</th>';
            echo '<th>Gate</th>';
            echo '<th>Number of the baggage</th>';
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

?>
<html>
    <head>
        <link rel="stylesheet" href="style.php" media="screen"/>
    </head>

    <body>

        <?php
            etapeSort();
        ?>

        <p><br/></p>
        <form method="post" action="etape_added.php">
            <fieldset>
                <legend>Add a stop</legend>
                <p>
                    <label for="type">Type of transport:</label>
                    <input type="text" name="type" id="type" required />
                </p>
                <p>
                    <label for="number">Number of the transport:</label>
                    <input type="text" name="number" id="number" required />
                </p>
                <p>
                    <label for="departure">Place of departure:</label>
                    <input type="text" name="departure" id="departure" required />
                </p>
                <p>
                    <label for="arrival">Place of arrival:</label>
                    <input type="text" name="arrival" id="arrival" required />
                </p>
                <p>
                    <label for="seat">Seat (not required):</label>
                    <input type="text" name="seat" id="seat"/>
                </p>
                <p>
                    <label for="gate">Gate (not required):</label>
                    <input type="text" name="gate" id="gate" />
                </p>
                <p>
                    <label for="baggage_drop">Baggage drop (not required):</label>
                    <input type="number" min="0" name="baggage_drop" id="baggage_drop" value="null" />
                </p>
                <input type="submit" value="Add stop" />
            </fieldset>
        </form>

        <p><a href="/">Back to main page</a></p>

    </body>
</html>