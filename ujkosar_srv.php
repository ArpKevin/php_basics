<?php
session_start();

if (isset($_GET["tipus"])) {
    $sum = 0;
    $kosarArray = array();

    // Check if the cart is set
    if (isset($_SESSION["kosar"]["tetelek"])) {
        foreach ($_SESSION["kosar"]["tetelek"] as $item) {
            $kosarArray[] = array(
                "termekid" => $item['termekid'],
                "termek_nev" => $item['termek_nev'],
                "egysegar" => $item['egysegar'],
                "mennyiseg" => $item['mennyiseg'],
                "tetelar" => $item['tetelar']
            );
            $sum += $item['tetelar']; // Sum the total price
        }
    }

    switch ($_GET["tipus"]) {
        case "HTML":
            echo "<table border='1'>";
            echo "<tr><th>Termék név</th><th>Egységár (Ft)</th><th>Mennyiség</th><th>Termékár (Ft)</th></tr>";
            foreach ($kosarArray as $item) {
                echo "<tr>
                        <td>{$item['termek_nev']}</td>
                        <td>{$item['egysegar']}</td>
                        <td>{$item['mennyiseg']}</td>
                        <td>{$item['tetelar']}</td>
                      </tr>";
            }
            echo "<tr><td colspan='3'>Összesen:</td><td>$sum</td></tr>";
            echo "</table>";
            break;

        case "XML":
            header("Content-type: text/xml");
            echo "<?xml version='1.0' encoding='UTF-8'?>";
            echo "<kosar>";
            foreach ($kosarArray as $item) {
                echo "<termek>
                        <termekid>{$item['termekid']}</termekid>
                        <termeknev>{$item['termek_nev']}</termeknev>
                        <egysegar>{$item['egysegar']}</egysegar>
                        <mennyiseg>{$item['mennyiseg']}</mennyiseg>
                        <tetelar>{$item['tetelar']}</tetelar>
                      </termek>";
            }
            echo "<osszeg>$sum</osszeg>";
            echo "</kosar>";
            break;

        case "JSON":
            header("Content-type: application/json; charset=UTF-8");
            echo json_encode(array("kosar" => $kosarArray, "osszeg" => $sum));
            break;

        default:
            echo "Invalid request type.";
            break;
    }
}
?>
