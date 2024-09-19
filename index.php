<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    $login = isset($_REQUEST['login']) ? $_REQUEST['login'] : "-";
    $pass = isset($_POST['jelszo']) ? $_POST['jelszo'] : "-";
    $berlet = isset($_POST['berlet']) ? $_POST['berlet'] : "0 Ft";
    $belepett = (isset($users[$login]) && $users[$login] == $pass);
    $belepett = false;
    if ($belepett) print "
    <script>
        function klikk(){
        document.title = 'KLIKK';}
    </script>";
    ?>
</head>
<body>
<?php

$color = $belepett ? 'green' : 'red';
$message = $belepett ? "<b>$login</b> ($pass) bejelentkezett." : "Jelentkezzen be!";

echo "<p style='color: $color;'>$message</p>";

echo "<button onclick=klikk()>click</button>\n";

echo "<mark>$berlet</mark>";

$users = array("valaki1"=>"ok1", "valaki2"=>"ok2", "valaki3"=>"ok3");

echo "<br>";

var_dump($users);
echo "<br>";
foreach ($users as $l => $j){
    print "$l = $j<br>";
    if($l == $login && $j == $pass){
        $belepett = true;
    }
}
?>



<hr>
<form action="index.php" method="POST">
    Login (valaki1): <input type="text" id="login" name="login" value="valaki1" autocomplete=off>
    Jelszó: <input type="text" id="pass" name="pass" value="" autocomplete=off>
    Rejtett: <input type="hidden" name="bérlet" value="50 Ft">
    <input type="submit" value="Submit">
</form>

</body>
</html>