<!DOCTYPE html>
<?php

    require("index_code.php");

?>
<html>
    <head>
        <title>Main page - Travels list</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="style.php" media="screen"/>
    </head>

    <body>

        <div class="form">
            <form method="post" action="voyage.php">
                <fieldset>
                    <legend>Add a travel</legend>
                    <p>
                        <label for="name">Name of the travel:</label>
                        <input type="text" name="name" id="name" class="required" required />
                    </p>
                    <input type="submit" value="Add travel" />
                </fieldset>
            </form>
        </div>

        <br>

        <div class="journey_list">
            <fieldset>
                <legend>Travels list:</legend>
                <p>
                    <?php
                        voyagePrint();
                    ?>
                </p>
            </fieldset>
        </div>

    </body>
</html>