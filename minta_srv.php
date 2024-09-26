<?php
session_start();
if (isset($_GET["tipus"])) switch($_GET["tipus"]) 
{
    case "HTML":
        print("<table>");
        foreach ($_SESSION["users"] as $user => $pass) {
            echo "<tr><td>$user</td> <td>$pass</td></tr>";
        }
        print("</table>");
        break;
    case "XML":
        header("Content-type: text/xml");
        print("<users>");
        foreach ($_SESSION["users"] as $user => $pass) {
            echo "<user><name>$user</name> <password>$pass</password></user>";
        }
        print("</users>");
        break;
        case "JSON":
            header("Content-type: application/json; charset=UTF-8");
            
            $usersArray = array();
            foreach ($_SESSION["users"] as $user => $pass) {
                $usersArray[] = array("login" => $user, "jelszo" => $pass);
            }
            
            echo json_encode(array("felhasznalok" => $usersArray));
            break;
        default:
            break;
}
?>