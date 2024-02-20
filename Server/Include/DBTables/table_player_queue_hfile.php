<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
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
            $each_player_id = $each_player['player_id'];
            $sql = "UPDATE table_player SET party_id = :party_id
                    WHERE player_id = :player_id;";

            $statement = $db->prepare($sql);
            $statement->bindParam(":party_id", $param_party_id);
            $statement->bindParam(":player_id", $each_player_id);
            $statement->execute();
        }
    }

    function GetPlayerNameFromQueueIdAndPlayerColor($param_queue_id, $param_player_color)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE queue_id = :queue_id AND player_color = :player_color;";

        $statement = $db->prepare($sql);
        $statement->bindParam(':queue_id', $param_queue_id);
        $statement->bindParam(':player_color', $param_player_color);
        $statement->execute();

        $local_player_row = $statement->fetch();
        $result = $local_player_row['player_name'];
        return $result;
    }
?>