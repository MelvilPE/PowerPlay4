<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Common/globals.php';

    function GetPlayerGridInRequest()
    {
        $result = "";
        if (!isset($_GET['player_grid']))
        {
            return $result;
        }

        $result = $_GET['player_grid'];
        return $result;
    }

    function GetPlayerGiveUpInRequest()
    {
        $result = false;
        if (!isset($_GET['player_give_up']))
        {
            return $result;
        }

        $result = $_GET['player_give_up'];
        return $result;
    }

    /* We verify the grid lines
     * We verify the grid columns
     * We verify the diagonals
     * We verify the reversed diagonals
     * We return the player number if party is finished
     * We return the empty color if party continues
     */
    function IsGridPartyFinished($param_party_id)
    {
        $local_party_grid = GetPartyGridFromId($param_party_id);
        $local_party_grid = json_decode($local_party_grid, true)['party_grid'];

        for ($rowindex = 0; $rowindex < count($local_party_grid); $rowindex++)
        {
            for ($colindex = 0; $colindex < count($local_party_grid[0]) - 3; $colindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex][$colindex + 1] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex][$colindex + 2] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex][$colindex + 3] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        for ($colindex = 0; $colindex < count($local_party_grid[0]); $colindex++)
        {
            for ($rowindex = 0; $rowindex < count($local_party_grid) - 3; $rowindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 1][$colindex] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 2][$colindex] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 3][$colindex] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        for ($rowindex = 0; $rowindex < count($local_party_grid) - 3; $rowindex++)
        {
            for ($colindex = 0; $colindex < count($local_party_grid[0]) - 3; $colindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 1][$colindex + 1] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 2][$colindex + 2] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 3][$colindex + 3] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        for ($rowindex = 0; $rowindex < count($local_party_grid) - 3; $rowindex++)
        {
            for ($colindex = 3; $colindex < count($local_party_grid[0]); $colindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 1][$colindex - 1] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 2][$colindex - 2] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 3][$colindex - 3] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        return eGridColors::EMPTY;
    }
?>