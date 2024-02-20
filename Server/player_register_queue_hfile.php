<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    function GetPlayerNameInRequest()
    {
        $result = "";
        if (!isset($_GET['player_name']))
        {
            return $result;
        }

        $result = $_GET['player_name'];
        $result = htmlspecialchars($result);
        return $result;
    }

    function IsPlayerUnregisterInRequest()
    {
        $result = false;
        if (isset($_GET['player_unregister']))
        {
            $result = true;
        }

        return $result;
    }
?>

