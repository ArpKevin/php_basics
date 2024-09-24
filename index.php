<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        $login = (isset($_REQUEST["login"]) ? $_REQUEST["login"] : "-");
        $jelszo = (isset($_POST["jelszo"]) ? $_POST["jelszo"] : "-");
        $berlet = (isset($_POST["berlet"]) ? $_POST["berlet"] : "0 Ft");
        $muvelet = (isset($_POST["muvelet"]) ? $_POST["muvelet"] : "belep");
        $users = array(
            "airamek" => "turbodiesel",
            "frisskenyer07" => "halacska",
            "kecsketank" => "ak47"
        );

        ksort($users);

        var_dump($users);
        $belepett = false;

        switch ($muvelet){
            case "belep":
                $belepett = (isset($users[$login]) && $users[$login] == $jelszo);
                break;
            case "reg":
                if (isset($users[$login]))
                    echo "<script>alert(\"Már létezik ilyen felhasználó!\");</script>";
                elseif ($jelszo != '') {
                    $users[$login] = $jelszo;
                }
                break;
            case "kivesz":
                print "<h2>Kivesz (töröl)</h2>";
                if (!(isset($users[$login]) && $users[$login] == $jelszo)) {
                    print "hibás login vagy jelszó";
                } else {
                    unset($users[$login]);
                }
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
    if ($muvelet == "belep")
    {
        print "<p style=\"color:" . ($belepett ? "green" : "red") . "\">".
        ($belepett ? "<b>$login</b> ($jelszo) bejelentkezett" : "Jelentkezzen be!") . "
        </p>";
    }
    elseif ($muvelet == "reg")
    {
        print "<h1>Regisztráció</h1>";
    }
    print "<button onclick=\"klikk()\">klikk</button>
    <mark>$berlet</mark>
    \n";
    echo "<br>";
    foreach ($users as $user => $pass) {
        echo "$user - $pass <br>";
    }
    ?>
    <hr>
    <form action="index.php" method="POST">
        <label for="login">Felhasználónév</label>
        <!-- Preserve the entered login value -->
        <input type="text" name="login" id="login" autocomplete=off value="<?php echo isset($_REQUEST['login']) ? $_REQUEST['login'] : ''; ?>"> <br>

        <label for="jelszo">Jelszó</label>
        <!-- Preserve the entered password value -->
        <input type="text" name="jelszo" id="jelszo" autocomplete=off value="<?php echo isset($_POST['jelszo']) ? $_POST['jelszo'] : ''; ?>"> 
        <br>

        <input type="hidden" name="berlet" value="50 Ft">

        <label for="muvelet">Művelet</label>
        <select name="muvelet" id="muvelet">
            <option value="belep" <?php echo ($muvelet == 'belep') ? 'selected' : ''; ?>>Belépés</option>
            <option value="reg" <?php echo ($muvelet == 'reg') ? 'selected' : ''; ?>>Regisztráció</option>
            <option value="kivesz" <?php echo ($muvelet == 'kivesz') ? 'selected' : ''; ?>>Kivesz</option>
        </select>
        <br>
        <input type="submit" value="Nyomjad">
    </form>
</body>
</html>