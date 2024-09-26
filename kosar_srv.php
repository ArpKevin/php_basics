<?php
session_start();

if (isset($_GET["tipus"])) {
    $sum = 0;
    $kosarArray = array();

    foreach ($_SESSION["kosar"] as $termek => $adatok) {
        $tetelar = $adatok['egysegar'] * $adatok['mennyiseg'];
        $kosarArray[] = array(
            "termek_nev" => $termek,
            "egysegar" => $adatok['egysegar'],
            "mennyiseg" => $adatok['mennyiseg'],
            "tetelar" => $tetelar
        );
        $sum += $tetelar;
    }

    switch ($_GET["tipus"]) {
        case "HTML":
            print("<table>");
            foreach ($kosarArray as $item) {
                echo "<tr><td>Név: {$item['termek_nev']}</td><td>Egységár: {$item['egysegar']}</td><td>Mennyiség: {$item['mennyiseg']}</td><td>Termékár: {$item['tetelar']}</td></tr>";
            }
            echo "<tr><td colspan='3'>Összesen:</td><td>$sum</td></tr>";
            print("</table>");
            break;

        case "XML":
            header("Content-type: text/xml");
            print("<kosar>");
            foreach ($kosarArray as $item) {
                echo "<termek><termeknev>{$item['termek_nev']}</termeknev> <egysegar>{$item['egysegar']}</egysegar> <mennyiseg>{$item['mennyiseg']}</mennyiseg> <tetelar>{$item['tetelar']}</tetelar></termek>";
            }
            print("<osszeg>$sum</osszeg>");
            print("</kosar>");
            
            break; 

        case "JSON":
            header("Content-type: application/json; charset=UTF-8");
            echo json_encode(array("kosar" => $kosarArray, "osszeg" => $sum));
            break;

        default:
            break;
    }
}
?>