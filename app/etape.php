<?php

    require("etape_code.php");

?>
<html>
    <head>
        <link rel="stylesheet" href="style.php" media="screen"/>
    </head>

    <body>

        <div class="etape_list">
            <?php
                if (!etapeSort()) {
                    etapePrint();
                }
            ?>
        </div>

        <p><br/></p>
        <div class="form">
            <form method="post" action="etape_added.php" class="add_etape">
                <fieldset>
                    <legend>Add a stop</legend>
                    <p>
                        <label for="type" class="label_background">Transport type:</label>
                        <input type="text" name="type" id="type" class="align" class="required" required />
                    </p>
                    <p>
                        <label for="number" class="label_background">Transport number:</label>
                        <input type="text" name="number" id="number" class="align" class="required" required />
                    </p>
                    <p>
                        <label for="departure" class="label_background">Place of departure:</label>
                        <input type="text" name="departure" id="departure" class="align" class="required" required />
                    </p>
                    <p>
                        <label for="arrival" class="label_background">Place of arrival:</label>
                        <input type="text" name="arrival" id="arrival" class="align" class="required" required />
                    </p>
                    <p>
                        <label for="seat" class="label_background">Seat (not required):</label>
                        <input type="text" name="seat" id="seat" class="align" />
                    </p>
                    <p>
                        <label for="gate" class="label_background">Gate (not required):</label>
                        <input type="text" name="gate" id="gate" class="align" />
                    </p>
                    <p>
                        <label for="baggage_drop" class="label_background">Bags number (not required):</label>
                        <input type="number" min="0" name="baggage_drop" id="baggage_drop" value="null" class="align" />
                    </p>
                    <input type="submit" value="Add stop" />
                </fieldset>
            </form>
        </div>

        <?php
            PurposeDeleteJourney($voyage_id);
        ?>

        <p class="link"><a href="/">Back to main page</a></p>

    </body>
</html>
