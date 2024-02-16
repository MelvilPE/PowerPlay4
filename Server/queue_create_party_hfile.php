<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/player_register_queue_hfile.php';

    function CreateNewPartyRow($param_party_status, $param_party_grid, $param_queue_id)
    {
        global $db;
        $sql = "INSERT INTO table_party (party_status, party_grid, queue_id)
            VALUES (:party_status, :party_grid, :queue_id);";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_status", $param_party_status);
        $statement->bindParam(":party_grid", $param_party_grid);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();
    }

    function CreateNewQueueRow()
    {
        global $db;
        $sql = "INSERT INTO table_queue (queue_status) 
            VALUES (:queue_status);";

        $statement = $db->prepare($sql);
        $param_queue_status = eQueueStatus::NO_PLAYERS_IN_QUEUE;
        $statement->bindParam(":queue_status", $param_queue_status);
        $statement->execute();
    }
?>