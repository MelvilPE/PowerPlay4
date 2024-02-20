<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/player_play_party_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Fetch/get_winner_name_from_party_id_hfile.php';

    function get_winner_name_from_party_id($param_party_id)
    {	
        $local_party_status = GetPartyStatusFromId($param_party_id);
        if ($local_party_status != ePartyStatus::WINNER_PLAYER_1 && $local_party_status != ePartyStatus::WINNER_PLAYER_2)
        {
            die("ERROR_PARTY_NOT_FINISHED");
        }

        $player_color = ($local_party_status == ePartyStatus::WINNER_PLAYER_1) ? eGridColors::PLAYER_1 : eGridColors::PLAYER_2;
        $local_queue_id = GetQueueIdFromPartyId($param_party_id);
        $winner_name = GetPlayerNameFromQueueIdAndPlayerColor($local_queue_id, $player_color);
        return $winner_name;
    }
?>