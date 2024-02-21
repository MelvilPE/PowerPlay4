<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Common/globals.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Fetch/get_party_id_from_player_id_hfile.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_player_party_hfile.php';
    
    function get_party_id_from_player_id($param_player_id)
    {
        $result = GetPartyIdFromPlayerId($param_player_id);
        return $result;
    }
?>