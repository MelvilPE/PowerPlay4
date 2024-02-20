<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
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