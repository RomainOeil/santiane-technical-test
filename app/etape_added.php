<?php

    require("etape_added_code.php");

?>
<html>
    <head>
        <link rel="stylesheet" href="style.php" media="screen"/>
    </head>

    <body>
        <div class="etape_added">
                <?php
                    $sucess = addEtape($voyage_id);
                    if ($sucess == true) {
                        echo "Stop added for $_SESSION[voyage_name]<br/>";
                    } else {
                        echo "Stop not added<br/>";
                    }
                ?>
                <p class="link"><a href="/etape.php">Back to stops list</a></p>
        </div>
    </body>
</html>