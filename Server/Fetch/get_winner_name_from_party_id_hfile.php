<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    function GetQueueIdFromPartyId($param_party_id)
    {
        global $db;
        $sql = "SELECT * FROM table_party
                WHERE party_id = :party_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(':party_id', $param_party_id);
        $statement->execute();

        $local_party_row = $statement->fetch();
        $result = $local_party_row['queue_id'];
        return $result;
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