<?php

    $user = 'root';
    $pass = 'root';

    try {
        $db = new PDO ('mysql:host=localhost;dbname=santiane', 'root', 'root');
    } catch (PDOException $e) {
        echo "Error :" . $e->getMessage() . "<br/>";
        die;
    }

    class websiteTest extends \PHPUnit\Framework\TestCase {

        public function testAddVoyage() {
            global $db;
            $this->db = $db;
            $_POST['name'] = 'Voyage3';
            require("html/voyage_code.php");
            $result = addVoyage();
            $this->assertTrue($result);
        }

        public function testAddEtape() {
            global $db;
            $this->db = $db;
            $_POST['name'] = 'Voyage3';
            $_SESSION['voyage_name'] = 'Voyage3';
            $_POST['type'] = 'train';
            $_POST['number'] = '12';
            $_POST['departure'] = 'New York JFK';
            $_POST['arrival'] = 'Paris CDG';
            require("html/etape_added_code.php");
            $voyage_id = getVoyageIdFromSession();
            $result = addEtape($voyage_id);
            $this->assertTrue($result);
        }

        public function testDeleteVoyage() {
            global $db;
            $this->db = $db;
            $_POST['confirm_delete_journey'] = 'true';
            $this->id = getVoyageIdFromSession();
            $result = purposeDeleteJourney($this->id);
            $this->assertTrue($result);
        }

    }

?>