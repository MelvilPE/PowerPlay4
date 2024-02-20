<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    function IsPlayerAlreadyInParty($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $player_row = $statement->fetch();
        if (!$player_row)
        {
            return false;
        }

        $local_party_id = $player_row['party_id'];
        if (!$local_party_id)
        {
            return false;
        }

        return true;
    }

    function GetPartyIdFromPlayerId($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $local_player_row = $statement->fetch();
        $result = $local_player_row['party_id'];
        return $result;
    }
?>