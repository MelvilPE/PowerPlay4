<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Common/globals.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Fetch/get_party_grid_decoded_from_party_id_hfile.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Include/DBTables/table_party_hfile.php';
    
    function get_party_grid_decoded_from_party_id($param_party_id)
    {
        $local_party_grid = GetPartyGridFromId($param_party_id);
        $result = json_decode($local_party_grid, true)['party_grid'];
        return $result;
    }
?>