<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/connect.php';
    function GetPlayerColorFromId($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $local_player_row = $statement->fetch();
        $result = $local_player_row['player_color'];
        return $result;
    }

    function GetLastTablePlayerRow()
    {
        global $db;
        $sql = "SELECT * FROM table_player
                ORDER BY player_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();

        $result = $statement->fetch();
        return $result;
    }

    function RemoveLastTablePlayerRow()
    {
        global $db;
        $sql = "DELETE FROM table_player 
                ORDER BY player_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();
    }

    function RegisterPlayerInTableQueue($param_player_name, $param_player_color, $param_queue_id)
    {
        global $db;
        $sql = "INSERT INTO table_player (player_name, player_color, party_id, queue_id) 
                VALUES (:player_name, :player_color, :party_id, :queue_id);";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_name", $param_player_name);
        $statement->bindParam(":player_color", $param_player_color);
        $empty_party_id = 0;
        $statement->bindParam(":party_id", $empty_party_id);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();
    }

    function GetLastTablePlayerId()
    {
        $local_player_row = GetLastTablePlayerRow();
        $result = $local_player_row['player_id'];
        return $result;
    }
?>