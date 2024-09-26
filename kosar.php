<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosar</title>
    <style>
        table, td, tr, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <?php
        $termek_nev = isset($_POST["termek_nev"]) ? $_POST["termek_nev"] : "";
        $egysegar = isset($_POST["egysegar"]) ? $_POST["egysegar"] : 0;
        $mennyiseg = isset($_POST["mennyiseg"]) ? $_POST["mennyiseg"] : 0;
        $muvelet = isset($_POST["muvelet"]) ? $_POST["muvelet"] : "felvesz";

        $kosar = array(
            "Alma" => array("egysegar" => 120, "mennyiseg" => 3),
            "Kenyér" => array("egysegar" => 300, "mennyiseg" => 2),
            "Tej" => array("egysegar" => 200, "mennyiseg" => 1)
        );

        if (!isset($_SESSION["kosar"]) || $muvelet == "reset") {
            $_SESSION["kosar"] = &$kosar;
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST")
        switch ($muvelet) {
            case "felvesz":
                if ($termek_nev != "" && $egysegar > 0 && $mennyiseg > 0) {
                    if (!isset($_SESSION["kosar"][$termek_nev])) {
                        $_SESSION["kosar"][$termek_nev] = array(
                            "egysegar" => $egysegar,
                            "mennyiseg" => $mennyiseg
                        );
                    } else {
                        echo "<script>alert('Ez a termék már létezik!');</script>";
                    }
                } else {
                    echo "<script>alert('Érvénytelen adatok! A név nem lehet üres, az egységárnak és mennyiségnek nagyobbnak kell lennie 0-nál.');</script>";
                }
                break;

            case "kivesz":
                if (isset($_SESSION["kosar"][$termek_nev])) {
                    unset($_SESSION["kosar"][$termek_nev]);
                } else {
                    echo "<script>alert('Ez a termék nem létezik a kosárban!');</script>";
                }
                break;
        }
    ?>
</head>
<body>
    <h1>Kosár</h1>

    <table>
        <tr><th>Termék név</th><th>Egységár (Ft)</th><th>Mennyiség</th></tr>
        <?php
        if (!empty($_SESSION["kosar"])) {
            foreach ($_SESSION["kosar"] as $termek => $adatok) {
                echo "<tr><td>$termek</td><td>{$adatok['egysegar']}</td><td>{$adatok['mennyiseg']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>A kosár üres!</td></tr>";
        }
        ?>
    </table>

    <hr>

    <form action="kosar.php" method="POST">
        <label for="termek_nev">Termék neve:</label>
        <input type="text" name="termek_nev" id="termek_nev" autocomplete="off"> <br>

        <label for="egysegar">Egységár:</label>
        <input type="number" name="egysegar" id="egysegar" min="1"> <br>

        <label for="mennyiseg">Mennyiség:</label>
        <input type="number" name="mennyiseg" id="mennyiseg" min="1"> <br>

        <label for="muvelet">Művelet:</label>
        <select name="muvelet" id="muvelet">
            <option value="felvesz">Felvesz</option>
            <option value="kivesz">Kivesz</option>
            <option value="reset">RESET</option>
        </select> <br>

        <input type="submit" value="Végrehajt">
    </form>

    <br>
    <a href="kosar_srv.php?tipus=HTML">HTML</a>
    <a href="kosar_srv.php?tipus=XML">XML</a>
    <a href="kosar_srv.php?tipus=JSON">JSON</a>
</body>
</html>