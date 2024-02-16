<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/enums.php';
    
    // The player name needs to be set in request
    if (!isset($_GET['player_name']))
    {
        die(eRegisterQueueErrors::MISSING_PLAYER_NAME_IN_REQUEST);
    }

    // The player name can't be empty in request
    $player_name = $_GET['player_name'];
    if ($player_name == "")
    {
        die(eRegisterQueueErrors::PLAYER_NAME_CANT_BE_EMPTY);
    }

    // Check if parameter to unregister from queue is existing in request
    $player_unregister = false;
    if (isset($_GET['player_unregister']))
    {
        $player_unregister = true;
    }

    // Take original informations from queue such as queue_id and queue_status
    $sql = "SELECT * FROM table_queue
            ORDER BY queue_id DESC LIMIT 1;";

    $statement = $db->prepare($sql);
    $statement->execute();

    $table_queue_last_row = $statement->fetch();
    if (!$table_queue_last_row)
    {
        die(eRegisterQueueErrors::FAILED_FETCHING_QUEUE_STATUS);
    }

    $queue_id = $table_queue_last_row['queue_id'];
    $queue_status = $table_queue_last_row['queue_status'];

    // In case if player want to unregister from the queue
    // We unregister from queue only if the last row from table_player
    // Has the same name as the one in the request, then return success
    // Or we return an error message anyway
    if ($player_unregister)
    {
        $sql = "SELECT * FROM table_player
                ORDER BY player_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();

        $table_player_last_row = $statement->fetch();
        if (!$table_player_last_row)
        {
            die(eRegisterQueueErrors::FAILED_FETCHING_LAST_PLAYER);
        }

        $last_player_name = $table_player_last_row['player_name'];
        if ($last_player_name != $player_name)
        {
            die(eRegisterQueueErrors::FAILED_UNREGISTERING_PLAYER);
        }
        
        $sql = "DELETE FROM table_player 
                ORDER BY player_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();

        $queue_status -= 1;

        $sql = "UPDATE table_queue SET queue_status = :queue_status
                WHERE queue_id = :queue_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":queue_status", $queue_status);
        $statement->bindParam(":queue_id", $queue_id);
        $statement->execute();

        die(eRegisterQueueSuccess::SUCCESSFULLY_UNREGISTERED_PLAYER);
    }

    // If we aren't unregistering a player from queue
    // Then we will have to insert that player anyway
    if ($queue_status < eQueueStatus::QUEUE_READY)
    {
        $player_color = ePlayerColors::YELLOW;
        if ($queue_status == eQueueStatus::ONE_PLAYER_IN_QUEUE)
        {
            $player_color = ePlayerColors::RED;
        }

        $sql = "INSERT INTO table_player (player_name, player_color, queue_id) 
                VALUES (:player_name, :player_color, :queue_id);";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_name", $player_name);
        $statement->bindParam(":player_color", $player_color);
        $statement->bindParam(":queue_id", $queue_id);
        $statement->execute();

        $queue_status += 1;

        $sql = "UPDATE table_queue SET queue_status = :queue_status
                WHERE queue_id = :queue_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":queue_status", $queue_status);
        $statement->bindParam(":queue_id", $queue_id);
        $statement->execute();
        die(eRegisterQueueSuccess::SUCCESSFULLY_REGISTERED_PLAYER);
    }

    // We can launch the party if the queue is ready (2 players in queue)
    if ($queue_status == eQueueStatus::QUEUE_READY)
    {
        header('location: queue_create_party.php');
    }
?>