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

    function GetLastTableQueueRow()
    {
        global $db;
        $sql = "SELECT * FROM table_queue
            ORDER BY queue_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();

        $result = $statement->fetch();
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

    function UpdateQueueStatus($param_queue_id, $param_queue_status)
    {
        global $db;
        $sql = "UPDATE table_queue SET queue_status = :queue_status
                WHERE queue_id = :queue_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":queue_status", $param_queue_status);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();
    }

    function RegisterPlayerInTableQueue($param_player_name, $param_player_color, $param_queue_id)
    {
        global $db;
        $sql = "INSERT INTO table_player (player_name, player_color, queue_id) 
                VALUES (:player_name, :player_color, :queue_id);";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_name", $param_player_name);
        $statement->bindParam(":player_color", $param_player_color);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();
    }
?>

