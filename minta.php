<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table, td, tr, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <?php
        $login = (isset($_REQUEST["login"]) ? $_REQUEST["login"] : "");
        $jelszo = (isset($_POST["jelszo"]) ? $_POST["jelszo"] : "");
        $berlet = (isset($_POST["berlet"]) ? $_POST["berlet"] : "0 Ft");
        $muvelet = (isset($_POST["muvelet"]) ? $_POST["muvelet"] : "belep");
        $users = array(
            "airamek" => "turbodiesel",
            "frisskenyer07" => "halacska",
            "kecsketank" => "ak47"
        );

        if (!isset($_SESSION["users"]) || $muvelet == "reset") $_SESSION["users"] = &$users;

        $belepett = false;
        if ($login != "" && $jelszo != "") switch($muvelet) 
        {
        case "belep":
            $belepett = (isset($_SESSION["users"][$login]) && $_SESSION["users"][$login] == $jelszo);
            break;
        case "reg":
            if (isset($_SESSION["users"][$login]))
            {
                echo "<script>alert(\"Már létezik ilyen felhasználó!\");</script>";
            }
            else
            {
                $_SESSION["users"][$login] = $jelszo;
            }
            break;
        case "torol":
            if (isset($_SESSION["users"][$login]) && $_SESSION["users"][$login] == $jelszo) unset($_SESSION["users"][$login]);
            break;
        }


        print "
        <script>
        function klikk() {
            ". ($belepett ? "document.title = \"KLIKK\"" : "") . "
        }
        </script>
        "
    ?>
</head>
<body>
    <?php
    print "<h1>Felhasználó</h1>";
    switch ($muvelet)
    {
    case "belep":
        print "<p style=\"color:" . ($belepett ? "green" : "red") . "\">".
        ($belepett ? "<b>$login</b> ($jelszo) bejelentkezett" : "Jelentkezzen be!") . "
        </p>";
        break;
    case "reg":
        print "<h1>Regisztráció</h1>";
        break;
    case "torol":
        print "<h1>Törlés</h1>";
        break;
    case "reset":
        print "<h1>Reset</h1>";
        break;
    }
    print "<button onclick=\"klikk()\">klikk</button>
    <mark>$berlet</mark>
    \n";
    echo "<br>";
    ksort($_SESSION["users"]);
    print("<table><tr><th>Név</th><th>Jelszó</th></tr>");
    foreach ($_SESSION["users"] as $user => $pass) {
        echo "<tr><td>$user</td> <td>$pass</td></tr>";
    }
    print("</table>");
    ?>
    <hr>
    <form action="minta.php" method="POST">
        <label for="login">Felhasználónév</label>
        <input type="text" name="login" id="login" autocomplete=off> <br>
        <label for="jelszo">Jelszó</label>
        <input type="text" name="jelszo" id="jelszo" autocomplete=off> 
        <br>
        <input type="hidden" name="berlet" value="50 Ft">
        <label for="muvelet">Művelet</label>
        <select name="muvelet" id="muvelet">
            <option value="belep">Belépés</option>
            <option value="reg">Regisztráció</option>
            <option value="torol">Törlés</option>
            <option value="reset">RESET</option>
        </select>
        <br>
        <input type="submit" value="Nyomjad">
    </form>
</body>
</html>