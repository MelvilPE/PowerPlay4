<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Common/globals.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/queue_create_party_hfile.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_queue_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_party_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_player_queue_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_queue_party_hfile.php';

    // We want to create party only if queue is ready
    // It's more secure to check status before doing this
    $table_queue_last_row = GetLastTableQueueRow();
    if (!$table_queue_last_row)
    {
        header('location: http://powerplay4/Client/player_register_queue.php');
        die(eRegisterQueueErrors::FAILED_FETCHING_QUEUE_STATUS);
    }

    $queue_id = $table_queue_last_row['queue_id'];
    $queue_status = $table_queue_last_row['queue_status'];

    if ($queue_status != eQueueStatus::QUEUE_READY)
    {
        header('location: http://powerplay4/Client/player_register_queue.php');
        die(eCreatePartyErrors::QUEUE_NOT_READY);
    }

    // We can create a new party, since queue was ready
    $party_status = mt_rand(ePartyStatus::TURN_PLAYER_1, ePartyStatus::TURN_PLAYER_2);
    $party_grid = $EMPTY_PARTY_GRID_JSON;
    CreateNewPartyRow($party_status, $party_grid, $queue_id);
    SetQueuePlayersInParty($queue_id);

    // We can create a new queue, since party has been created
    CreateNewQueueRow();

    header('location: http://powerplay4/Client/player_play_party.php');
    die(eCreatePartySuccess::SUCCESSFULLY_CREATED_PARTY);
?>