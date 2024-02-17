<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';

    function GetLastPartyId()
    {
        global $db;
        $sql = "SELECT * FROM table_party
                ORDER BY party_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();

        $last_party_row = $statement->fetch();
        $result = $last_party_row['party_id'];
        return $result;
    }

    function SetQueuePlayersInParty($param_queue_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE queue_id = :queue_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();

        $players_in_party = $statement->fetchAll();
        
        $param_party_id = GetLastPartyId();
        foreach ($players_in_party as $each_player)
        {
            $sql = "INSERT INTO player_play_party (player_id, party_id) VALUES (:player_id, :party_id);";
            $each_player_id = $each_player['player_id'];
            $statement = $db->prepare($sql);
            $statement->bindParam(":player_id", $each_player_id);
            $statement->bindParam(":party_id", $param_party_id);
            $statement->execute();
        }
    }

    function IsPlayerAlreadyInParty($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM player_play_party
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $player_row = $statement->fetch();
        if (!$player_row)
        {
            return false;
        }
        return true;
    }
?>