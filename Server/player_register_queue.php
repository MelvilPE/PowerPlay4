<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/globals.php';
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/player_register_queue_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/player_play_party_hfile.php';

    $player_name = GetPlayerNameInRequest();
    if ($player_name == "")
    {
        die(eRegisterQueueErrors::MISSING_PLAYER_NAME_IN_REQUEST);
    }

    $player_unregister = IsPlayerUnregisterInRequest();

    $table_queue_last_row = GetLastTableQueueRow();
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
        $table_player_last_row = GetLastTablePlayerRow();
        if (!$table_player_last_row)
        {
            die(eRegisterQueueErrors::FAILED_FETCHING_LAST_PLAYER);
        }

        $last_player_name = $table_player_last_row['player_name'];
        if ($last_player_name != $player_name)
        {
            die(eRegisterQueueErrors::FAILED_UNREGISTERING_PLAYER);
        }

        $last_player_id = $table_player_last_row['player_id'];
        if (IsPlayerAlreadyInParty($last_player_id))
        {
            die(eRegisterQueueErrors::PLAYER_ALREADY_IN_PARTY);
        }
        
        RemoveLastTablePlayerRow();
        $queue_status -= 1;
        UpdateQueueStatus($queue_id, $queue_status);

        die(eRegisterQueueSuccess::SUCCESSFULLY_UNREGISTERED_PLAYER);
    }

    // If we aren't unregistering a player from queue
    // Then we will have to insert that player anyway
    if ($queue_status < eQueueStatus::QUEUE_READY)
    {
        $player_color = eGridColors::PLAYER_1;
        if ($queue_status == eQueueStatus::ONE_PLAYER_IN_QUEUE)
        {
            $player_color = eGridColors::PLAYER_2;
        }

        RegisterPlayerInTableQueue($player_name, $player_color, $queue_id);
        $queue_status += 1;
        UpdateQueueStatus($queue_id, $queue_status);

        $player_id = GetLastTablePlayerId();

        // We can launch the party if the queue is ready (2 players in queue)
        if ($queue_status == eQueueStatus::QUEUE_READY)
        {
            header('location: queue_create_party.php');
        }

        setcookie('player_id', $player_id, time() + 3600, '/');
        setcookie('player_name', $player_name, time() + 3600, '/');
        header('location: http://powerplay4/Client/player_register_queue.php');
        die(eRegisterQueueSuccess::SUCCESSFULLY_REGISTERED_PLAYER);
    }
?>