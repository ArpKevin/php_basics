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
        // Sample product data
        $products = array(
            1 => array("termek_nev" => "Alma", "egysegar" => 120),
            2 => array("termek_nev" => "Kenyér", "egysegar" => 300),
            3 => array("termek_nev" => "Tej", "egysegar" => 200)
        );

        $mennyiseg = isset($_POST["mennyiseg"]) ? $_POST["mennyiseg"] : 0;
        $muvelet = isset($_POST["muvelet"]) ? $_POST["muvelet"] : "felvesz";

        // Initialize the shopping cart if it doesn't exist
        if (!isset($_SESSION["kosar"]) || $muvelet == "reset") {
            $_SESSION["kosar"] = array("szumma" => 0, "tetelek" => array());
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            switch ($muvelet) {
                case "felvesz":
                    $termekid = $_POST["termek_id"];
                    if (isset($products[$termekid]) && $mennyiseg > 0) {
                        $termek = $products[$termekid];
                        $termek_nev = $termek["termek_nev"];
                        $egysegar = $termek["egysegar"];
                        $tetelar = $egysegar * $mennyiseg;

                        // Check if the product already exists in the cart
                        $found = false;
                        foreach ($_SESSION["kosar"]["tetelek"] as &$item) {
                            if ($item['termekid'] == $termekid) {
                                $item['mennyiseg'] += $mennyiseg; // Append quantity
                                $item['tetelar'] += $tetelar; // Update total price
                                $found = true;
                                break;
                            }
                        }

                        // If product not found in the cart, add it as a new item
                        if (!$found) {
                            $_SESSION["kosar"]["tetelek"][] = array(
                                "termekid" => $termekid,
                                "termek_nev" => $termek_nev,
                                "egysegar" => $egysegar,
                                "mennyiseg" => $mennyiseg,
                                "tetelar" => $tetelar
                            );
                        }
                    } else {
                        echo "<script>alert('Érvénytelen adatok!');</script>";
                    }
                    break;

                case "kivesz":
                    // Remove item from the cart
                    $termekid = $_POST["termek_id_remove"];
                    $found = false;
                    foreach ($_SESSION["kosar"]["tetelek"] as $key => $item) {
                        if ($item['termekid'] == $termekid) {
                            unset($_SESSION["kosar"]["tetelek"][$key]);
                            $found = true;
                            break; // Remove the first matching item
                        }
                    }
                    if (!$found) {
                        echo "<script>alert('Ez a termék nem létezik a kosárban!');</script>";
                    }
                    break;
            }
        }
    ?>
</head>
<body>
    <h1>Kosár</h1>

    <table>
        <tr><th>Termék név</th><th>Egységár (Ft)</th><th>Mennyiség</th><th>Termékár (Ft)</th></tr>
        <?php
        if (!empty($_SESSION["kosar"]["tetelek"])) {
            foreach ($_SESSION["kosar"]["tetelek"] as $item) {
                echo "<tr><td>{$item['termek_nev']}</td><td>{$item['egysegar']}</td><td>{$item['mennyiseg']}</td><td>{$item['tetelar']}</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>A kosár üres!</td></tr>";
        }
        ?>
    </table>

    <hr>

    <form action="ujkosar.php" method="POST">
        <label for="termek_id">Termék neve:</label>
        <select name="termek_id" id="termek_id">
            <?php foreach ($products as $id => $product): ?>
                <option value="<?php echo $id; ?>"><?php echo $product["termek_nev"]; ?></option>
            <?php endforeach; ?>
        </select> <br>

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

    <hr>

    <h2>Termék eltávolítása a kosárból</h2>
    <form action="ujkosar.php" method="POST">
        <label for="termek_id_remove">Termék neve:</label>
        <select name="termek_id_remove" id="termek_id_remove">
            <?php foreach ($_SESSION["kosar"]["tetelek"] as $item): ?>
                <option value="<?php echo $item['termekid']; ?>"><?php echo $item['termek_nev']; ?></option>
            <?php endforeach; ?>
        </select> <br>

        <input type="hidden" name="muvelet" value="kivesz">
        <input type="submit" value="Eltávolít">
    </form>

    <br>
    <a href="ujkosar_srv.php?tipus=HTML">HTML</a>
    <a href="ujkosar_srv.php?tipus=XML">XML</a>
    <a href="ujkosar_srv.php?tipus=JSON">JSON</a>
</body>
</html>
