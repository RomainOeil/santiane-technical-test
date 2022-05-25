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

    function etapeSort() {
        try {
            global $db, $voyage_id;
            $get_etape = 'SELECT * FROM etape WHERE voyage_id = ' . $voyage_id;
            $etape_list = $db->query($get_etape);
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
            Echo '<th>Number of the baggage</th>';
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
            etapePrint();
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