<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Common/globals.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Fetch/get_player_turn_name_from_party_id_hfile.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/DBTables/table_party_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/DBTables/table_player_queue_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/DBTables/table_queue_party_hfile.php';
    
    function get_player_turn_name_from_party_id($param_party_id)
    {
        $local_party_status = GetPartyStatusFromId($param_party_id);
        if ($local_party_status == ePartyStatus::WINNER_PLAYER_1 || $local_party_status == ePartyStatus::WINNER_PLAYER_2)
        {
            header($HEADER_RELOCATION_START.'/Client/player_play_party.php');
            die(ePlayerPlayPartyErrors::ERROR_PARTY_ALREADY_FINISHED);
        }

        $local_player_color = ($local_party_status == ePartyStatus::TURN_PLAYER_1) ? eGridColors::PLAYER_1 : eGridColors::PLAYER_2;
        $local_queue_id = GetQueueIdFromPartyId($param_party_id);
        $local_player_name = GetPlayerNameFromQueueIdAndPlayerColor($local_queue_id, $local_player_color);
        return $local_player_name;
    }
?>